; <?php die(); ?>
;
; Harness config. index.php picks this file for any host that isn't
; n0where.* or n0nick.*, so localhost lands here.
;
; IMPORTANT: for golden files to mean anything, every value outside the
; [database] section should match prod's inc/sagim.ini.php. Copy that file
; over this one and change only the database block. The values below are
; placeholders and WILL produce different output than prod.
;
; Parser note (Site::fetchConfig): splits on the first ';' as a comment and
; matches /(.*)=(.*)/ -- so values must not contain '=' or ';'.

[database]
hostname = db
username = n0db
password = n0db
name     = n0db
prefix   = n0_

[website]
name   = n0where
title  = n0where
slogan = local harness
url    = http://localhost:8074/n0/
path   = /var/www/html
theme  = n0nick

[webmaster]
name  = n0nick
email = webmaster@example.invalid

[admin]
password = localharness

[settings]
filemode       = path
filename       =
defskin        = n06
recent_count   = 10
allow_comments = 1
comment_alert  = 0
wordpress_api  =
time_offset    = 0
