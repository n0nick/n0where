</div>

<div id="mirror"></div>

{include_php file="addons/figure.php"}
<div id="figure">
<img src="{$site->url}/img/actionfigures/{$figure_filename}.png" height="{$figure_height}"
     width="{$figure_width}" alt="{$figure_alt}" title="{$figure_alt}" dir="ltr" />
{png_image src="`$site->url`/img/logo1.png" height="69" width="200" alt="n0where!"
extra="title=\"n0where!\" id=\"logo1\""}
<div id="foot">
<p>{$smarty.now|date_format:"%Y"}
<a href="http://creativecommons.org/licenses/by-sa/2.0/" rel="Credits"
title="Creative Commons Attribution-ShareAlike 2.0 License">&copy;
חלק</a> מהזכויות שמורות ל-{mailto address="`$site->email`"
text="`$site->webmaster`" encode="javascript"
extra='title="mail me" rel="Credits"'}.<br />
רץ על מערכת <a href="http://bl0g.sf.net/" rel="Credits"
title="מערכת חופשית לניהול בלוגים בעברית">n0bl0g</a>.
עיצוב ע"י {mailto address="kenny_mirc@hotmail.com" text="רעוט"
encode="javascript" extra='title="מעצבת משכמה ומעלה" rel="Credits"'
hebrew="yes"}.<br />
מתנחל בחוצפה אצל <a href="http://www.freaktalk.com/" rel="Credits"
title="הגיגי מר אדון">מר אדון</a>.</p>
<p class="bench">{$site->getBenchmark()},
<a href="{$site->url}/honey.php" title="מלכודת דבש (למנועי ספאם)"
   rel="Benchmarks">honey</a>!<br />
valid <a href="http://validator.w3.org/check?uri=referer" rel="Benchmarks"
title="Valid XHTML 1.0!">xhtml1</a>,
<a href="http://3e.org/g2ed" title="Valid CSS!" rel="Benchmarks">css2</a>.<br />
<a href="http://feeds.feedburner.com/n0nick" rel="Benchmarks"
title="n0where feed"><img src="img/rss.png" width="36"
height="14" border="0" alt="rss" /></a></p>
<p class="ksth">The pictures, drawings, texts and logos collected
in the collage above may be the trademarks of their respective
owners. All rights on these items are reserved to their respective
owners. No commercial use was done with these items. This website
is for personal purposes only. In any case of a proved copyright
violation, please contact
{mailto address=$site->email text="the webmaster" encode="javascript"
extra='title="mail me"'} immediately for the removal
of the relevant item(s).</p>

<p><a href="http://www.goats.com/" title="Goats: The Comic Strip"><img
src="http://www.goats.com/images/button_diab.gif" width="88" height="33"
alt="Goats: The Comic Strip" title="Goats: The Comic Strip"
style="border: 1px solid #012; margin-bottom: 2px;" /></a><br />
<a href="http://www.questionablecontent.com/" title="Questionable Content"><img
src="http://www.questionablecontent.net/banners/QCminibutton_01.gif"
width="88" height="31" alt="Questionable Content" title="Questionable Content"
style="border: 1px solid #012; margin-bottom: 2px;" /></a><br />
<a href="http://www.megagamerz.com/" title="megaGAMERZ 3133T by DIABLO"><img
src="http://www.megagamerz.com/images/linkbutton_gamer2.gif"
width="88" height="33" alt="megaGAMERZ 3133T" title="megaGAMERZ 3133T"
style="border: 1px solid #012; margin-bottom: 2px;" /></a></p>

<p><br /><a title="Take back the Web - Get Firefox!"
href="http://www.spreadfirefox.com/?q=affiliates&amp;id=4947&amp;t=73"><img
src="img/get-firefox-red.png" width="106" height="51" alt="Firefox: Rediscover the web"
title="Firefox: Rediscover the web" style="border: 0px;" /></a></p>
</div>
</div>

</body>
</html>
