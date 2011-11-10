<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>SocietasPro Bug Scanner</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" type="text/css" href="style/screen.css" />
</head>
<body>

	<h1>Bug Scanner</h1>
	
	<table border="1">
		<tr>
			<th>Line</th>
			<th>Notice</th>
			<th>Code</th>
			<th>&nbsp;</td>
		</tr>
		{foreach from=$messages item=item}
		<tr>
			<td colspan="4">{$item[0]}</td>
		</tr>
		{foreach from=$item[1] item=report}
		<tr>
			<td>{$report[2]}</td>
			<td>{$report[1]}</td>
			<td>{$report[3]}</td>
			<td>{$report[0]}</td>
		</tr>
		{/foreach}
		{/foreach}
	</table>

</body>
</html>