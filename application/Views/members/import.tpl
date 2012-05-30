{extends file="members/standard.tpl"}

{block name=innerhead}
<style type="text/css">
.subscriberList {
	width: 100%;
	height: 20em;
}
</style>
{/block}

{block name=innerbody}
<h2>{$lang_import} {$lang_members}</h2>

{if $is_writable}
	{$form}
{else}
	{$not_writable}
{/if}
{/block}