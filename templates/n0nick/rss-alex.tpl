<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0"
   xmlns:content="http://purl.org/rss/1.0/modules/content/"
   xmlns:wfw="http://wellformedweb.org/CommentAPI/"
   xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
    <title>{$site->name}</title>
    <link>{$site->url}/{$site->getLink()}</link>
    <description>{$site->slogan}</description>
    <pubDate>Fri, 29 Apr 2005 18:52:17 +0000</pubDate> {**@TODO!!!!!**}
    <generator>http://n0nick.net/n0/</generator>
    <language>he</language>

{foreach item=post from=$posts}
<item>
    <title>{$post->getTitle()}</title>
    <link>{$site->url}/{$site->getLink('post',$post->postid)}</link>
    <comments>{$site->url}/{$site->getLink('comments',$post->postid)}</comments>
    <pubDate>{$post->time|date_format:"%a, %e %b %Y %H:%M:%S +0200"}</pubDate>
    <dc:creator>{$site->webmaster}</dc:creator>
    <guid isPermaLink="true">{$site->url}/{$site->getLink('anchor',$post->postid)}</guid>   
    <description>{$post->getContent()|autop|n0tags}</description>
</item>

{/foreach}

</channel>

</rss>