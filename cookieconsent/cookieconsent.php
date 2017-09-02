<?php
/**
 * Cookie consent plugin for BraDyCMS
 * @author      Julian Bogdani <jbogdani@gmail.com>
 * @copyright    BraDypUS 2017
 * @license      ISC
 * @version      1.0
 * @since        2017/03/20
 * @see          https://github.com/jbogdani/bradycms-plugins
 */
class cookieconsent
{
  /**
   * Cookie consent by Insites plugin
   * Custom tag interface function
   * https://cookieconsent.insites.com/documentation/
   * @param  string|array  $attr json_encoded string or array with config data, as explained
   *                             at http://cookieconsent.wpengine.com/documentation/javascript-api/
   * @param  Out     $out  [description]
   */
  public static function init($attr, Out $out)
  {
    if(is_string($attr))
    {
      $attr = json_decode($attr, true);
    }
    if(!$attr)
    {
      $attr = [];
    }

    if (!isset($attr['palette']['popup']['background'])){
      $attr['palette']['popup']['background'] = "#000";
    }
    if (!isset($attr['palette']['button']['background'])){
      $attr['palette']['button']['background'] = "#f1d600";
    }

    $content = '<script>window.addEventListener("load", function(){window.cookieconsent.initialise(' . json_encode($attr) . ');});</script>';
    $out->setQueue('modules', "\n  " . '<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />', true);

    $out->setQueue('modules', "\n  " . '<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>', true);

    $out->setQueue('modules', "\n  " . $content, true);
  }
}
?>
