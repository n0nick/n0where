<?php

$site = $this->_tpl_vars['site'];

$sql = 'SELECT `figureid`,`filename`,`width`,`height`,`alt` '
      .'FROM `+figures` '
      .'WHERE 1 ' //`figureid`=19 '
      .'ORDER BY RAND();';

$que    = $site->db->query($sql);
$figure = $site->db->fetch_assoc($que);

$this->assign('figure_filename', $figure['filename']);
$this->assign('figure_width',    $figure['width']);
$this->assign('figure_height',   $figure['height']);
$this->assign('figure_alt',      htmlspecialchars($figure['alt']));

?>