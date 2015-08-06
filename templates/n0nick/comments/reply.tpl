{include file="comments/head.tpl" site=$site postid=$post->postid}

{include file="comments/comment.tpl" comment=$parent site=$site}
{include file="comments/form.tpl" parentid=$parent->commentid site=$site postid=$post->postid cookie=$cookie}

{include file="comments/foot.tpl" site=$site postid=$post->postid}