{extends file="standard.tpl"}

{block name=body}
<h1>{$lang_reset} {$lang_password}</h1>

{if $message}

<p>
	{$message}
</p>

{else}

<form action="" method="post">

	<label for="email">{$lang_email_address}</label>
	<input type="text" id="email" name="email" />
	
	<input type="hidden" name="action" value="reset" />
	<input type="submit" value="{$lang_reset}" />

</form>

<script type="text/javascript">
$(document).ready(function () {
	$("#email").focus();
});
</script>

{/if}

<a href="{$root}system/auth/login" id="reset">&laquo; {$lang_login}</a>
{/block}