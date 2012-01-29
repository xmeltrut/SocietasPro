<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
<!--<link href="http://fonts.googleapis.com/css?family=Buda:light" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet" type="text/css">-->
<title>{$group_name}</title>
<link rel="stylesheet" type="text/css" href="{$root}public/resources/style" />
{block name=head}{/block}
</head>

<body>

<div id="wrap">

<div id="header">
<h1>{$group_name}</h1>
</div>

<div id="menu"> 
<ul>
<li><a href="{$root}public">Home</a></li>
<li><a href="{$root}public/events">Events</a></li>
<li><a href="{$root}public/events/calendar">Calendar</a></li>
<li><a href="{$root}public/blog">Blog</a></li>
</ul>
</div>

<div id="content">

<div class="right">

{block name=body}{/block}

</div>

<div class="lefttop"> </div>

<div class="left">

{foreach $menu as $menuLevel}
<h3>
	{if $menuLevel["header"]}
	{$menuLevel["header"]}
	{else}
	Pages
	{/if}
</h3>

<ul>
{foreach $menuLevel["pages"] as $menuItem}
<li><a href="{$root}public/default/page/{$menuItem->pageSlug}">{$menuItem->pageName}</a></li>
{/foreach}
<li><a href="#">Last Category Link</a><br>Description of the last category</li>
</ul>
{/foreach}

</div>

<div class="leftbottom"> </div>

<div style="clear: both;"> </div>

</div>

<div id="footer">
<div class="footerleft">&copy; {$current_year} {$group_name}. Powered by <a href ="http://www.societaspro.org/">SocietasPro</a>.</div>
<div class="footerright"><a href="http://yoctotemplates.com/free-web-templates/green-stripes/">Green Stripes</a> | Design by <a href="http://yoctotemplates.com">Yocto Templates</a></div>
<div style="clear: both;"> </div>
</div>

</div>

</body></html>