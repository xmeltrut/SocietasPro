{extends file="standard.tpl"}

{block name=head}
<style type="text/css">
.subscriberList {
	width: 100%;
	height: 20em;
}
</style>
{/block}

{block name=body}
<h2>{$lang_import} {$lang_subscribers}</h2>

{$form}
{/block}