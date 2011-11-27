<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>SocietasPro</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" type="text/css" href="{$root}system/resources/style" />
<script type="text/javascript" src="{$root}js/jquery.js"></script>
</head>
<body>

	{if $msg}
	<div id="msg">
		{$msg}
	</div>
	{/if}

	<div class="box">
	
		{block name=body}{/block}
	
	</div>

</body>
</html>