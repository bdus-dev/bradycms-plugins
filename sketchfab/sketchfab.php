<?php
/**
 * Embed Sketchfab models
 * @author       Julian Bogdani <jbogdani@gmail.com>
 * @copyright    Julian Bogdani 2021
 * @license      ISC
 * @version      1.0
 * @since        2021/02/07
 * @see          https://github.com/jbogdani/bradycms-plugins
 */
class sketchfab extends Controller
{
    public function init( array $attr, Out $out): string
    {
        if (!$attr['url'] && !$attr['content']){
            return "Missinig URL for Sketchfab model";
        }
        
        $url        = $attr['content'] ?: $attr['url'];
        $title      = $attr['title'] ?: 'A 3D model';
        $width      = $attr['width'] ?: 840;
        $height     = $attr['height'] ?: 640;
        $qs = [];

        foreach ([
            'autostart' => '1',
            'ui_controls' => '1',
            'ui_infos' => '1',
            'ui_inspector' => '1',
            'ui_stop' => '1',
            'ui_watermark' => '1',
            'ui_theme' => false
        ] as $key => $val) {
            if ( isset($attr[$key])){
                $qs[$key] = $attr[$key];
            } else {
                $qs[$key] = $val;
            }
        }


        $src = "https://sketchfab.com/models/"
            . "{$url}/"
            . "embed?"
            . http_build_query($qs);

        return '<div class="sketchfab-embed-wrapper">
        <iframe 
            title="' . $title . '" 
            width="' . $width . '" 
            height="' . $height . '" 
            src="' . $src . '" 
            frameborder="0" 
            allow="autoplay; 
            fullscreen; vr" 
            mozallowfullscreen="true" 
            webkitallowfullscreen="true"
        ></iframe>
        <p class="sketchfab-caption">
            <a href="https://sketchfab.com/3d-models/' . $url . '?utm_medium=embed&utm_source=website&utm_campaign=share-popup" target="_blank">' . $title . '<span class="open-on-sketchfab"> [Open on Sketchfab.com]</span></a>
        </p>
    </div>';
    }
}
