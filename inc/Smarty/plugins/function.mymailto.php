<?php
/**
 * Smarty plugin
 * @package n0where
 * @subpackage smarty
 */


/**
 * Smarty mymailto function plugin
 *
 * Type:     function<br />
 * Name:     mymailto<br />
 * Purpose:  My own kinda mailto function
 *           Same as Smarty's original mailto, except that the link text itself
 *           is not encoded.
 *
 * @version 1.2
 * @see function.mailto.php
 * @author Monte Ohrt <monte@ispi.net>
 */

function smarty_function_mymailto($params, &$smarty) {

    extract($params);

    if (empty($address)) {
        $smarty->trigger_error("mailto: missing 'address' parameter");
        return;
    }

    if (empty($text)) {
        $text = $address;
    }

    // netscape and mozilla do not decode %40 (@) in BCC field (bug?)
    // so, don't encode it.

    $mail_parms = array();
    if (!empty($cc)) {
        $mail_parms[] = 'cc='.str_replace('%40','@',rawurlencode($cc));
    }

    if (!empty($bcc)) {
        $mail_parms[] = 'bcc='.str_replace('%40','@',rawurlencode($bcc));
    }

    if (!empty($subject)) {
        $mail_parms[] = 'subject='.rawurlencode($subject);
    }

    if (!empty($newsgroups)) {
        $mail_parms[] = 'newsgroups='.rawurlencode($newsgroups);
    }

    if (!empty($followupto)) {
        $mail_parms[] = 'followupto='.str_replace('%40','@',
                                                  rawurlencode($followupto));
    }

    for ($i=0; $i<count($mail_parms); $i++) {
        $mail_parm_vals .= (0==$i) ? '?' : '&';
        $mail_parm_vals .= $mail_parms[$i];
    }
    $address .= $mail_parm_vals;

    if (empty($encode)) {
        $encode = 'none';
    } elseif (!in_array($encode,array('javascript','hex','none')) ) {
        $smarty->trigger_error("mailto: 'encode' parameter must be none, "
                              ."javascript or hex");
        return;
    }

    if ($encode == 'javascript' ) {
        $string = 'document.write(\'<a href="mailto:'.$address.'" '.$extra.'>'
                 .$text.'</a>\');';

        for ($x=0; $x < strlen($string); $x++) {
            $js_encode .= '%' . bin2hex($string[$x]);
        }

        return '<script type="text/javascript" language="javascript">'
              .'eval(unescape(\''.$js_encode.'\'))</script>';

    } elseif ($encode == 'hex') {

        preg_match('!^(.*)(\?.*)$!',$address,$match);
        if(!empty($match[2])) {
            $smarty->trigger_error("mailto: hex encoding does not work with "
                                  ."extra attributes. Try javascript.");
            return;
        }
        for ($x=0; $x < strlen($address); $x++) {
            if(preg_match('!\w!',$address[$x])) {
                $address_encode .= '%' . bin2hex($address[$x]);
            } else {
                $address_encode .= $address[$x];
            }
        }
        for ($x=0; $x < strlen($text); $x++) {
            $text_encode .= ($text[$x]);
        }

        return '<a href="mailto:'.$address_encode.'" '.$extra.'>'.$text_encode
              .'</a>';

    } else {
        // no encoding
        return '<a href="mailto:'.$address.'" '.$extra.'>'.$text.'</a>';

    }

} // smarty_function_mymailto()


/* Simba says Roar! */ ?>