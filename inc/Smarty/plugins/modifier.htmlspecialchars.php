<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty htmlspecialchars modifier
 *
 * Smarty 2 ships no plugin for this name, so {$x|htmlspecialchars} fell
 * through to PHP's htmlspecialchars() with whatever the default flags were.
 * PHP 8.1 changed that default from ENT_COMPAT | ENT_HTML401 to
 * ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, so every apostrophe in a post
 * or comment started rendering as &#039;.
 *
 * Pinning the pre-8.1 flags keeps 7.4 and 8.3 byte-identical. ENT_SUBSTITUTE
 * is deliberately omitted too: without it, invalid UTF-8 yields an empty
 * string as it did before, which matters here because the posts table is
 * CHARSET=hebrew and the comments table utf8mb3.
 *
 * Adopting ENT_QUOTES would be a reasonable hardening step, but it is a
 * behaviour change and belongs in its own commit, not in the port.
 *
 * @param string
 * @return string
 */
function smarty_modifier_htmlspecialchars($string)
{
    return htmlspecialchars((string) $string, ENT_COMPAT | ENT_HTML401);
}

/* vim: set expandtab: */

?>
