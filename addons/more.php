<?php
$post = $this->_tpl_vars['post'];

$d = date('j', $post->time);
$m = date('n', $post->time);
$y = date('Y', $post->time);

// get today's posts
$today_begin = mktime(0,0,0,$m,$d,$y);
$today_end   = mktime(23,59,59,$m,$d,$y);

$sql = 'SELECT `postid`, `time`, `content`, `comments_count` '
      .'FROM `+posts` '
      .'WHERE (`time`>=\''.$today_begin.'\' AND `time`<=\''.$today_end.'\') '
      .'AND (`postid` != \''.$post->postid.'\') '
      .'ORDER BY `postid` DESC';

$que   = $post->site->db->query($sql);
$today = array();
while ($data = $post->site->db->fetch_assoc($que)) {
   $psst = new Post($post->site);
   $psst->fetch_from_array($data);
   $today[] = $psst;
}

// get yesterday's posts
$yestrday_begin = mktime(0,0,0,$m,$d-1,$y);
$yestrday_end   = mktime(23,59,59,$m,$d-1,$y);

$sql = 'SELECT `postid`, `time`, `content`, `comments_count` '
      .'FROM `+posts` '
      .'WHERE `time`>=\''.$yestrday_begin.'\' AND `time`<=\''.$yestrday_end.'\''
      .' ORDER BY `postid` DESC';

$que   = $post->site->db->query($sql);
$yesterday = array();
while ($data = $post->site->db->fetch_assoc($que)) {
   $psst = new Post($post->site);
   $psst->fetch_from_array($data);
   $yesterday[] = $psst;
}

// assign
$this->assign('today',     $today);
$this->assign('yesterday', $yesterday);
?>