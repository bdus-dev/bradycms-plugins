<?php

/**
 * Automatic footnote apparatus for BraDyCMS
 * @author      Julian Bogdani <jbogdani@gmail.com>
 * @copyright    BraDypUS 2013
 * @license      ISC
 * @version      1.0
 * @since        2013/05/21
 * @see          https://github.com/jbogdani/bradycms-plugins
 */
class notes
{
  private static $mynotes = [];
  private static $out;


  public static function init(array $attr, Out $out)
  {
    self::$mynotes[] = $attr['content'];
    self::$out = $out;

    $val = end(self::$mynotes);
    $key = key(self::$mynotes);
    $key = $key + 1;


    return '<a ' .
      ' href="javascript:void(0)" ' .
      ' class="ftpopover" ' .
      //' href="#ft-note-' .  count(self::$mynotes) . '" ' .
      ' id="bd-note-' . $key . '" ' .
      //' title="' . $attr['content'] . '"' .
      ' data-content="' . str_replace('"', "'", $val) . '"' .
      ' data-toggle="popover" ' .
      ' data-original-title="Nota ' . $key . '"' .
      ' >' .
      ' [' . $key . ']' .
      '</a>';
  }

  public static function end()
  {
    if (count(self::$mynotes) == 0) {
      return;
    }
    $lang = self::$out->getArticle()['lang'] ?: self::$out->getLang();
    // Article custom field lang
    switch ($lang) {
      case 'english':
      case 'eng':
      case 'en':
        $label = 'Notes';
        break;
      case 'italian':
      case 'ita':
      case 'it':
      default:
        $label = 'Note';
        break;
    }
    
    $html = '<div class="footNotes">' .
      '<hr />' .
      '<h2 class="notes">' . $label . '</h2>';

    foreach (self::$mynotes as $k => $note) {
      $html .= '<p><a id="ft-note-' . ($k + 1) . '" href="#bd-note-' . ($k + 1) . '">' . ($k + 1) . '</a>. ' . $note . '</p>';
    }
    $html .= '</div>';

    return  $html;
  }
}
