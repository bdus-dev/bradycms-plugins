<?php
/**
 * Embed github gists in article contents
 * @author       Julian Bogdani <jbogdani@gmail.com>
 * @copyright    BraDypUS 2014
 * @license      ISC
 * @version      1.0
 * @since        2014/08/20
 * @see          https://github.com/jbogdani/bradycms-plugins
 */
class gist{
  
  public static function init($data){
    return '<script src="' . $data['content'] . '.js"></script>';
  }
}

?>
