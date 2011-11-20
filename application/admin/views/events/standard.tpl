{extends file="standard.tpl"}

{block name=head}
	{block name=innerhead}{/block}
{/block}

{block name=body}
	<ol class="submenu">
		<li {if $section == "index" or $section == "edit"}class="active"{/if}><a href="{$root}admin/events">{$lang_manage} {$lang_events}</a></li>
		<li {if $section == "create"}class="active"{/if}><a href="{$root}admin/events/create">{$lang_create} {$lang_event}</a></li>
		<li {if $section == "locations" or $section == "editlocation"}class="active"{/if}><a href="{$root}admin/events/locations">{$lang_manage} {$lang_locations}</a></li>
		<li {if $section == "createlocation"}class="active"{/if}><a href="{$root}admin/events/createlocation">{$lang_create} {$lang_location}</a></li>
	</ol>
	
	{block name=innerbody}{/block}
{/block}