<?xml version="1.0" encoding="utf-8"?"?>
<rdf:RDF
	xmlns="http://purl.org/rss/1.0/"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
   xmlns:html="http://www.w3.org/1999/xhtml"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:admin="http://webns.net/mvcb/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
>

<channel rdf:about="{$site->url}/{$site->getLink('about')}">
    <title>{$site->name}</title>
    <link>{$site->url}/{$site->getLink()}</link>
    <description>{$site->slogan}</description>
    <webmaster>{$site->email}</webmaster>
    <dc:language>he</dc:language>

    <items>
        <rdf:Seq>
{foreach item=post from=$posts}
            <rdf:li rdf:resource="{$site->url}/{$site->getLink('post',$post->postid)}" />
{/foreach}
        </rdf:Seq>
    </items>

</channel>

{foreach item=post from=$posts}
<item rdf:about="{$site->url}/{$site->getLink('post',$post->postid)}">
    <title>{$post->getTitle()}</title>
    <link>{$site->url}/{$site->getLink('post',$post->postid)}</link>
    <description>{$post->getContent()|autop|n0tags}</description>
    <author>{$site->email}</author>
    <comments>{$site->url}/{$site->getLink('comments',$post->postid)}</comments>
    <guid isPermaLink="true">{$site->url}/{$site->getLink('anchor',$post->postid)}</guid>
    <pubDate>{$post->time|date_format:"%Y-%m-%d %H:%M"}</pubDate>
    <dc:creator>{$site->webmaster}</dc:creator>
    <dc:date>{$post->time|date_format:"%Y-%m-%dT%H:%M:%S+02:00"}</dc:date>
</item>

{/foreach}

</rdf:RDF>