<?php
/**
 * Manages comuunications with CrossRef system
 *
 * @author			Julian Bogdani <jbogdani@gmail.com>
 * @copyright		BraDypUS 2007-2013
 * @license			All rights reserved
 * @since			Apr 17, 2013
 */

namespace cr_repo;

require_once 'xml.php';
require_once 'Journal.php';



class phpCrossRef
{
	private $doc, $body, $repo, $username, $password;

	/**
	 * Initializes the class and sets username and password
	 * @param string $username		CrossRef member username
	 * @param string $password		CrossRef member password
	 */
	public function __construct($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
	}

	/**
	 * Loads an instance of object Repository with main data to process
	 * @param Repository $repo
	 * @return \cr_repo\phpCrossRef
	 */
	public function addRepository(Repository $repo)
	{
		$this->repo = $repo;
		return $this;
	}

	/**
	 * Creates Head Eelemt for Uploading Query
	 * @return DOMElement
	 */
	private function head()
	{
		$head = $this->doc->createElement('head');

		xml::appendElement($head, 'doi_batch_id', 'BDUS_' . time());

		xml::appendElement($head, 'timestamp', date('YmdGis'));

		$depositor = new \DOMElement('depositor');

		$head->appendChild($depositor);

		$depositor_data = $this->repo->getDepositor();

		xml::appendElement($depositor, 'name', $depositor_data['name']);

		xml::appendElement($depositor, 'email_address', $depositor_data['email']);

		xml::appendElement($head, 'registrant', $this->repo->getRegistrant());

		return $head;
	}

	/**
	 * Creates Root element for uploading query
	 * @return DOMElement
	 */
	private function root()
	{
		$root = $this->doc->createElementNS('http://www.crossref.org/schema/4.3.0', 'doi_batch');
		//$root = $this->doc->createElement('doi_batch');

		$root->setAttribute('version', '4.3.0');

		$root->setAttribute('xmlns', 'http://www.crossref.org/schema/4.3.0');

		$root->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');

		$root->setAttribute('xsi:schemaLocation', 'http://www.crossref.org/schema/4.3.0 http://www.crossref.org/schema/deposit/crossref4.3.0.xsd');

		return $root;
	}

	/**
	 * Builds a CrossRef upload XML structure from the repository object
	 * @param boolean $updateDOI if true (default is false) ALL articles will be processed, and CrossRef metadata will be updated
	 * @return \cr_repo\phpCrossRef
	 */
	public function buildXML($updateDOI = false)
	{
		$this->doc = new \DOMDocument('1.0', 'utf-8');

		$this->doc->formatOutput = true;

		$root = $this->root();

		$this->doc->appendChild($root);

		$root->appendChild($this->head());

		$body = $this->doc->createElement('body');

		$root->appendChild($body);

		$journalData = $this->getJournal($updateDOI);
		if ($journalData) {
			$body->appendChild($journalData);
		}

		return $this;
	}

	/**
	 * Maps Journal object to CrossRef XML structure for metadata upload
	 * @param boolean $updateDOI if true (default is false) ALL articles will be processed, and CrossRef metadata will be updated
	 * @return DOMElement
	 */
	private function getJournal($updateDOI = false)
	{
		$journal_obj = new Journal($this->doc);

		/**
		 * Create new Journal
		 */
		$journal = $journal_obj->create_journal();

		/**
		 * Add journal_metadata
		 */
		$metadata = $this->repo->getJournalMetadata();
		if ($metadata) {
			$journal->appendChild($journal_obj->metadata($metadata));
		}

		/**
		 * Add journal_issue
		 */
		$issue_data = $this->repo->getJournalIssue();
		if ($issue_data) {
			$journal->appendChild($journal_obj->issue($issue_data));
		}

		/**
		 * Add Journal articles using articles repository
		 */
		$articles_data = $this->repo->getArticles();
		if ($articles_data && is_array($articles_data)) {
			foreach ($articles_data as $data) {
				if ($updateDOI) {
					$journal->appendChild($journal_obj->articles($data));
				} else {
					if (!$this->isDoiRegistered($data['doi_id'])) {
						$journal->appendChild($journal_obj->articles($data));
					} else {
						echo '<p>Article <strong>' . $data['title'] . ' (doi: ' . $data['doi_id'] . ')</strong> is already present in Crossref</p>';
					}
				}
			}
		}


		return $journal;
	}

	/**
	 * Validates XML (derivating from phpCrossRef::build)
	 * This is not working well actually
	 * @return boolean
	 */
	public function validate()
	{
		libxml_use_internal_errors(true);

		if (!$this->doc->schemaValidate('http://www.crossref.org/schema/deposit/crossref4.3.0.xsd')) {
			var_dump(libxml_get_errors());
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Returns or echoes the XML
	 * @param boolean $echo if true hte XML will be echoed, otherwise will be returned
	 */
	public function getXML($echo = false)
	{
		if ($echo) {
			header("Content-Type: text/xml; charset=utf-8");
			echo $this->doc->saveXML();
		} else {
			return $this->doc->saveXML();
		}


	}

	/**
	 * Checks CrossRef repository if a specific DOI is already registered
	 * @param strin $doi	DOI string
	 * @return boolean
	 */
	public function isDoiRegistered($doi)
	{
		$curl = new \Curl\Curl();
		$curl->get('https://doi.crossref.org/servlet/query?pid=' . $this->username . ':' . $this->password . '&noredirect=true&id=' . $doi);
		$arr = explode('|', $curl->response);

		unset($arr[9]);

		foreach($arr as $k => &$a) {
			if ($a == '' || !$a || $a == 0) {
				unset($arr[$k]);
			}
		}

		return !empty($arr);
	}

	/**
	 * Desposits a well formated XML metadata file to CrossRef and returnes response
	 * @param string $xml_file path to XML file
	 * @param boolean $test	 if true only test mode will be used and no metadata will be sent
	 * @return string
	 */
	public function deposit($xml_file, $test = false)
	{
		$url = 'https://' . ($test ? 'test' : 'doi') . '.crossref.org/servlet/deposit?login_id=' . $this->username . '&login_passwd=' . $this->password;

		$post = [
				'operation' => 'doMDUpload',
				'fname'	=> '@' . $xml_file,
		];

		$curl = new \Curl\Curl();

		$resp = $curl->post($url, $post);

		$curl->close();

		return $curl->response;
	}

  public function deposit1($xml_file, $test = false)
  {
    $url = 'https://api.crossref.org/deposits' . ($test ? '?test=true' : '');
		$post = [
      'fname'	=> '@' . $xml_file
    ];

    $curl = new \Curl\Curl();
	$curl->setHeader('Content-Type', 'application/vnd.crossref.deposit+xml');
	$curl->setBasicAuthentication($this->username, $this->password);
	$curl->post($url, $post);
    return $curl->response;
  }
}
