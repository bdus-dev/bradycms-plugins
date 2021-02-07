<?php

/**
 * Bootstrap 3 menu  plugin for BraDyCMS
 * @author      Julian Bogdani <jbogdani@gmail.com>
 * @copyright    BraDypUS 2019
 * @license      ISC
 * @version      1.0
 * @see          https://github.com/bdus-dev/bradycms-plugins
 */
class bs3menu
{
    /**
     * Runs plugin
     *
     * @param array $data Custom tag array of data:
     *      content is required
     *      ulClass is optional
     * @param Out $out
     * @return string
     */
    public function init(array $data = [], Out $out): string
    {
        $menu = $data['content'];
        $ulClass = trim($data['ulClass'] . ' ' . $menu);

        if (!$menu){
            error_log("No menu name provided");
            return '';
        }

        $menu_arr = $out->getMenu($menu);

        
        if (!is_array($menu_arr) || empty($menu_arr)) {
            error_log("Menu `{$menu}` not found");
            return '';
        }

        return $this->makeUl($menu_arr, $ulClass);
    }

    private function isActive($el): bool
    {
        if ($i['current']) {
            return true;
        }

        if (!$el['sub'] || !is_array($el['sub'])) { 
            return false;
        }

        $ret = false;
        foreach ($el['sub'] as $i) {
          if ($i['current']){
            $ret = true;
          }
        }
        return $ret;
      }

    private function makeUl(array $list, string $classes = null, bool $isSub = false): string
    {
        $html = '<ul class="' . $classes . ' ' . ($isSub ? ' submenu dropdown-menu' : '') . '">';

        foreach ($list as $i) {
            if ($i['item'] === '.') {
                $html .= '<li class="divider"></li>';
            } else {
                $html .= '<li class="menu-item ' 
                        . ($i['sub'] ? ' dropdown-submenu ' : '') 
                        . ($this->isActive($i) ? 'active' : '') 
                        . '">';
                $html .= '<a href="' . $i['href'] . '" '
                    . ($i['title'] ? ' title="' . $i['title'] . '" ' : '')
                    . ($i['target'] ? ' target="' . $i['target'] . '" ' : '')
                    . ($i['sub'] ? ' class="dropdown-toggle" data-toggle="dropdown"' : '')
                    . '>'
                    . $i['item']
                    . ($menu['sub'] ? ' <b class="caret"></b>' : '')
                . '</a>';
            }

            if ($menu['sub']) {
                $html .= $this->makeUl($menu['sub'], null, true );
            }

            $html .= '</li>';
        }

        $html .= '</ul>';

        return $html;
    }
}