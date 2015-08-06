 <!DOCTYPE html
   PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" dir="rtl">

<head>
   <title>{$title|default:$site->title}</title>

   <base href="{$site->url}/" />

   <link rel="stylesheet" href="styles/{$site->theme}/n05/main.css" title="n0where 5.0" media="all" type="text/css" />
   <style type="text/css"><!-- @import url('styles/{$site->theme}/n05/personal.css'); --></style>
   {if $style}<style type="text/css"><!-- @import url('styles/{$site->theme}/n05/{$style}.css'); --></style>{/if}
   <link rel="icon" href="favicon.ico" type="image/ico" />

   <link rel="alternate" type="application/rss+xml" title="n0feed"
         href="http://feeds.feedburner.com/n0nick" />

   <link rel="index"      href="{$site->getLink()}" />
   <link rel="start"      href="{$site->getLink()}" />
   <link rel="first"      href="{$site->getLink('post',1)}" />
   <link rel="last"       href="{$site->getLink()}" />
{if $prev != 0}
   <link rel="prev"       href="{$site->getLink('post',$prev)}" />
{/if}
{if $next != 0}
   <link rel="next"       href="{$site->getLink('post',$next)}" />
{/if}
   <link rel="author"     href="{$site->getLink('about','me')}" />
   <link rel="copyright"  href="http://creativecommons.org/licenses/by-sa/1.0/" />
   <link rel="openid.server" href="http://n0nick.net.net/id/" />

   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="expires" content="-1" />
   <meta http-equiv= "pragma" content="no-cache" />
   <meta name="author" content="{$site->webmaster} {$site->email}" />
   <meta name="robots" content="index,follow" />
   <meta name="MSSmartTagsPreventParsing" content="true" />
   <meta name="Description" content="{$site->name} {$site->slogan}" />

{* stupid fix for stupid ie css bug *}
{ie_detect}
{if $ie}
{literal}
   <style type="text/css">
   div#mirror {
      right: 782px;
   }
   </style>
{/literal}
{/if}

{literal}
   <script language="javascript" type="text/javascript">
   //<![CDATA[
      window.name='n0main';
      function comments(c) {
         window.open(c, 'n0comments', 'toolbar=yes, directories=no,'
                    +'status=no, resizable=yes, scrollbars=yes, location=no'
                    +', dependent, width=400, height=350');
      }
      function commentsp(c) {
         if (window.event && window.event.keyCode == 13) {
            return comments(c);
         }
      }
   //]]>
   </script>

<!-- ukey="7BF5A3BE" --><!-- ukey="7BF5A3BE" -->
<!-- Google Analytics code -->
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-166973-1";
urchinTracker();
</script>
{/literal}

<!--

<rdf:RDF xmlns="http://web.resource.org/cc/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
<Work rdf:about="">
   <dc:title>n0where</dc:title>
   <dc:date>2004</dc:date>
   <dc:description>The genuine personal thoughts and ideas of a someone.</dc:description>
   <dc:creator><Agent>
      <dc:title>n0nick</dc:title>
   </Agent></dc:creator>
   <dc:rights><Agent>
      <dc:title>n0nick</dc:title>
   </Agent></dc:rights>
   <dc:type rdf:resource="http://purl.org/dc/dcmitype/Text" />
   <dc:source rdf:resource="http://n0nick.net/"/>
   <license rdf:resource="http://creativecommons.org/licenses/by-sa/2.0/" />
</Work>

<License rdf:about="http://creativecommons.org/licenses/by-sa/2.0/">
   <permits rdf:resource="http://web.resource.org/cc/Reproduction" />
   <permits rdf:resource="http://web.resource.org/cc/Distribution" />
   <requires rdf:resource="http://web.resource.org/cc/Notice" />
   <requires rdf:resource="http://web.resource.org/cc/Attribution" />
   <permits rdf:resource="http://web.resource.org/cc/DerivativeWorks" />
   <requires rdf:resource="http://web.resource.org/cc/ShareAlike" />
</License>

</rdf:RDF>

-->
</head>

<body>

<div id="page">
