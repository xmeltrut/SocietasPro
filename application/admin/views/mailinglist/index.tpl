{extends file="standard.tpl"}

{block name=body}
<h2>{$lang_subscribers}</h2>

<p>
	Show recent subscribers
</p>

<h3>{$lang_create} {$lang_subscriber}</h3>
<p>
	<form action="" method="post">
		<input type="text" name="email" />
		<input type="hidden" name="action" value="create" />
		<input type="submit" />
	</form>
</p>

<h3>{$lang_delete} {$lang_subscriber}</h3>
<p>
	<form action="" method="post">
		<input type="text" name="email" />
		<input type="hidden" name="action" value="delete" />
		<input type="submit" />
	</form>
</p>

{/block}