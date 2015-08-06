{foreach name=emoticons key=code item=file from=$site->emoticons}
<img src="{$site->url}/img/emoticons/{$file}"
	{$site->emoticons_size}
	alt="{$code}" title="{$code}"
	onclick="emoticon('{$code}')" onkeypress="emoticonp('{$code}')"
	class="emticn-add" />
{/foreach}
