{assign var="defskin" value=$site->getSetting('defskin')}
{include file="`$defskin`/head.tpl" title="`$site->name` :: about : `$site->webmaster`" site=$site}
{include file="about/head.tpl"}

<div class="here"><a href="{$site->getLink('about')}" title="על האתר">אודות</a> &gt;
{$site->webmaster}</div>
<ul>
<li><a href="{$site->getLink('about','me')}#who" title="מי אתה?">מי אתה?</a></li>
<li><a href="{$site->getLink('about','me')}#nick" title="מה זה n0nick?">מה זה n0nick?</a>
</li><li><a href="{$site->getLink('about','me')}#want" title="מה אתה רוצה ממני?">מה אתה
רוצה ממני?</a></li>
<li><a href="{$site->getLink('about','me')}#sell" title="מה אתה מוכר?">מה אתה מוכר?</a>
</li><li><a href="{$site->getLink('about','me')}#howmuch" title="כמה עולה?">כמה עולה?</a>
</li><li><a href="{$site->getLink('about','me')}#contct" title="איך יוצרים אתך קשר?">איך
יוצרים אתך קשר?</a></li>
<li><a href="{$site->getLink('about','me')}#s666" title="שאלה לסיום">ולסיום,</a></li>
</ul>
<p style="text-align: left; direction: ltr;"><a
href="http://3e.org/g2ef" title="My Blogger code">B7 d t++ k s u-- f- i- o++ x e- l- c-</a></p>
<h3 class="n0nick"><a id="who">מי אתה?</a></h3>
<img src="img/meself.png" width="145" height="96"
     title="נו, אז אני לא יודע לצלם" alt="{$site->webmaster}" class="float-left" />
<p>אני <strong>{$site->webmaster}</strong>, אני בן, אני
בן {php}print floor(((time()-mktime(12,0,0,6,17,1985))/31536000));{/php} 
ואני מאשדוד.<br />
בחיים אני עוד אחד במשבר גיל 18-21 של ללבוש רק ירוק ולירות על אנשים. אומרים
שזה יעבור.</p>
<p>לפני הצבא: עשיתי בית-ספר (כיתת מחוננים-אעלק, הרבה מדי יחידות בגרות ופחות
מדי שעות שינה), למדתי שטויות אחרות גם בחוץ, עבדתי ב<a
href="http://www.gamer.co.il/" title="Gamer">גיימר</a> (בכל תפקיד אפשרי כמעט),
בניתי אתרים, קניתי מוזיקה, שתיתי אלכוהול ורצחתי את ארלוזורוב.</p>
<p>עכשיו: משתדל לנצל את סופי השבוע שאני בבית.<br />
אבל כנראה לא כל כך מצליח, כי הנה חזרתי לכתוב פה...</p>
<h3 class="n0nick"><a id="nick">מה זה n0nick?</a></h3>
<p>לא יודע.</p>
<h3 class="n0nick">ובכל זאת?</h3>
<p>n0nick זה כינוי שמצאתי שהיה פנוי פעם ב-<a href="http://www.dal.net/"
title="דאלנט, רשת שרתי צ'אט">DALnet</a>, אז רשמתי אותו על שמי בלי כל
כוונה ממשית להשתמש בו. בסופו של דבר התחלתי להשתמש בו בכמה מקומות, ובהדרגה הוא
הפך לכינוי הרשמי שלי. למה? לא יודע. מה המשמעות של זה? לא יודע.<br />
אבל זה שם מגניב. לא?<br />
אתם יכולים לקרוא לי ניק, אם ממש בא לכם.</p>
<h3 class="n0nick"><a id="want">מה אתה רוצה ממני?</a></h3>
<p>בעיקרון, כלום.<br />
הייתי מבקש שאולי <a href="http://www.bdidut.com/" title="בדידות">תקבלו מושג</a>,
או אולי אפילו ש<a href="http://www.radiohead.co.uk" title="radiohead">תשמעו
משהו</a>, אבל אני יודע שזה מוגזם.<br />
אם הייתי באמת חוצפן, הייתי שולח אתכם <a href="http://www.tve.co.il/buffy"
title="Buffy the Vampire Slayer">לאהוב מה שאני אוהב</a> או <a
href="http://www.fsf.org/" title="FSF">להאמין במה שאני מאמין</a>.<br />
אבל אתם יודעים שאני  נחמד מדי בשביל לבקש דברים כאלה.</p>
<h3 class="n0nick"><a id="sell">מה אתה מוכר?</a></h3>
<p>את עצמי.</p>
<h3 class="n0nick"><a id="howmuch">כמה עולה?</a></h3>
<p>אמממ, עזבו. אני לא חושב שאתם יכולים להרשות לעצמכם.</p>
<h3 class="n0nick"><a id="contct">איך יוצרים איתך קשר?</a></h3>
<p>אפשר לשלוח דוא"ל:
{mailto address=$site->email encode="javascript" extra='title="Email me"'}.<br />
<p>אפשר לשלוח הודעות <a href="http://www.icq.com/22632125"
title="ICQ#22632125">ICQ</a>,<br />
ומי שבאמת מעוניין יבקש את כתובת הדוא"ל הצבאי, או אפילו את הכתובת או מס' הטלפון,<br />
דרך אחד מאלה.</p>
<h3 class="n0nick"><a id="s666">ולסיום, מה השיא שלך בסנייק?</a></h3>
<p>666.<br /><span xml:lang="en" dir="ltr">And I'm damn proud of it!</span></p>

{include file="about/foot.tpl"}
{include file="`$defskin`/foot.tpl" site=$site}
