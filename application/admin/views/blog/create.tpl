{extends file="standard.tpl"}

{block name=head}
<script type="text/javascript" src="{$root}js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
</script>
{/block}

{block name=body}
<h2>{$lang_create} {$lang_blog} {$lang_post}</h2>

{$form}
{/block}