<?php
/**
 * @author			Julian Bogdani <jbogdani@gmail.com>
 * @copyright		BraDypUS 2007-2013
 * @license			All rights reserved
 * @since			Apr 17, 2013
 * 
 * $data = array
 * 	depositor = array
 * 		name => $name,
 * 		email => $emai;
 * 
 * 	registrant => $registrant;
 * 
 * 	journal_metadata = array
 * 		full_title => $full_title,
 * 		abbrev_title => $abbrev_title,
 * 		issn_media_type => $issn_media_type,
 * 		issn => $issn,
 * 		doi_data => array
 * 			doi => $doi,
 * 			resource => $doi_resource
 *	
 *	journal_issue =  array
 *		publication_date => array
 *			media_type => $media_type,
 *			month => $month,
 *			day => $day,
 *			year' => $year
 *		volume'=> array
 *			volume => $volume
 *		issue => $issue,
 *		special_numbering => $special_number
 *
 *	articles => array
 *		0 => array
 *			publication_type => 'full_text', // optional, abstract_only | full_text | bibliographic_record, default: full_text
 *			language => 'it', //optional
 *			title' => 'Questo è il titolo', // required
 *			subtitle' => 'Questo è il sotto titolo', // optional
 *			publication_date' => array
 *				media_type' => 'online', // optional, online | other | print, default: print
 *				month' => '4', // optional
 *				day' => '18', // optional
 *				year' => '2013'
 *			first_page' => '1', // optional
 *			last_page' => '10', // optional
 *			authors' => array
 *				0 => array
 *					name' => 'Pinco', 'surname' => 'Pallo'
 *				...
 *			publication' => array
 *				type' => 'online',
 *				month' => '04',
 *				day' => '18',
 *				year' => '2013'
 *			doi_id' => '10.1234/ciao/ciao',
 *			doi_resource' => 'http://thishost/thispage',
 *			citations' => array
 *				0 => array
 *					doi = 10.1234/ciao1
 *					unstructured_citation = unstructured_citation_text
 *				...
 *		...
 */

namespace cr_repo;

class Repository
{
	private $data;
	
	public function setDepositor($name, $email)
	{
		$this->data['depositor'] = array('name' => $name, 'email' => $email);
		return $this;
	}
	
	public function setRegistrant($registrant)
	{
		$this->data['registrant'] = $registrant;
		return $this;
	}
	
	public function setJournalMetadata($full_title, $issn, $doi, $doi_resource, $abbrev_title = false, $issn_media_type = 'electronic')
	{
		$this->data['journal_metadata'] = [
				'full_title' => $full_title,
				'abbrev_title' => $abbrev_title,
				'issn_media_type' => $issn_media_type,
				'issn' => $issn,
				'doi_data' => [
						'doi' => $doi,
						'resource' => $doi_resource
				]
		];
		return $this;
	}
	
	public function setJournalIssue($date, $volume, $issue = false, $special_number = false, $media_type = 'online')
	{
		$parsed_date = date_parse($date);
		
		$this->data['journal_issue'] =  [
				'publication_date' => [
						'media_type' => $media_type,
						'month' => $parsed_date['month'],
						'day' => $parsed_date['day'],
						'year' => $parsed_date['year']
				],
				'volume' => [
						'volume' => $volume
				],
				'issue' => $issue,
				'special_numbering' => $special_number
	
		];
		return $this;
	}
	
	public function setArticle(Article $articles)
	{
		$this->data['articles'] = $articles->getArticles();
		return $this;
	}
	
	public function getDepositor()
	{
		return $this->data['depositor'];
	}
	
	
	public function getRegistrant()
	{
		return $this->data['registrant'];
	}
	
	public function getJournalMetadata()
	{
		return $this->data['journal_metadata'];
	}
	
	public function getJournalIssue()
	{
		return $this->data['journal_issue'];
	}
	
	public function getArticles()
	{
		return $this->data['articles'];
	}
  
}

class Article
{
	private $article, $articles;
	
	public function setLanguage($lang)
	{
		$this->article['language'] = $lang;
		return $this;
	}
	
	public function setTitle($title, $subtitle = false)
	{
		$this->article['title'] = $title;
		$this->article['subtitle'] = $subtitle;
		return $this;
	}
	
	public function setAuthor($name, $surname)
	{
		$this->article['authors'][] = [ 'name' => $name, 'surname' => $surname ];
		return $this;
	}
	
	public function setPublishData($doi_id, $doi_resource, $date, $publication_media_type = 'online', $publication_type = 'full_text')
	{
		$parsed_date = date_parse($date);
		
		$this->article['doi_id'] = $doi_id;
		$this->article['doi_resource'] = $doi_resource;
		$this->article['publication_date']['year'] = $parsed_date['year'];
		$this->article['publication_date']['month'] =$parsed_date['month'];
		$this->article['publication_date']['day'] =$parsed_date['day'];
		$this->article['publication']['media_type'] = $publication_media_type;
		$this->article['publication_type'] = $publication_type;
		
		return $this;
	}
	
	public function setCitations($doi, $unstructured_citation = false)
	{
		$this->article['citations'][] = [ 'doi' => $doi, 'unstructured_citation' => $unstructured_citation ];
		return $this;
	}
	
	public function close()
	{
		if ($this->article && is_array($this->article)) {
			$this->articles[] = $this->article;
		} else {
			throw new Exception('No article data in repository!');
		}
		$this->article = [];
		return $this;
	}
	
	public function getArticles()
	{
		return $this->articles;
	}
}