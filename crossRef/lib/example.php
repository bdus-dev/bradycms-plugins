<?php
/**
 * @author			Julian Bogdani <jbogdani@gmail.com>
 * @copyright		BraDypUS 2007-2013
 * @license			All rights reserved
 * @since			Jun 19, 2013
 * @uses OOCurl: https://github.com/jsocol/oocurl
 */

// Include Repository object
require_once 'Repository.php';
// Include CrossRef
require_once 'lib/phpCrossRef.php';

try
{
	// Initialize Repository:
	$repo = new cr_repo\Repository();
	
	// Initialize Article
	$articles = new cr_repo\Article();
	
	// Initialize crossRef object
	$cr = new cr_repo\phpCrossRef("myCrossRefUsername", "myCrossRefUsername" );
	
	
	
	// repository data
	$repo
		// The following data are required
		->setDepositor("Depositor or Publisher name", "Depositor or Publisher email address")
		->setRegistrant("Registrant's name")
		->setJournalMetadata(
				"Journal's Full name",
				"Journal's ISSN number",
				"Journal's DOI",
				"Journal's home page URL",
				"Journal's Short name"
	)
	// Optional information
	->setJournalIssue("YYY-MM-DD or YYYY-MM or YYY", "Issue number");
	
	// Add first article
	$articles
		->setTitle("Article 1 title")
		->setPublishData(
				"Article 1 DOI",
				"Article 1 URL",
				"Article 1 pubblication date: YYY-MM-DD or YYYY-MM or YYY",
				//optional:
				"Publication type, default: online",
				"Content type, default full_text"
				)
		->setLanguage('en')
		->close();
	
	// Add second article only if not already present in CrossRef database
	if (!$cr->isDoiRegistered("Article 2 DOI")) {
		$articles
		->setTitle("Article 2 title")
		->setPublishData(
				"Article 2 DOI",
				"Article 2 URL",
				"Article 2 pubblication date: YYY-MM-DD or YYYY-MM or YYY",
				//optional:
				"Publication type, default: online",
				"Content type, default full_text"
		)
		->setLanguage('en')
		->close();
	}
	
	// Add some more articles....
	
	// Add all articles to repository
	$repo->setArticle($articles);
	
	//Repository is now complete and ready to be added to CrossRef object:
	$cr->addRepository($repo);

	// You are now ready tu build XML
	$cr->buildXML();
	
	// get XML
	$xml = $cr->getXML();
	
	// You can now echo the XML:
	echo $xml;
	
	
	// or submit it to CrossRef database:
		// write XML to a temporary file
	$tmpfname = tempnam(sys_get_temp_dir(), 'crossRef');
	$handle = fopen($tmpfname, "w");
	fwrite($handle, $xml);
	fclose($handle);
	
		// make a test submit to CrossRef end echo result
	$test_result = $cr->deposit($tmpfname, true);
	echo $test_result;
	
		// finally submit to CrossRef end echo result
	$test_result = $cr->deposit($tmpfname);
	echo $test_result;
	
	// Finished!
	
} catch (DOMException $e) {
	return var_export($e, 1);
} catch(Exception $e) {
	return var_export($e, 1);
}