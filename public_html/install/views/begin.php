<?php
/**
 * Begin page
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Installer
 */
?>
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

$nextStep = ($test->getFailCount() > 0) ? "" : "begin";
?>
</table><br />

<form action="" method="post">
	<input type="hidden" name="step" value="<?=$nextStep?>" />
	<input type="submit" value="Proceed" />
</form>