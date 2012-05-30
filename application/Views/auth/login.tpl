{extends file="system.tpl"}

{block name=body}
<form action="" method="post">

	<label for="email">{$lang_email_address}</label>
	<input type="text" id="email" name="email" />
	
	<label for="password">{$lang_password}</label>
	<input type="password" id="password" name="password" />
	
	<input type="hidden" name="action" value="login" />
	<input type="submit" value="{$lang_login}" />
	
	<a href="{$root}system/auth/reset" id="reset">{$forgotten_your_password}</a>

</form>

<script type="text/javascript">
$(document).ready(function () {
	$("#email").focus();
});
</script>
{/block}