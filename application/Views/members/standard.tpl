{extends file="standard.tpl"}

{block name=head}
	{block name=innerhead}{/block}
{/block}

{block name=body}
	<ol class="submenu">
		<li {if $section == "index" or $section == "edit"}class="active"{/if}><a href="{$root}admin/members">{$lang_manage} {$lang_members}</a></li>
		<li {if $section == "create"}class="active"{/if}><a href="{$root}admin/members/create">{$lang_create} {$lang_member}</a></li>
		<li {if $section == "import"}class="active"{/if}><a href="{$root}admin/members/import">{$lang_import} {$lang_members}</a></li>
		<li {if $section == "fields" or $section == "editfield"}class="active"{/if}><a href="{$root}admin/members/fields">{$lang_manage} {$lang_fields}</a></li>
		<li {if $section == "createfield"}class="active"{/if}><a href="{$root}admin/members/createfield">{$lang_create} {$lang_field}</a></li>
		<li {if $section == "groups" or $section == "editgroup"}class="active"{/if}><a href="{$root}admin/members/groups">{$lang_manage} {$lang_groups}</a></li>
		<li {if $section == "creategroup"}class="active"{/if}><a href="{$root}admin/members/creategroup">{$lang_create} {$lang_group}</a></li>
	</ol>
	
	{block name=innerbody}{/block}
{/block}