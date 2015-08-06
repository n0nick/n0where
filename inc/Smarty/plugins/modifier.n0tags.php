<?php
/**
 * Smarty plugin
 * @package n0where
 * @subpackage smarty
 */


/**
 * Smarty n0tags modifier plugin
 *
 * Type:     modifier<br />
 * Name:     n0tags<br />
 * Purpose:  Handles my very own special set of tags for posts.
 *
 * @param  string $string Text to process
 * @return string Text with tags replaced
 * @author Sagie Maoz <n0nick@php.net>
 */

function smarty_modifier_n0tags($string) {

   // <music> NP tag
   $string = preg_replace('/<music>(.*)<\/music>/',
                          '<img src="img/music.png" width="14" height="17" '
                         .'alt="אני שומע" title="אני שומע" /> '
                         .'\\1 '
                         .'<img src="img/music.png" width="14" height="17" '
                         .'alt="אני שומע" title="אני שומע" />',
                          $string);
   
   // **bold** text
   $string = preg_replace('/\*\*(.*)\*\*/', '<strong>\\1</strong>', $string);
   
   return $string;

} // smarty_modifier_mytags()

?>