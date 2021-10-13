<?php

use cr_repo\Repository;

require_once 'lib/Repository.php';
require_once 'lib/phpCrossRef.php';

/**
 * @author			Julian Bogdani <jbogdani@gmail.com>
 * @copyright		BraDypUS 2007-2013
 * @license			MIT, See LICENSE file
 * @since			Jun 11, 2013
 */

class crossRef extends Controller
{
  private static $username;
  private static $password;
  private static $depositor_name;
  private static $depositor_email;
  private static $registrant;
  private static $sections;
  private static $proccessPrefix;
  private static $volumes;
  private static $loaded = false;

  public function admin()
  {
    self::loadcfg();

    if (!$_SESSION['user_admin']) {
      echo '<p class="lead bg-danger" style="padding: 10px;">Sorry, only administrators can register DOIs</p>';
      return;
    }
    $params = func_get_args();

    list($action, $first, $second) = $params;

    // No params: output select
    if (!$action) {
      echo $this->render('crossRef','select_year', [
        'available_volumes' => self::$volumes,
        'cfg' => file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'cfg.json')
      ]);
      return;
    }

    if ($action === 'showReport') {
      echo $this->render('crossRef','showReport', [
        'year' => $first,
        'html' => self::preProcess($first)
      ]);
      return;
    }
    
    if ($action === 'buildXML') {
      // Build XML
      $xml = self::process($first, $second);

      $tmpfname = tempnam(sys_get_temp_dir(), 'crossRef');
      $handle = fopen($tmpfname, "w");
      fwrite($handle, $xml);
      fclose($handle);

      echo $this->render('crossRef','confirmBeforeSend', [
        'tmpfname' => $tmpfname,
        'xml' => $xml
      ]);
      return;
    }

    if ($action === 'submit') {
      echo $this->render('crossRef','showResponse', [
        'response' => self::upload($first, $second)
      ]);
      return;
    }
  }


  private static function loadcfg()
  {
    if ( !self::$loaded ) {

      $out = new Out($_GET);
      $metadata = $out->getMD();
      
      self::$username = $metadata->crossref['username'];
      self::$password = $metadata->crossref['password'];
      self::$depositor_name = $metadata->publisher;
      self::$depositor_email = $metadata->publisher_email;
      self::$registrant = $metadata->publisher;
      self::$sections = array_map(function($e){
        return $e['spec'];
      }, $metadata->sets);
      self::$proccessPrefix = $metadata->crossref['limit2prefix'];
      self::$volumes = $metadata->publishedVolumes;

      if (!self::$username) {
        throw new Exception('Missing username in configuration file');
      }
      if (!self::$password) {
        throw new Exception('Missing password in configuration file');
      }
      if (!self::$depositor_name) {
        throw new Exception('Missing or invalid depositor name in configuration file');
      }
      if (!self::$depositor_email) {
        throw new Exception('Missing or invalid depositor email in configuration file');
      }
      if (!self::$registrant) {
        throw new Exception('Missing or invalid registrant in configuration file');
      }
      if (!self::$sections || !is_array(self::$sections)) {
        throw new Exception('Missing or invalid sections in configuration file');
      }
      if (!self::$proccessPrefix) {
        throw new Exception('Missing or invalid proccessPrefix in configuration file');
      }
      if (!self::$volumes || !is_array(self::$volumes)) {
        throw new Exception('Missing or invalid volumes in configuration file');
      }
      self::$loaded = true;
    }
  }
  public static function upload($file, $test = false)
  {
    self::loadcfg();

    // Initialize crossRef object
    $cr = new cr_repo\phpCrossRef(self::$username, self::$password);

    return $cr->deposit($file, $test);
  }

  private static function buildRepo($year)
  {
    self::loadcfg();

    foreach (self::$volumes as $y => $i) {
      if ($y == $year) {
        $issue = $i;
      }
    }

    try {
      // start repo:
      $repo = new cr_repo\Repository();

      // create article metadata
      $articles = new cr_repo\Article();

      // start OUT object
      $out = new Out($_GET);

      $md_repo = $out->getMD();

      // repository data
      $repo
        ->setDepositor(self::$depositor_name, self::$depositor_email)
        ->setRegistrant(self::$registrant)
        ->setJournalMetadata(
          $md_repo->getRepositoryName(),    // Full title
          $md_repo->getISSN(),        // ISSN
          $md_repo->getJournalDoi(), // DOI
          $md_repo->getURL(),          // 'URL RIVISTA',
          $md_repo->getRepositoryShortName()  // 'NOME RIVISTA'
        )
        //optional
        ->setJournalIssue($year . '-01-01', $issue);

      foreach (self::$sections as $sez) {

        $data = $out->getArticlesByTag($sez, $year, [0, 200]);

        if (is_array($data) && !empty($data)) {

          foreach ($data as $art) {
            if (
              $art['doi']
              &&
              !empty($art['doi'])
              &&
              preg_match('/' . self::$proccessPrefix . '/', $art['doi'])
            ) {
              self::addArticle($art, $articles, $md_repo);
            }
          }
        }
        $data = [];
      }

      // add article to repo object
      $repo->setArticle($articles);

      return $repo;
    } catch (DOMException $e) {
      return var_export($e, 1);
    } catch (Exception $e) {
      return var_export($e, 1);
    }
  }

  public static function preProcess($year)
  {
    self::loadcfg();

    // Initialize crossRef object
    $cr = new cr_repo\phpCrossRef(self::$username, self::$password);

    $repo = self::buildRepo($year);

    $html = '<ul>';

    foreach ($repo->getArticles() as $art) {
      if ($cr->isDoiRegistered($art['doi_id'])) {
        $html .= '<li class="text-success">DOI: ' . $art['doi_id'] . ' (<strong>' . $art['title'] . '</strong>), is already present in CrossRef database</li>';
      } else {
        $html .= '<li class="text-danger">DOI: ' . $art['doi_id'] . ' (<strong>' . $art['title'] . '</strong>) is not present in CrossRef database</li>';
      }
    }

    return '</ul>' . $html;
  }

  /**
   * 
   * @param string $year
   * @param boolean $update
   * @return string
   */
  public static function process($year, $update = false)
  {
    try {

      self::loadcfg();

      // Initialize crossRef object
      $cr = new cr_repo\phpCrossRef(self::$username, self::$password);

      $repo = self::buildRepo($year);

      // Add Repo
      $cr->addRepository($repo)->buildXML($update);

      return $cr->getXML();
    } catch (DOMException $e) {
      return var_export($e, 1);
    } catch (Exception $e) {
      return var_export($e, 1);
    }
  }


  /**
   * 
   * @param array $art array with article data
   * @param cr_repo\Article $articles
   * @param Metadata $md_repo
   * @return void|\cr_repo\Article
   */
  private static function addArticle($art, cr_repo\Article $articles, Metadata $md_repo)
  {
    if (!$art['doi'] || $art['doi'] < 1) {
      return;
    }

    if ($art['author'] && $art['author'] !== '') {
      $auths = \utils::csv_explode($art['author']);

      if (is_array($auths)) {
        foreach ($auths as $a) {
          $a_data = \utils::csv_explode($a, ' ');
          $name = $a_data[0];
          unset($a_data[0]);
          $surname = implode(' ', $a_data);

          $articles->setAuthor($name, $surname);
          unset($a_data);
        }
      }
    }


    $articles
      ->setTitle($art['title'])
      ->setPublishData(
        $md_repo->getDoiPrefix() . $art['doi'],
        $art['full_url'],
        $art['publish']
      )
      ->setLanguage('it')
      /*
			->setCitations('10.1234/ref1', 'qualcosa')
			->setCitations('10.1234/ref2')
			->setCitations('10.1234/ref3')
			->setCitations('10.1234/ref4')
			*/
      ->close();
    return $articles;
  }

}
