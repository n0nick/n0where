<?php

/****************************************************************
* xmlrpc_decode takes a message in PHP xmlrpc object format and *
* tranlates it into native PHP types.                           *
*                                                               *
* author: Dan Libby (dan@libby.com)                             *
****************************************************************/
function xmlrpc_decode($xmlrpc_val) {
   $kind = $xmlrpc_val->kindOf();

   if($kind == "scalar") {
      return $xmlrpc_val->scalarval();
   }
   else if($kind == "array") {
      $size = $xmlrpc_val->arraysize();
      $arr = array();

      for($i = 0; $i < $size; $i++) {
         $arr[]=xmlrpc_decode($xmlrpc_val->arraymem($i));
      }
      return $arr; 
   }
   else if($kind == "struct") {
      $xmlrpc_val->structreset();
      $arr = array();

      while(list($key,$value)=$xmlrpc_val->structeach()) {
         $arr[$key] = xmlrpc_decode($value);
      }
      return $arr;
   }
}

/****************************************************************
* xmlrpc_encode takes native php types and encodes them into    *
* xmlrpc PHP object format.                                     *
* BUG: All sequential arrays are turned into structs.  I don't  *
* know of a good way to determine if an array is sequential     *
* only.                                                         *
*                                                               *
* feature creep -- could support more types via optional type   *
* argument.                                                     *
*                                                               *
* author: Dan Libby (dan@libby.com)                             *
****************************************************************/
function xmlrpc_encode($php_val) {
   global $xmlrpcInt;
   global $xmlrpcDouble;
   global $xmlrpcString;
   global $xmlrpcArray;
   global $xmlrpcStruct;
   global $xmlrpcBoolean;

   $type = gettype($php_val);
   $xmlrpc_val = new xmlrpcval;

   switch($type) {
      case "array":
      case "object":
         $arr = array();
         while (list($k,$v) = each($php_val)) {
            $arr[$k] = xmlrpc_encode($v);
         }
         $xmlrpc_val->addStruct($arr);
         break;
      case "integer":
         $xmlrpc_val->addScalar($php_val, $xmlrpcInt);
         break;
      case "double":
         $xmlrpc_val->addScalar($php_val, $xmlrpcDouble);
         break;
      case "string":
         $xmlrpc_val->addScalar($php_val, $xmlrpcString);
         break;
// <G_Giunta_2001-02-29>
// Add support for encoding/decoding of booleans, since they are supported in PHP
      case "boolean":
         $xmlrpc_val->addScalar($php_val, $xmlrpcBoolean);
         break;
// </G_Giunta_2001-02-29>
      case "unknown type":
      default:
	// giancarlo pinerolo <ping@alt.it>
	// it has to return 
        // an empty object in case (which is already
	// at this point), not a boolean. 
	break;
   }
   return $xmlrpc_val;
}

?>
