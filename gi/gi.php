<?php 
/**
 * Displays fancybox link to galley image
 * @author       Julian Bogdani <jbogdani@gmail.com>
 * @copyright    BraDypUS 2021
 * @license      ISC
 * @version      1.0
 * @since        2021/03/28
 * @see          https://github.com/jbogdani/bradycms-plugins
 */
class gi
{
  public static function init($data, Out $out)
  {
    $id = $out->getTextId();
    $gal = $out->getGallery($id);

    if (!$data['path'] || !$gal || !is_array($gal)){
      return $data['content'];
    }

    foreach ($gal as $item){
      if (strpos($item['img'], $id . '/' . $data['path']) !== false) {
        $title = str_replace('"', '\"', $item['caption']);
        $path = $item['img'];
      }
    }

    if (!$path || !$title) {
      return $data['content'];
    }

    return '<a href="' . $path . '" ' .
        'data-fancybox="' . $id . '" ' .
        'rel="' . $id . '" ' .
        'data-caption="' . $title . '" ' .
        'title="' . $title . '">' .
       $data['content'] .
    '</a>';
  }
}
?>
