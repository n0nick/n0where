{assign var="defskin" value=$site->getSetting('defskin')}
{include file="`$defskin`/head.tpl" title="`$site->name` :: about : link" site=$site}
{include file="about/head.tpl"}

<div class="here"><a href="{$site->getLink('about')}" title="על האתר">אודות</a> &gt;
תן קישור</div>
<h3>אז אתם נדיבים במיוחד היום.</h3>
<p>אם אתם מתעקשים לקשר מהאתר שלכם לכאן, אין לי ברירה אלא לעזור לכם.<br />
הדרך הכי טובה לדעתי לקשר לאתר היא באמצעות הקוד המופלא הבא שיצרתי תוך שימוש
בטכנולוגיות מדהימות וחדשניות:<br />
<textarea class="linkcode" rows="3" cols="30" dir="ltr">&lt;a href="{$site->url}"
title="{$site->name}" dir="ltr"&gt;{$site->name}&lt;/a&gt;</textarea><br />
השימוש בקוד הקסמים הנ"ל יצור קישור כזה: <a href="{$site->url}"
title="{$site->name}" dir="ltr">{$site->name}</a><br />
נכון מדהים?</p>
<p>אבל אם חשקה נפשכם במשהו יותר מפואר ומרשים, אני מרשה לכם להשתמש בזה:<br />
<textarea class="linkcode" rows="3" cols="30" dir="ltr">&lt;a
href="{$site->url}"&gt;&lt;img src="{$site->url}/img/button.png" width="88"
height="31" alt="{$site->name}" title="{$site->name}" dir="ltr"
/&gt;&lt;/a&gt;</textarea><br />
השימוש בקוד זה יצור קישור כזה: <a href="{$site->url}"><img
   src="{$site->url}/img/button.png" width="88" height="31"
   alt="{$site->name}" title="{$site->name}" dir="ltr" /></a></p>
<p>אם אתם אכן מקשרים אליי ברוב טובכם, <b>רגשו אותי</b> וספרו לי שעשיתם כן,
בצירוף כתובת האתר שלכם, כדי שאוכל להתפאר בפני החברים שלי, וגם כדי שאוכל לקשר
אליכם בחזרה ב<a href="{$site->getLink('about','outside')}" title="קישורים טובים">רשימת
הקישורים</a> שלי:
{mailto address=$site->email encode="javascript" extra='title="Email me"'}.</p>

{include file="about/foot.tpl"}
{include file="`$defskin`/foot.tpl" site=$site}
