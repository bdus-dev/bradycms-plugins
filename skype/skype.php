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
class skype
{
  /**
   * Shows Skype widget
   * https://www.skype.com/en/developer/create-contactme-buttons/
   * @param  array  $attr array of options:
   *                      type: contact type, one of call (default), chat, dropdown
   *                      content: skype contact to contact
   *                      imagesize: Skype image size,one of 10, 12, 14, 16, 24, 32
   * @return {string}       well formatted html with skype widget
   */
  public static function init($attr)
  {
    $uid = uniqid('SkypeButton_');

    return '<script type="text/javascript" src="https://secure.skypeassets.com/i/scom/js/skype-uri.js"></script>' .
      '<div id="' . $uid . '">' .
        '<script type="text/javascript">' .
          'Skype.ui({' .
            '"name": "' . ( $data['type'] ? $data['type'] : 'call' ) . '",' .
            '"element": "' . $uid . '",' .
            '"participants": ["' . $data['content'] . '"],' .
            '"imageSize": ' . ( $data['imageSize'] ? $data['imageSize'] : '32' ) . '' .
          '});' .
        '</script>' .
      '</div>';
  }
}
