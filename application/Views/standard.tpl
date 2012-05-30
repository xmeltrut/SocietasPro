<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>SocietasPro</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" type="text/css" href="application/Resources/stylesheets/admin.css" />
{if $session_admin_style}<link rel="stylesheet" type="text/css" href="application/Resources/stylesheets/highcontrast.css" />{/if}
<script type="text/javascript" src="application/Resources/javascript/jquery.js"></script>
<script type="text/javascript" src="{$root}admin/resources/js"></script>
{block name=head}{/block}
</head>
<body>

	<div id="container">
	
		<div id="header">
		
			<ul>
				<li>&raquo; <a href="{$root}system/auth/logout">{$lang_logout}</a></li>
				<li>&raquo; <a href="{$root}public">{$lang_view} {$lang_website|lower}</a></li>
			</ul>
			
			<h1>{$group_name}</h1>
			
			<div id="navigation">
				<a {if $controller == "default"}class="active"{/if} href="{$root}admin">{$lang_home}</a>
				{if $toggleMembers == "on"}<a {if $controller == "members"}class="active"{/if} href="{$root}admin/members">{$lang_members}</a>{/if}
				{if $toggleMailingList == "on"}<a {if $controller == "mailinglist"}class="active"{/if} href="{$root}admin/mailinglist">{$lang_mailing_list}</a>{/if}
				{if $toggleEvents == "on"}<a {if $controller == "events"}class="active"{/if} href="{$root}admin/events">{$lang_events}</a>{/if}
				{if $togglePages == "on"}<a {if $controller == "pages"}class="active"{/if} href="{$root}admin/pages">{$lang_pages}</a>{/if}
				{if $toggleBlog == "on"}<a {if $controller == "blog"}class="active"{/if} href="{$root}admin/blog">{$lang_blog}</a>{/if}
				<a {if $controller == "config"}class="active"{/if} href="{$root}admin/config">{$lang_configuration}</a>
				<a {if $controller == "reporting"}class="active"{/if} href="{$root}admin/reporting">{$lang_reporting}</a>
			</div>
			
			<hr />
		
		</div>
		
		{if $installDir}
		<div class="message" id="messageInstallDir">
			{$installDirMsg}
			<hr />
		</div>
		{/if}
		
		{if $msg}
		<div class="message" id="message">
			{$msg}
			<hr />
		</div>
		{/if}
		
		{block name=body}{/block}
	
	</div>

</body>
</html>