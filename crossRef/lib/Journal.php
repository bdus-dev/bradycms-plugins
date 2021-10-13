<?php
/**
 * Maps Repository data structure to CrossRef Joirnal XML data structure
 * @author			Julian Bogdani <jbogdani@gmail.com>
 * @copyright		BraDypUS 2007-2013
 * @license			All rights reserved
 * @since			Apr 18, 2013
 */

namespace cr_repo;

class Journal
{
	private $doc;
	
	public function __construct(\DOMDocument $doc)
	{
		$this->doc = $doc;
	}
	
	public function create_journal()
	{
		$journal = $this->doc->createElement('journal');
		return $journal;
	}
	
	public function metadata($metadata)
	{
		$journal_metadata = $this->doc->createElement('journal_metadata');
		
		xml::appendElement($journal_metadata, 'full_title', $metadata['full_title']);
		
		$metadata['abbrev_title'] ?  xml::appendElement($journal_metadata, 'abbrev_title', $metadata['abbrev_title']) : '';
		
		$issn = xml::appendElement($journal_metadata, 'issn', str_replace('ISSN:', null, $metadata['issn']));
		
		if ($metadata['issn_media_type']) {
			$issn->setAttribute('media_type', $metadata['issn_media_type']);
		}
		
		if ($metadata['doi_data']) {
			$doi_data = xml::appendElement($journal_metadata, 'doi_data');
				
			xml::appendElement($doi_data, 'doi', $metadata['doi_data']['doi']);
			xml::appendElement($doi_data, 'resource', $metadata['doi_data']['resource']);
				
			/**
			 * Collection not supported
			 */
		}
		
		return $journal_metadata;
	}
	
	public function issue($issue)
	{
		/**
		 *  <journal_issue>
		 *  	<contributors>{0,1}</contributors>
		 *  
		 *  	<publication_date media_type="print">
		 *  		<month>{0,1}</month>
		 *  		<day>{0,1}</day>
		 *  		<year>{1,1}</year>
		 *  	</publication_date>
		 *  
		 *  	<journal_volume>
		 *  		<volume>{1,1}</volume>
		 *  		<publisher_item>
		 *  			<item_number item_number_type="">{0,3}</item_number>
		 *  			<identifier id_type="">{0,10}</identifier>
		 *  		</publisher_item>
		 *  
		 *  		<doi_data>{0,1}</doi_data>
		 *  	</journal_volume>
		 *  
		 *  	<issue>{0,1}</issue>
		 *  	<special_numbering>{0,1}</special_numbering>
		 *  	<doi_data>{0,1}</doi_data>
		 *  </journal_issue>
		 */
		
		$jIssue = $this->doc->createElement('journal_issue');
		
		/**
		 * contributors not supported
		 */
		
		/**
		 * publication_date
		 */
		$pub_date = xml::appendElement($jIssue, 'publication_date');
		
		$issue['publication_date']['media_type'] ? $pub_date->setAttribute('media_type', $issue['publication_date']['media_type']) : '';
		
		$issue['publication_date']['month'] ? xml::appendElement($pub_date, 'month', $issue['publication_date']['month']) : '';
		
		($issue['publication_date']['month'] && $issue['publication_date']['day'])  ? xml::appendElement($pub_date, 'day', $issue['publication_date']['day']) : '';
		
		xml::appendElement($pub_date, 'year', $issue['publication_date']['year']);
		
		/**
		 * journal_volume
		 */
		$jVolume = xml::appendElement($jIssue, 'journal_volume');
		
		xml::appendElement($jVolume, 'volume', $issue['volume']['volume']);
		
		
		/**
		 * publisher_item not supported
		 */
		
		/**
		 * issue
		 */
		if ($issue['issue']) {
			xml::appendElement($jIssue, 'issue', $issue['issue']);
		}
		
		/**
		 * special_numbering
		 */
		if ($issue['special_numbering']) {
			xml::appendElement($jIssue, 'special_numbering', $issue['special_numbering']);
		}
		
		/**
		 * doi_data not supported
		 */
		
		return $jIssue;
		
	}
	
	public function articles($data)
	{
		/**
		 * <journal_article language="" publication_type="full_text">
		 * 	<titles>
		 * 		<title>{1,1}</title>
		 * 		<subtitle>{0,1}</subtitle>
		 * 		<original_language_title language="">{1,1}</original_language_title>
		 * 		<subtitle>{0,1}</subtitle>
		 * 	</titles>
		 * 	<contributors>
		 * 		<organization contributor_role="author" sequence="first" /> (not supported)
		 * 			<person_name contributor_role="author" sequence="first">
		 * 				<given_name />
		 * 				<surname />
		 * 				<suffix /> (not supported)
		 * 				<affiliation /> (not supported)
		 * 			</person_name>
		 * 	</contributors>
		 * 	<publication_date media_type="print">{1,10}</publication_date>
		 * 	<pages> *
		 * 		<first_page>{1,1}</first_page>
		 * 		<last_page>{0,1}</last_page>
		 * 		<other_pages>{0,1}</other_pages>
		 * 	</pages>
		 * 	<publisher_item>{0,1}</publisher_item> *
		 * 	<crossmark> *
		 * 		<crossmark_version>{0,1}</crossmark_version>
		 * 		<crossmark_policy>{1,1}</crossmark_policy>
		 * 		<crossmark_domains>{1,1}</crossmark_domains>
		 * 		<crossmark_domain_exclusive>{1,1}</crossmark_domain_exclusive>
		 * 		<updates>{0,1}</updates>
		 * 		<custom_metadata>{0,1}</custom_metadata>
		 * 		<program name="fundref">{1,1}</program>
		 * 	</crossmark>
		 * 	<program name="fundref">{1,1}</program> *
		 * 	<doi_data>{1,1}</doi_data>
		 * 	<citation_list> *
		 * 		<citation key="">
		 * 			<issn media_type="print">{0,1}</issn>
		 * 			<journal_title>{0,1}</journal_title>
		 * 			<author>{0,1}</author>
		 * 			<volume>{0,1}</volume>
		 * 			<issue>{0,1}</issue>
		 * 			<first_page>{0,1}</first_page>
		 * 			<cYear>{0,1}</cYear>
		 * 			<doi>{0,1}</doi>
		 * 			<isbn media_type="print">{0,1}</isbn>
		 * 			<series_title>{0,1}</series_title>
		 * 			<volume_title>{0,1}</volume_title>
		 * 			<edition_number>{0,1}</edition_number>
		 * 			<component_number>{0,1}</component_number>
		 * 			<article_title>{0,1}</article_title>
		 * 			<unstructured_citation>{0,1}</unstructured_citation>
		 * 		</citation>
		 * 	</citation_list>
		 * 	<component_list>{0,1}</component_list> *
		 * </journal_article>
		 */
		
		$article = $this->doc->createElement('journal_article');
		
		if ($data['publication_type']) {
			$article->setAttribute('publication_type', $data['publication_type']);
		}
		
		if ($data['language']) {
			$article->setAttribute('language', $data['language']);
		}
		
		/**
		 * Title set
		 */
		$title = xml::appendElement($article, 'titles');
		
		xml::appendElement($title, 'title', $data['title']);
		
		$data['subtitle'] ? xml::appendElement($title, 'subtitle', $data['subtitle']) : '';
		
		/**
		 * original_language_title and subtitle not supported
		 */
		
		
		/**
		 * Contributors 
		 */
		
		if ($data['authors'] && !empty($data['authors'])) {
			$contribs = xml::appendElement($article, 'contributors');

			foreach ($data['authors'] as $index => $author) {
			$person = xml::appendElement($contribs, 'person_name');

			$person->setAttribute('contributor_role', 'author');

			if ($index < 1) {
				$person->setAttribute('sequence', 'first');
			} else {
				$person->setAttribute('sequence', 'additional');
			}

			$author['name'] ? xml::appendElement($person, 'given_name', $author['name']) : '';
			xml::appendElement($person, 'surname', $author['surname']);
			}
		}
		
		/**
		 * publication_date
		 */
		$pub_date = xml::appendElement($article, 'publication_date');
		
		$data['publication']['media_type'] ? $pub_date->setAttribute('media_type', $data['publication']['media_type']) : '';
		
		$data['publication_date']['month'] ? xml::appendElement($pub_date, 'month', $data['publication_date']['month']) : '';
		
		($data['publication_date']['month'] && $data['publication_date']['day'])  ? xml::appendElement($pub_date, 'day', $data['publication_date']['day']) : '';
		
		xml::appendElement($pub_date, 'year', $data['publication_date']['year']);
		
		
		/**
		 * Pages set
		 */
		if ($data['first_page']) {
			$pages = xml::appendElement($article, 'pages');
			xml::appendElement($pages, 'first_page', $data['first_page']);
			$data['last_page'] ? xml::appendElement($pages, 'last_page', $data['last_page']) : '';
			
			/**
			 * other_pages not supported
			 */
		}
		
		/**
		 * publisher_item not supported
		 * crossmark not implemented
		 */
		
		
		/**
		 * DOI
		 */
		$doi_data = xml::appendElement($article, 'doi_data');
	
		xml::appendElement($doi_data, 'doi', $data['doi_id']);
		xml::appendElement($doi_data, 'resource', $data['doi_resource']);
		
		/**
		 * Collection not supported
		 */
		
		
		/**
		 * citation_list set
		 */
		if ($data['citations'] && is_array($data['citations'])) {
			$citation_list = xml::appendElement($article, 'citation_list');
			
			$x = 0;
			foreach ($data['citations'] as $cit) {

				$citation = xml::appendElement($citation_list, 'citation');
				
				/**
				 * Only citation by doi is supported
				 */
				$citation->setAttribute('key', $data['doi_id'] . '-' . $x);
				
				xml::appendElement($citation, 'doi', $cit['doi']);
				if ($cit['unstructured_citation']) {
					xml::appendElement($citation, 'unstructured_citation', $cit['unstructured_citation']);
				}
				
				$x++;
			}
		}
		
		
		/**
		 * component_list not supported
		 */
		
		// TODO: to be continued
		// http://www.crossref.org/schema/documentation/4.3.1/4.3.1.html
		// http://localhost/php-CrossRef/
		// http://help.crossref.org/#deposit_basics
		
		
		return $article;
	}
}