{extends file="standard.tpl"}

{block name=head}
	{block name=innerhead}{/block}
{/block}

{block name=body}
	<ol class="submenu">
		<li {if $section == "index" or $section == "edit"}class="active"{/if}><a href="{$root}admin/blog">{$lang_manage} {$lang_blog}</a></li>
		<li {if $section == "create"}class="active"{/if}><a href="{$root}admin/blog/create">{$lang_create} {$lang_blog} {$lang_post}</a></li>
	</ol>
	
	{block name=innerbody}{/block}
{/block}