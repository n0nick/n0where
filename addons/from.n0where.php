<?php

// database connection to old table
$db0 = mysql_connect('localhost','n0nick','dbpas5',TRUE);
mysql_select_db('n0where',$db0);

// site object
require_once('inc/include.inc.php');
$site = new Site('inc/conf.ini.php');

?>
