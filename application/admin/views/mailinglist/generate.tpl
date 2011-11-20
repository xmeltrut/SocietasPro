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
<h2>{$lang_mailing_list}</h2>

<textarea class="subscriberList">{$subscribers}</textarea>

{/block}