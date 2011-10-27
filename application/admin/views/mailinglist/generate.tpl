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
<h2>{$lang_mailing_list}</h2>

<textarea class="subscriberList">{$subscribers}</textarea>

{/block}