<?php
/**
 *
 * galRef: Outputs a well formatted a attribute with reference to a certain gallery item, fancybox class and title attribute to be used in article's text
 * @author       Julian Bogdani <jbogdani@gmail.com>
 * @copyright    BraDypUS 2014
 * @license      ISC
 * @version      1.0
 * @since        2014/08/20
 * @see          https://github.com/jbogdani/bradycms-plugins
 *
 * Available parameters:
 *  - gal (string, required): gallery unique name
 *  - item (string, required): gallery item to reference
 *  - content (string, required): content to "linkify"
 *  - rel (string, optional): Gallery rel attribute, if false the gallery name will be used
 */

class galRef
{
  public static function init ($attr, Out $out) {

    // Get parameters
    $gal = $attr['gal'];
    $i = $attr['item'];
    $text = $attr['content'];
    $rel = $attr['rel'] ? $attr['rel'] :  $gal;

    // Return text if any attribute is missing
    if (!$gal || !$i || !$text) {
      error_log('Missing gallery name, gallery index or text');
      return $text;
    }

    // Get gallery data
    $gal_data = $out->getGallery($gal);

    // Return text if no gallery data is found
    if (!$gal_data || !is_array($gal_data)) {
      error_log('No data found for gallery ' . $gal);
      return $text;
    }

    // Get item
    $item = $gal_data[($i-1)];

    // If no item if found return text
    if (!$item) {
      error_log('Missing item ' . $i . ' in gallery ' . $gal);
      return $text;
    }

    // Return finally html string
    $html = '<a href="' . $item['img'] . '" ' .
      ' title="' . str_replace('"', '\"', $item['caption']) . '" ' .
      ' rel="' . $rel . '"' .
      ' class="fancybox">' . $text .'</a>';
    return $html;

  }
}

?>
