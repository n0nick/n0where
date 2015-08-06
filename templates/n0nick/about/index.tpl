{assign var="defskin" value=$site->getSetting('defskin')}
{include file="`$defskin`/head.tpl" title="`$site->name` :: about" site=$site}
{include file="about/head.tpl"}

<ul>
   <li><a href="{$site->getLink('about','site')}" title="על האתר">אודות
   {$site->name}.</a> על האתר, מה הוא אמור להיות ומה תמצאו כאן.</li>
   <li><a href="{$site->getLink('about','me')}" title="על עבדכם הנאמן">אודות {$site->webmaster}.</a>
   על {$site->webmaster}, האיש והמוזילה, ומה לעזאזל הוא רוצה מכם.</li>
   <li><a href="{$site->getLink('about','link')}" title="רוצים לקשר לאתר?">תן קישור.</a> אם יש
   לכם אתר ובא לכם לעשות לי שמח.</li>
   <li><a href="{$site->getLink('about','outside')}" title="אתרים שאהבתי">קישורים
   טובים.</a> אם נמאס לכם מכאן.</li>
</ul>
בעתיד:
<ul>
   <li>&#91;<a href="{$site->getLink('about','subscribe')}" title="רשימת הדיוור הצנועה שלי">עשו
   מנוי.</a>&#93; הרשמו וקבלו עדכונים בדוא"ל כש-n0where מתעדכן.</li>
   <li>&#91;<a href="{$site->getLink('about','system')}" title="קצת טכנולוגיה, מה">אודות
   המערכת.</a>&#93; על המערכת הטכנית שמריצה את האתר, ומה הקשר אליכם.</li>
</ul>

{include file="about/foot.tpl"}
{include file="`$defskin`/foot.tpl" site=$site}