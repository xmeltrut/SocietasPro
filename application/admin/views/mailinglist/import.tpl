{extends file="mailinglist/standard.tpl"}

{block name=innerhead}
<style type="text/css">
.subscriberList {
	width: 100%;
	height: 20em;
}
</style>
{/block}

{block name=innerbody}
<h2>{$lang_import} {$lang_subscribers}</h2>

{$form}
{/block}