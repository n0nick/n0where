<?php
/**
 * Smarty plugin
 * @package n0where
 * @subpackage smarty
 */


/**
 * Smarty hebdate modifier plugin
 *
 * Type:     modifier<br />
 * Name:     hebdate<br />
 * Purpose:  Hebrew variation of date().
 *
 *           Added characters are: 'b' for Hebrew name of day
 *                                 'x' for Hebrew name of month
 *
 * @param  int    $tm       time to process
 * @param  string $template pattern to use
 * @return string Formatted date
 * @link   http://php.net/date
 * @author Sagie Maoz <n0nick@php.net>
 */

function smarty_modifier_hebdate($tm, $template) {
    $hebdays     = array('ראשון','שני','שלישי','רביעי','חמישי','שישי','שבת');
    $hebmonths   = array('ינואר','פברואר','מרץ','אפריל','מאי','יוני',
                       'יולי','אוגוסט','ספטמבר','אוקטובר','נובמבר','דצמבר');
    $patterns    = array('/b/','/x/');
    $replace     = array($hebdays[date('w',$tm)],$hebmonths[date('n',$tm)-1]);
    $template    = preg_replace ($patterns, $replace, $template);

    return date($template,$tm);

} // smarty_modifier_hebdate()

?>