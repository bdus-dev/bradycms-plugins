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
class prezi
{
  /**
   * Embeds a Prezi presentation in a web page
   * https://prezi.com/support/article/sharing/embedding-prezis/
   * @param  array  $attr array of options:
   *                      content: string, required. Prezi's id
   *                      width: int, optional, default: 550. Width of the iframe
   *                      height: int, optional, default: 400. Height of the iframe
   *                      frameborder: int, optional, default: 0. Iframe border
   *                      bgcolor: string, optional, default: ffffff. Background color
   *                      lock_to_path: int, optional (0 or 1), default: 0. Wether permit zoom or pan or not
   *                      autoplay: int, optional (0 or 1), default: 0. Wether permit autoplay or not
   *                      autohide_ctrls: int, optional (0 or 1), default: 0. Wether permit automatically hide controls or not
   * @return {string}       well formatted html with skype widget
   */
  public static function init($attr)
  {

    if (!$attr['content']) {
      return false;
    }

    $uid = uniqid( 'prezi' );

    $params = [];

    foreach ([
      'bgcolor' => 'ffffff',
      'lock_to_path' => '0',
      'autoplay' => '0',
      'autohide_ctrls' => '0',
      ] as $k => $d) {
      $params[$k] = $attr[$k] ? $attr[$k] : $d;
    }

    return '<iframe '
        . 'id="' . $uid . '" '
        . 'frameborder="' . ($attr['frameborder'] ? $attr['frameborder'] : '0') . '" '
        . 'webkitallowfullscreen="" '
        . 'mozallowfullscreen="" '
        . 'allowfullscreen="" '
        . 'width="' . ($attr['width'] ? $attr['width'] : '550') . '" '
        . 'height="' . ($attr['height'] ? $attr['height'] : '400') . '" '
        . 'src="https://prezi.com/embed/' . $attr['content']. '/?' . implode('&amp;', $params) . '"></iframe>';

  }

}
