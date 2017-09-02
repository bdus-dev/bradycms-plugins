<?php
/**
 * Shows a call/chat Skype button
 * following https://www.skype.com/en/developer/create-contactme-buttons/
 * @author      Julian Bogdani <jbogdani@gmail.com>
 * @copyright    BraDypUS 2013
 * @license      ISC
 * @version      1.0
 * @since        2017/03/20
 * @see          https://github.com/jbogdani/bradycms-plugins
 */
class soundcloud
{
  /**
   * Embeds a Sounfcloud widget in a web page
   * https://soundcloud.com/pages/embed
   * @param  array  $attr array of options:
   *                      content: string, required: soindcloud's id
   *                      width: int, optional, default: 100%, width of the iframe
   *                      height: int, optional, default: 166, height of the iframe
   *                      color: string, optional, default: 0. Background color
   *                      auto_play: int, optional (0 or 1), default: 0. Wether permit autoplay or not
   *                      show_artwork: int, optional (0 or 1), default: 0. Wether to show artwork or not
   * @return {string}       well formatted html with skype widget
   */
  public static function init($attr)
  {

    $params = [];

    foreach ([
      'url' => $attr['content'],
      'color' => '0',
      'auto_play' => '0',
      'show_artwork' => '0',
      ] as $k => $d) {
      $params[$k] = $attr[$k] ? $attr[$k] : $d;
    }

    return '<iframe '
      . ' width="' . ($attr['width'] ? $attr['width'] : '100%') . '" '
      . ' height="' . ($attr['height'] ? $attr['height'] : '166') . '" '
      . 'scrolling="no" '
      . ' frameborder="no" '
      . ' src="https://w.soundcloud.com/player/?' . implode('&amp;', $params)
      . '"></iframe>';


  }

}
