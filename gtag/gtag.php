<?php
/**
 * Google Analytics tag
 * @author       Julian Bogdani <jbogdani@gmail.com>
 * @copyright    Julian Bogdani 2021
 * @license      ISC
 * @version      1.0
 * @since        2021/01/08
 * @see          https://github.com/jbogdani/bradycms-plugins
 */
class gtag extends Controller
{
    public function init(array $attr, Out $out): string
    {
        $id = $attr['id'] ?: $attr['content'];

        $domain = $attr['domain'];

        if (!$id) {
            return '<!-- no gtag: missing id -->';;
        }
        if ($out->cfg['isDraft']) {
            return '<!-- no gtag: draft -->';;
        }

        if ( !$domain || preg_match('/' . $domain . '/', $_SERVER['HTTP_HOST']) ) {
            return <<<EOD
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={$id}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{$id}');
</script>
EOD;
        } else {
            return '<!-- no gtag: domain mismatch -->';
        }

        
    }
}