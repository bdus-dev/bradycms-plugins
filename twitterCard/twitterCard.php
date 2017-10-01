<?php
/**
 * Shows a twitter summary card
 * as in https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/summary
 * @author      Julian Bogdani <jbogdani@gmail.com>
 * @copyright    BraDypUS 2017
 * @license      ISC
 * @version      1.0
 * @since        2017/10/01
 * @see          https://github.com/jbogdani/bradycms-plugins
 */
class twitterCard extends plugins_ctrl
{
  /**
   * Returns a twitter summary card
   * as in https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/summary
   * @param  array  $data    array of data
   *                         content: The Twitter @username the card should be attributed to.
   * @param  OutHtml $outHtml OutHtml object
   * @return text           Well formatted HTML
   */
  public function init($data, OutHtml $outHtml)
  {
    $site = $data['content'];

    if (!$site) {
      return false;
    }

    $part = [];
    array_push($part, '<!-- Twitter Card -->');
    array_push($part, '<meta name="twitter:card" content="summary" />');
    array_push($part, '<meta name="twitter:site" content="@' . $site . '" />');
    $content = $this->getPageData('custom_title') ? $outHtml->getPageData('custom_title', true) : $outHtml->getPageData('title', true);
    array_push($part, '<meta name="twitter:title" content="' . $content . '" />');
    array_push($part, '<meta name="twitter:description" content="' . $outHtml->getPageData('description', true) . '" />');

    if ($outHtml->getPageData('image')) {
      array_push($part, '<meta name="twitter:image" content="' . $outHtml->getPageData('image', true) . '" />');
    }

    array_push($part, '<meta name="twitter:url" content="' . $outHtml->getPageData('url', true) . '" />');

    return implode("\n  ", $part);

  }

}

?>
