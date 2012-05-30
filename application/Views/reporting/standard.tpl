{extends file="standard.tpl"}

{block name=head}
	{block name=innerhead}{/block}
{/block}

{block name=body}
	<ol class="submenu">
		<li {if $section == "index" or $section == "auditlogs"}class="active"{/if}><a href="{$root}admin/reporting/auditlogs">{$lang_audit_logs}</a></li>
		<li {if $section == "errorlogs"}class="active"{/if}><a href="{$root}admin/reporting/errorlogs">{$lang_error_logs}</a></li>
	</ol>
	
	{block name=innerbody}{/block}
{/block}