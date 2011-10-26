<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>SocietasPro</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" type="text/css" href="/style/system.css" />
</head>
<body>

	<form action="" method="post">
	
		{$lang_email}: <input type="text" name="email" />
		
		{$lang_password}: <input type="password" name="password" />
		
		<input type="hidden" name="action" value="login" />
		<input type="submit" value="{$lang_login}" />
	
	</form>

</body>
</html>