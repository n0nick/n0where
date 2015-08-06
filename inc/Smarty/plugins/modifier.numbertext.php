<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty plugin
 *
 * File:     modifier.numbertext.php<br />
 * Type:     modifier<br />
 * Name:     numbertext<br />
 * Date:     April 21, 2002<br />
 * Purpose:  Outputs alternative text to numeric variables.<br />
 *           Example:<br />
 *           <code>{$number_of_records|numbertext:"no records":"one record":"%d records"}</code>
 *           If $number_of_records==0 it outputs 'no records'<br />
 *           If $number_of_records==1 it outputs 'one record'<br />
 *           If $number_of_records==34 it outputs '34 records'
 * Install:  Drop into the plugin directory.<br />
 * @author	 Andreas Heintze <andreas.heintze@home.se>
 * @version 1.01
 * @param string
 * @return string
 * --------------------------------------------------------------------------
 */

   function smarty_modifier_numbertext() 
    {
        $alt_array = func_get_args();
        if (is_numeric($value = $index = $alt_array[0])) {
            $index++;
            $n = count($alt_array)-1;
            $index = $index>$n?$n:$index;
            $index = $index<1?1:$index;
            return str_replace("%d", $value, $alt_array[$index]);
        }
        else {
            return $index;
        }
    }

?>