{extends file="standard.tpl"}

{block name=head}
	{block name=innerhead}{/block}
{/block}

{block name=body}
	<ol class="submenu">
		<li {if $section == "index"}class="active"{/if}><a href="{$root}admin/config">{$lang_configuration}</a></li>
		<li {if $section == "language"}class="active"{/if}><a href="{$root}admin/config/language">{$lang_language}</a></li>
	</ol>
	
	{block name=innerbody}{/block}
{/block}