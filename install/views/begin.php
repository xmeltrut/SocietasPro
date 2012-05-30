<?php
/**
 * Begin page
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Installer
 */
?>
<h2>System Test</h2>

<table border="1" width="100%">
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
	"IncludePath",
	"SplAutoloadRegister"
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
		<td style="text-align: center; background-color: <?=$bgColour?>;"><?=$result?></td>
	</tr>
<?php
	}

}
?>
</table>

<?php if ($test->getFailCount() > 0) { ?>

<p>
	Problems were detected. This need to be resolved before you can proceed with the installer.
</p>

<form action="" method="post">
	<input type="hidden" name="step" value="" />
	<input type="submit" value="Try again" />
</form>

<?php } else { ?>

<p>
	All systems tests were passed, you can now proceed to the installer.
</p>

<form action="" method="post">
	<input type="hidden" name="step" value="configure" />
	<input type="submit" value="Proceed" />
</form>

<?php } ?>