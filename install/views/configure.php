<?php
/**
 * Configure page
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Installer
 */
?>
<h2>Configure</h2>

<form action="" method="post" name="form" id="form">

	<?php if ($msg != "") { ?>
	<fieldset class="errorShading">
		<legend>Error</legend>
		
		<?=$msg?>
	</fieldset>
	<?php } ?>

	<fieldset>
		<legend>Install details</legend>
		
		<ol>
			<li>
				<label for="group_name">Group name</label>
				<input type="text" name="group_name" id="group_name" value="<?=reqSet("group_name")?>" />
			</li>
			<li>
				<label for="language">Language</label>
				<select id="language" name="language">
					<?php foreach ($languages as $key => $val) { ?>
					<option value="<?=$key?>" <?php if ($key == reqSet("language")) { ?>selected="selected"<?php } ?>><?=$val?></option>
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
				<input type="text" id="email" name="email" value="<?=reqSet("email")?>" />
			</li>
			<li>
				<label for="password">Password</label>
				<input type="password" id="password" name="password" />
			</li>
		</ol>
	</fieldset>
	
	<input type="hidden" name="step" value="install" />
	<input type="submit" value="Begin install" />

</form>

<script type="text/javascript">
document.forms['form'].elements['group_name'].focus();
</script>