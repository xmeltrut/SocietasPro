{extends file="pages/standard.tpl"}

{block name=innerhead}
{include file="visualeditor.tpl"}

<script type="text/javascript">
$(document).ready(function(){
	$("#name").keyup(function(){
		$("#slug").val(generateSlug($("#name").val()));
	});
});
</script>
{/block}

{block name=innerbody}
<h2>{$lang_edit} {$lang_page}</h2>

{$form}
{/block}