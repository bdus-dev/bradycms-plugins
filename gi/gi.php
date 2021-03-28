<?php 

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
