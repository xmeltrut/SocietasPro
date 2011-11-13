<?php
/**
 * Configure page
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Installer
 */
?>
<form action="" method="post">

	<fieldset>
		<legend>Install details</legend>
		
		<ol>
			<li>
				<label for="">Group name</label>
				<input type="text" />
			</li>
			<li>
				<label for="language">Language</label>
				<select id="language" name="language">
					<?php foreach ($languages as $key => $val) { ?>
					<option value="<?=$key?>"><?=$val?></option>
					<?php } ?>
				</select>
			</li>
		</ol>
	</fieldset>
	
	<fieldset>
		<legend>Your account</legend>
		
		<ol>
			<li>
				<label for="email">Email address</label>
				<input type="text" id="email" name="email" />
			</li>
			<li>
				<label for="password">Password</label>
				<input type="password" id="password" name="password" />
			</li>
		</ol>
	</fieldset>
	
	<input type="hidden" name="step" value="configure" />
	<input type="submit" value="Begin install" />

</form>