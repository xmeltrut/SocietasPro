<?php
/**
 * Installer script
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Installer
 */

define("ROOT_DIR", "../");
require("bootstrap.php");

// custom install files
require("includes/general.php");
require("includes/install.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>SocietasPro Installer</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" type="text/css" href="style/install.css" />
</head>
<body>

<div id="container">

	<h1>SocietasPro Installer</h1>
	
	<div id="content">
	
		<?php
		$msg = "";
		$step = (isset($_POST["step"])) ? $_POST["step"] : "";
		
		switch ($step) {
			case "install":
				$rv = install($_POST["group_name"], $_POST["language"], $_POST["email"], $_POST["password"], $msg);
				if ($rv) { // if false, fall through
					require("views/install.php");
					break;
				}
			case "configure":
				$languages = Language::listAsArray();
				require("views/configure.php");
				break;
			default:
				require("views/begin.php");
		}
		?>
	
	</div>
	
	<div id="footer">
	
		<div class="left">
			<?php if ($step) { ?>&laquo; <a href="./">Start Again</a><?php } ?>
		</div>
		
		<div class="right">Powered by <a href="http://www.societaspro.org/">SocietasPro</a></div>
		
		<div class="clear"></div>
	
	</div>

</div>

</body>
</html>