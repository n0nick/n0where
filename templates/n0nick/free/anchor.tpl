{assign var="next" value=$post->getNext()}
{assign var="prev" value=$post->getPrev()}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>{$post->getTitle()}</title>
  </head>
  <body>
{assign var="post" value=$post->getContent()}
{eval var=$post}
  </body>
  </html>