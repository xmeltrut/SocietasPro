<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>SocietasPro</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" type="text/css" href="{$root}admin/resources/style" />
<script type="text/javascript" src="{$root}js/jquery.js"></script>
<script type="text/javascript" src="{$root}admin/resources/js"></script>
{block name=head}{/block}
</head>
<body>

	<div id="container">
	
		<div id="header">
		
			<ul>
				<li>&raquo; <a href="{$root}system/auth/logout">{$lang_logout}</a></li>
				<li>&raquo; <a href="{$root}public">{$lang_view}</a></li>
			</ul>
			
			<h1>{$group_name}</h1>
			
			<div id="navigation">
				<a {if $controller == "default"}class="active"{/if} href="{$root}admin">{$lang_home}</a>
				<a {if $controller == "members"}class="active"{/if} href="{$root}admin/members">{$lang_members}</a>
				<a {if $controller == "mailinglist"}class="active"{/if} href="{$root}admin/mailinglist">{$lang_mailing_list}</a>
				<a {if $controller == "events"}class="active"{/if} href="{$root}admin/events">{$lang_events}</a>
				<a {if $controller == "pages"}class="active"{/if} href="{$root}admin/pages">{$lang_pages}</a>
				<a {if $controller == "blog"}class="active"{/if} href="{$root}admin/blog">{$lang_blog}</a>
				<a {if $controller == "config"}class="active"{/if} href="{$root}admin/config">{$lang_configuration}</a>
				<a {if $controller == "reporting"}class="active"{/if} href="{$root}admin/reporting">{$lang_reporting}</a>
			</div>
			
			<hr />
		
		</div>
		
		{if $msg}
		<div id="message">
			{$msg}
			<hr />
		</div>
		{/if}
		
		{block name=body}{/block}
	
	</div>

</body>
</html>