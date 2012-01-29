<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>{$group_name}</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="{$root}public/resources/style" />
<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css" />
{block name=head}{/block}
</head>

<body>

<div id="wrapper">
	<div id="header-wrapper">
		<div id="header">
			<div id="logo">
				<h1>{$group_name}</h1>
			</div>
		</div>
	</div>
	<!-- end #header -->
	<div id="menu">
		<ul>
			<li class="current_page_item"><a href="{$root}public">Home</a></li>
			<li><a href="{$root}public/events">Events</a></li>
			<li><a href="{$root}public/events/calendar">Calendar</a></li>
			<li><a href="{$root}public/blog">Blog</a></li>
		</ul>
	</div>
	<!-- end #menu -->
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
			
				<div id="content">
				
					{block name=body}{/block}
				
					<div style="clear: both;"></div>
				
				</div>
				<!-- end #content -->
				
				<div id="sidebar">
				
					<ul>
						{foreach $menu as $menuLevel}
						<li>
							<h2>
								{if $menuLevel["header"]}
								{$menuLevel["header"]}
								{else}
								Pages
								{/if}
							</h2>
							
							<ul>
							{foreach $menuLevel["pages"] as $menuItem}
							<li>
								<a href="{$root}public/default/page/{$menuItem->pageSlug}">{$menuItem->pageName}</a>
							</li>
							{/foreach}
							</ul>
						</li>
						{/foreach}
					</ul>
				
				</div>
				<!-- end #sidebar -->
				
				<div style="clear: both;"></div>
			
			</div>
		</div>
	</div>
	
	<!-- end #page -->
</div>

<div id="footer">
	<p>&copy; {$current_year} {$group_name}. Powered by <a href ="http://www.societaspro.org/">SocietasPro</a>. Design by <a href="http://www.freecsstemplates.org/">CSS Templates</a>.</p>
</div>
<!-- end #footer -->
</body></html>