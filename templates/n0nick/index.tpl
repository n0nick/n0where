{assign var="post" value=$site->getRecentPosts(1)}
{assign var="post" value=$post[0]}
{if !empty($post)}
{include file="anchor.tpl" post=$post cookie=$cookie}
{else}
{$site->displayError('index.tpl', 'No posts found.')}
{/if}
