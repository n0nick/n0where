{assign var="defskin" value=$site->getSetting('defskin')}
{include file="`$defskin`/head.tpl" site=$site style="admin" title="`$site->name` administration"}

<h1>����� {$site->name}</h1>

{include file="`$defskin`/topnav.tpl" site=$site}

<div class="post">

<h2>����� ������</h2>

{*{assign var="posts" value=$site->getRecentPosts(15,$offset)}*}
{php}$this->_tpl_vars['posts'] = $this->_tpl_vars['site']->getRecentPosts(15, $this->_tpl_vars['offset']);{/php}

{if $page>1}
{assign var=prev value=`$page-1`}
<a href="{$site->getLink('admin','posts','list',$prev)}">�����</a>
{/if}
{assign var=next value=`$page+1`}
<a href="{$site->getLink('admin','posts','list',$next)}">�����</a>
<table class="posts-list">
   <tr>
      <th class="id">#</th>
      <th class="content">����</th>
      <th class="admin">�����</th>
   </tr>
{foreach from=$posts item=post name=postsf}
   <tr>
      <td>{$post->postid}</td>
      <td>{if $post->getTitle()}<strong>{$post->getTitle()|strip_tags}</strong>{/if}
      {$post->getExcerpt(95)|strip_tags}</td>
      <td>���� ���</td>
   </tr>
{/foreach}
</table>
</div>

{include file="`$defskin`/foot.tpl" site=$site}