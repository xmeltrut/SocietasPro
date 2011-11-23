<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>SocietasPro</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" type="text/css" href="{$root}system/resources/style" />
</head>
<body>

	<div class="box">

		<form action="" method="post">
		
			<label for="email">{$lang_email_address}</label>
			<input type="text" id="email" name="email" />
			
			<label for="password">{$lang_password}</label>
			<input type="password" id="password" name="password" />
			
			<input type="hidden" name="action" value="login" />
			<input type="submit" value="{$lang_login}" />
		
		</form>
	
	</div>

</body>
</html>