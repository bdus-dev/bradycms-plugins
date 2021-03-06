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
  private static $mynotes = array();


  public static function init($attr)
  {
    self::$mynotes[] = $attr['content'];

    $val = end(self::$mynotes);
    $key = key(self::$mynotes);
    $key = $key + 1;


    return $html . '<a ' .
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
    if (count(self::$mynotes) == 0)
    {
      return;
    }

    $html = '<div class="footNotes">' .
        '<hr />' .
        '<h2 class="notes">Note</h2>';

    foreach(self::$mynotes as $k => $note)
    {
      $html .= '<p><a id="ft-note-' . ($k + 1) . '" href="#bd-note-' . ($k + 1) . '">' . ($k + 1) . '</a>. ' . $note . '</p>';
    }
    $html .= '</div>';

    return  $html;
  }
}
