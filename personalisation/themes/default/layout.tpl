<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
<link href="http://fonts.googleapis.com/css?family=Buda:light" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet" type="text/css">
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

<h3>Navigation</h3>

<ul>
{foreach $menu as $menuItem}
<li><a href="{$root}public/default/page/{$menuItem->pageSlug}">{$menuItem->pageName}</a></li>
{/foreach}
<li><a href="#">About Us Information</a><br>Link to our business information</li>
<li><a href="#">Resources and Friends</a><br>Related resources and friends</li>
<li><a href="#">Last Category Link</a><br>Description of the last category</li>
</ul><h3>Advertisments</h3>
<ul><li><a href="http://f248f4qj7gxjpeaay9pqtaboaq.hop.clickbank.net/?tid=GS">Adsense $100k Blueprint</a><br>Amazing Adsense guide. Step-by-step! No fluff!</li>
<li><a href="http://9d0442lg4b0mwj7cnolx4l1w16.hop.clickbank.net/?tid=GS">Web Design Business Startup Kit</a><br>A complete turnkey business solution for web designers</li>
<li><a href="http://11795.rapbank.com">RapBank.com</a><br>Join for free and get paid instant commision</li>
<li><a href="http://rapbank.com/go/1476/11795">Newbie Start Up Guide</a><br>Everything is laid out in plain English</li>
</ul><h3>Latest Articles</h3>
<ul><li><a href="#">List Your Latest Articles</a></li>
<li><a href="#">Praesent augue nibh</a></li>
<li><a href="#">Vestibulum ante ipsum primis</a></li>
<li><a href="#">Pellentesque vulputate mi quis erat</a></li>
<li><a href="#">Anothe filler link</a></li>
<li><a href="#">Aenean interdum fermentum felis</a></li>
<li><a href="#">Maecenas et aliquet nisl</a></li>
<li><a href="#">Integer dapibus vulputate ornare</a></li>
<li><a href="#">Sagittis et venenatis nisi</a></li>
</ul></div>

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