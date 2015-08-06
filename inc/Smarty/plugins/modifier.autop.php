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
 * Name:     autop<br />
 * Purpose:  Extended autop function
 *
 *           Basically it takes PHP's nl2br function to the logical next step 
 *           and converts double line breaks to paragraphs where applicable,
 *           does line breaks as before, and best of all it's aware of
 *           block-level HTML tags so it won't mess up your page.
 *
 * @version 0.7
 * @param string  $string Text to format
 * @param boolean $br     Break lines flag
 * @return string Formatted text
 * @author Matthew Mullenweg
 * @link http://photomatt.net/scripts/autop
 */

function smarty_modifier_autop($string, $br = TRUE) {

      // cross-platform newlines
      $string = preg_replace('/(\r\n|\n|\r)/', "\n", $string);
      // take care of duplicates
      $string = preg_replace('/\n\n+/', "\n\n", $string);
      // make paragraphs, including one at the end
      $string = preg_replace('/\n?(.+?)(\n\n|\z)/s', "<p>$1</p>\n", $string);
      $string = preg_replace('/<p>(<(?:table|[ou]l|pre|select|form|blockquote|'
                            .'h1|h2|h3|div|script|li|center|hr))/',
                             "$1", $string);
      $string = preg_replace('!(</(?:table|[ou]l|pre|select|form|blockquote|'
                            .'h1|h2|h3|div|script|li|center)>)</p>!',
                             "$1", $string);
      // optionally make line breaks
      if ($br) $string = preg_replace('|(?<!</p>)\s*\n|', "<br />\n", $string);
      $string = preg_replace('!(</(?:table|[ou]l|pre|select|form|blockquote|'
                            .'h1|h2|h3|div|script|li|center)>)<br />!',
                             "$1", $string);
      // why oh why doesn't this work:
      $string = str_replace('<p><p', '<p', $string);
      $string = str_replace('</p></p>', '</p>', $string);
      $string = preg_replace('!("float-(?:left|right)" />)<br />\n!',"$1\n<p>",
                             $string);
      return $string;

} // smarty_modifier_autop()

?>