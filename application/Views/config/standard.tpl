{extends file="standard.tpl"}

{block name=head}
	{if isset($autoRefresh)}
	<meta http-equiv="refresh" content="3" />
	{/if}
	{block name=innerhead}{/block}
{/block}

{block name=body}
	<ol class="submenu">
		<li {if $section == "index"}class="active"{/if}><a href="{$root}admin/config">{$lang_configuration}</a></li>
		<li {if $section == "preferences"}class="active"{/if}><a href="{$root}admin/config/preferences">{$lang_preferences}</a></li>
		<li {if $section == "language"}class="active"{/if}><a href="{$root}admin/config/language">{$lang_language}</a></li>
		<li {if $section == "features"}class="active"{/if}><a href="{$root}admin/config/features">{$lang_features}</a></li>
	</ol>
	
	{block name=innerbody}{/block}
	
	{if isset($autoRefresh)}
	<div class="overlay">
		<div id="applyingChanges">
			<img src="application/Resources/images/loader2.gif" alt="Loading" /><br />
			{$lang_applying_changes}...
		</div>
	</div>
	{/if}
{/block}