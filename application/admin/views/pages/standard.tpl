{extends file="standard.tpl"}

{block name=head}
	{block name=innerhead}{/block}
{/block}

{block name=body}
	<ol class="submenu">
		<li {if $section == "index"}class="active"{/if}><a href="{$root}admin/pages">{$lang_manage} {$lang_pages}</a></li>
		<li {if $section == "create"}class="active"{/if}><a href="{$root}admin/pages/create">{$lang_create} {$lang_page}</a></li>
	</ol>
	
	{block name=innerbody}{/block}
{/block}