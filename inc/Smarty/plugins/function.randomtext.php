<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     randomtext
 * Purpose:  output a random text with no repeating chars
 *           of a specified length
 *	{randomtext long=$howlong}
 *	If you want to assign the random number to a variable
 *	instead of displaying it, you must write:
 *	{random long=$howlong assign=yourVar}
 *	Where yourVar can be anything. Then you'll get
 *	$yourVar equal to the random text generated
 *
 *  Based on this example script:
 * http://www.phpfreaks.com/quickcode/Random-text-no-duplicate-chars/509.php
 * Author:   Sagie Maoz
 * Modified: 16-05-2006
 * -------------------------------------------------------------
 */

function smarty_function_randomtext($params, &$smarty)
{
	extract($params);
	
	$chars = "ABCXYZ0123456789";
    mt_srand((double)microtime()*1000000); 
    $i=0;

    while ($i != $long) {
    	$rand=mt_rand() % strlen($chars);
    	$tmp=$chars[$rand];
    	$pass=$pass . $tmp;
    	$chars=str_replace($tmp, "", $chars);
		$i++;
    }

	$random_text = strrev($pass);
	if (isset($assign)) {
		$smarty->assign($assign, $random_text);
	} else {
		return $random_text;
	}
}
?>