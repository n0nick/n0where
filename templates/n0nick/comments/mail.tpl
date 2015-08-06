The user {$user} has posted a new comment to story#{$postid} in your blog;
{$comment}

To view the comment and/or reply to it, visit:
<{$site->url}/{$site->getLink('post',$postid)}>

To remove the comment, visit:
<{$site->url}/{$site->getLink('admin','comments','del',$commentid,$postid)}>


Best Regards,
Yourself
{$site->email}