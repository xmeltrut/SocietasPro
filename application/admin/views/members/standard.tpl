{extends file="standard.tpl"}

{block name=head}
	{block name=innerhead}{/block}
{/block}

{block name=body}
	<ol class="submenu">
		<li {if $section == "index"}class="active"{/if}><a href="{$root}admin/members">{$lang_manage} {$lang_members}</a></li>
		<li {if $section == "create"}class="active"{/if}><a href="{$root}admin/members/create">{$lang_create} {$lang_member}</a></li>
		<li {if $section == "import"}class="active"{/if}><a href="{$root}admin/members/import">{$lang_import} {$lang_members}</a></li>
		<li {if $section == "fields"}class="active"{/if}><a href="{$root}admin/members/fields">{$lang_manage} {$lang_fields}</a></li>
		<li {if $section == "createfield"}class="active"{/if}><a href="{$root}admin/members/createfield">{$lang_create} {$lang_field}</a></li>
	</ol>
	
	{block name=innerbody}{/block}
{/block}