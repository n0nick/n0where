{assign var="template" value=$post->getAttribute('template')}
{if !$template}
{assign var="template" value=$post->site->getSetting('defskin')}
{/if}
{include file="`$template`/anchor.tpl" post=$post site=$post->site}