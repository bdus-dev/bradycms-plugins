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
class disqus
{
  /**
   * Embeds a Disqus widget in a web page
   * @param  array  $attr array of options:
   *                      content: string, required: site's shortname in disqus
   * @return {string}       well formatted html with disqus widget
   */
  public static function init($attr)
  {

    if (!$attr['content']) {
      return false;
    }

    return '<div id="disqus_thread"></div>' .
            '<script type="text/javascript">' .
              "var disqus_shortname = '{$attr['content']}';" .
              "(function() {" .
                "var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;" .
                "dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';" .
                "(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);" .
            "})();" .
          "</script>";
  }

}
