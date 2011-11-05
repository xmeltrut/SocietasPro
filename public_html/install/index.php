<?php
/**
 * Installer script
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Installer
 */

require("bootstrap.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>SocietasPro Installer</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" type="text/css" href="style/install.css" />
</head>
<body>

	<h1>SocietasPro Installer</h1>
	
	<table border="1">
		<tr>
			<th>Check</th>
			<th>Output</th>
			<th>Result</th>
		</tr>
	<?php
	$checks = array (
		"PhpVersion",
		"Curl",
		"MagicQuotes"
	);
	
	require("systemtest.php");
	$test = new SystemTest();
	
	foreach ($checks as $check) {
	
		$checkName = "check".$check;
		$getName = "get".$check;
		$testResult = ($test->$checkName()) ? "OK" : "FAIL";
	?>
		<tr>
			<td><?=$check?></td>
			<td><?=$test->$getName()?></td>
			<td><?=$testResult?></td>
		</tr>
	<?php
	}
	?>
	</table>

</body>
</html>