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
		"MagicQuotes",
		"TmpDir",
		"IncludePath"
	);
	
	require("classes/SystemTest.php");
	$test = new SystemTest();
	
	foreach ($checks as $check) {
	
		if ($data = $test->check($check)) {
		
			switch ($data["r"]) {
				case 0:
					$result = "FAIL";
					$bgColour = "#FF0000";
					break;
				case 1:
					$result = "WARNING";
					$bgColour = "#FFFF00";
					break;
				default:
					$result = "PASS";
					$bgColour = "#00FF00";
			}
	
	?>
		<tr>
			<td><?=$check?></td>
			<td><?=$data["i"]?></td>
			<td style="background-color: <?=$bgColour?>;"><?=$result?></td>
		</tr>
	<?php
		}
	
	}
	?>
	</table>

</body>
</html>