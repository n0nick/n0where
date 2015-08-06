<?php
/**
 * Smarty plugin
 * @package n0where
 * @subpackage smarty
 */


/**
 * Smarty autop modifier plugin
 *
 * Type:     modifier<br />
 * Name:     linkalize<br />
 * Purpose:  Turn text URLs into clickable URLs.
 *
 * @param  string  $text Text to process
 * @return string Text with links
 * @author Nichlas <crotalus@acc.umu.se>
 * @link   http://marc.theaimsgroup.com/?l=smarty-general&m=104378865428811&w=2
 */

function smarty_modifier_linkalize($text) {

      //make sure there is an http:// on all URLs
      $text = preg_replace("/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i",
                           "$1http://$2", $text);
      $text = preg_replace("/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i",
                           "<a target=\"_blank\" href=\"$1\" title=\"$1\">$1"
                          ."</a>", $text); //make all URLs links

      $text = preg_replace("/[\w-\.]+@(\w+[\w-]+\.){0,3}\w+[\w-]+\.[a-zA-Z]"
                          ."{2,4}\b/i", "<a href=\"mailto:$0\" class=link>$0"
                          ."</a>",$text);

      return $text;

} // smarty_modifier_linkalize()

?>