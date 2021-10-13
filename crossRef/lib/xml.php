<?php
/**
 * @author			Julian Bogdani <jbogdani@gmail.com>
 * @copyright		BraDypUS 2007-2013
 * @license			All rights reserved
 * @since			Apr 18, 2013
 */
namespace cr_repo;

class xml
{
	static function appendElement($node, $tagName, $value = false)
	{
		$el = new \DOMElement($tagName);
	
		if ($value)
		{
			$el->nodeValue = htmlspecialchars($value);
		}
	
		$node->appendChild($el);
	
		return $el;
	}
}