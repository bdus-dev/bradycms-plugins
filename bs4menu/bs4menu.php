<?php

/**
 * Bootstrap 4 menu  plugin for BraDyCMS
 * @author      Julian Bogdani <jbogdani@gmail.com>
 * @copyright    BraDypUS 2019
 * @license      ISC
 * @version      1.0
 * @since        2019/11/08
 * @see          https://github.com/jbogdani/bradycms-plugins
*/
class bs4menu {

  /**
   * [init description]
   * @param  array  $data
   *                  content: menu name
   *                  ulClass: space separated classes to apply to nav
   * @param  Out    $out  [description]
   * @return [type]       [description]
   */
  public function init( $data = [], Out $out)
  {
    $menu = $data['content'];
    if (!$menu){
      error_log("No menu name provided");
      return false;
    }

    $menu_arr = $out->getMenu($menu);

    if (!is_array($menu_arr) || empty($menu_arr)) {
      error_log("Menu `{$menu}` not found");
      return false;
    }

    return $this->makeUl($menu_arr, $data['classes']);
  }

  private function currentInSub($el) {
    if (!$el['sub']) return false;
    $ret = false;
    foreach ($el['sub'] as $i) {
      if ($i['current']){
        $ret = true;
      }
    }
    return $ret;
  }

  private function makeUl(array $list, string $classes = null) :string {

    $html = '<ul class="navbar-nav ' . ($classes ?: '') . '">';

    foreach($list as $i) {
      if ($i['item'] === '.') {
        $html .= '<div class="dropdown-divider"></div>';
      } else {
        $html .= '<li class="nav-item'
              . ($i['current'] ? ' active' : '')
              . ($this->currentInSub($i) ? ' active-sub' : '')
              . ( $i['sub'] ? ' dropdown' : '') . '">';

        $html .= '<a href="' . $i['href'] . '" '
            . 'title="' . ( $i['title'] ?: $i['item']) . '" '
            . ($i['target'] ? ' target="' . $i['target'] . '" ' : '')
            . 'class="nav-link' . ($i['sub'] ? ' dropdown-toggle' : '') . '" '
            . ($i['sub'] ? 'role="button" data-toggle="dropdown" ' : '')
            . '>'
            . $i['item']
        . '</a>';

        $html .= $i['sub'] ? $this->makeDD($i['sub']) :  '';

        $html .= '</li>';
      }
    }

    $html .= '</ul>';

    return $html;

  }

  private function makeDD(array $list): string {
    $html = '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
    foreach ($list as $i) {
      if ($i['item'] === '.') {
        $html .= '<div class="dropdown-divider"></div>';
      } else {
        $html .= '<a class="dropdown-item' . ($i['current'] ? ' active' : '') . '" href="' . $i['href']. '">' . $i['item']. '</a>';
      }
    }
    $html .= '</div>';

    return $html;
  }

}
