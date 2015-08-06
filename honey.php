<?php

//require_once('include.inc.php');
//$db=db_connect();mysql_query('UPDATE `blobs` SET `comments`=\'0\' WHERE `blobid`=\'3\';');

srand ((float) microtime() * 10000000);
function antiSpami($x) 
{
	$ch='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$rc='';
	$ch2='abcdefghijklmnopqrstuvwxyz';
	$cnt = rand(3,13);
	for ($j = 1; $j < $cnt; $j++) 
	{
		if (!$x) 
		{
			$rc = $rc.substr($ch,rand(0,strlen($ch)),1);
		}	
		else 
		{
			$rc = $rc.substr($ch2,rand(0,strlen($ch2)),1);
		}	
	}//end for
	
	return $rc;
}//end function

function spam2U() 
{
	$extentions = array('.co.il','.com','.org.il','.net','.ac.il','.edu',
                       '.net.il','.org','.info','.us','.biz','.cc','.co.uk',
                       '.nl','.gov','.gov.il','.tv','.fm','.art','.k12.il',
                       '.mil','.muni.il','.co.jp','.fr','.ru');
	$noOfEmails = rand(50,500);
	for ($i=0;$i<$noOfEmails;$i++)
	{	
		$add=antiSpami(0).'@'.antiSpami(1).$extentions[array_rand ($extentions, 1)];		
		echo '<a href="mailto:'.$add.'">'.$add.'</a><br />';
	}//end for
}//end function

$q=rand(5000,50000000);
   echo '<'.'?xml version="1.0" encoding="utf-8"?'.'>'."\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he">

<head>
   <title>n0where :: honey trap</title>
   
   <base href="http://www.n0nick.net/" />

   <link rel="index"      href="n0where/" />
   <link rel="start"      href="n0where/anchor/1" />
   <link rel="author"     href="n0where/about/me" />
   <link rel="copyright" href="http://creativecommons.org/licenses/by-sa/1.0/"/>

   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="expires" content="-1" />
   <meta http-equiv= "pragma" content="no-cache" />
   <meta name="author" content="Sagie Maoz n0nick@php.net" />
   <meta name="robots" content="noindex,follow" />
   <meta name="MSSmartTagsPreventParsing" content="true" />
   <meta name="keywords"
   content="web, log, thoughts, stories, personal, poems, music, love, hate" />

</head>

<body>

<a href="honey.php?sr=<?=antiSpami($q).$q.antiSpami($q*2+39787654)?>"
dir="rtl">עוד, דבש, עוד, עוד!!</a>
<hr />
<?
spam2U();
?>
<hr>
<a href="http://www.exego.net/boydem/issue7/"><img
src="http://www.exego.net/boydem/issue7/images/dvash.gif" width="199"
height="22" border="0" alt="מלכודת הדבש של אתר קונספציה"
title="מלכודת הדבש של אתר קונספציה"></a>
</body>
</html>