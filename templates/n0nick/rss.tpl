<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0"
   xmlns:content="http://purl.org/rss/1.0/modules/content/"
   xmlns:wfw="http://wellformedweb.org/CommentAPI/"
   xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
    <title>{$site->name}</title>
    <link>{$site->url}/{$site->getLink()}</link>
    <description>{$site->slogan}</description>
    <pubDate>{$posts[0]->time|date_format:"%a, %e %b %Y %H:%M:%S +0200"}</pubDate> 
    <generator>http://n0nick.net/n0/</generator>
    <language>he</language>

{foreach item=post from=$posts}
<item>
    <title>{$post->getTitle()|strip_tags}</title>
    <link>{$site->url}/{$site->getLink('post',$post->postid)}</link>
    <comments>{$site->url}/{$site->getLink('comments',$post->postid)}</comments>
    <pubDate>{$post->time|date_format:"%a, %e %b %Y %H:%M:%S +0200"}</pubDate>
    <dc:creator>{$site->webmaster}</dc:creator>
    <guid isPermaLink="true">{$site->url}/{$site->getLink('anchor',$post->postid)}</guid>   
{*    <description>{$post->getExcerpt()}</description> *}
    <description>{$post->getContent()|strip_tags|autop}</description>
</item>

{/foreach}

</channel>

</rss>