<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>SocietasPro</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" type="text/css" href="/style/admin.css" />
</head>
<body>
[ <a href="{$root}admin">{$lang_home}</a> ]
[ <a href="{$root}admin/members">{$lang_members}</a> ]
[ <a href="{$root}admin/events">{$lang_events}</a> ]
[ <a href="{$root}system/auth/logout">{$lang_logout}</a> ]
<hr />
{if $msg}
	{$msg}
	<hr />
{/if}
{block name=body}{/block}
</body>
</html>