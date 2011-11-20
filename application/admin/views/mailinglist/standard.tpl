{extends file="standard.tpl"}

{block name=head}
	{block name=innerhead}{/block}
{/block}

{block name=body}
	<ol class="submenu">
		<li><a href="{$root}admin/mailinglist">{$lang_manage} {$lang_mailing_list}</a></li>
		<li><a href="{$root}admin/mailinglist/generate">{$lang_view} {$lang_mailing_list}</a></li>
		<li><a href="{$root}admin/mailinglist/import">{$lang_import} {$lang_subscribers}</a></li>
	</ol>
	
	{block name=innerbody}{/block}
{/block}