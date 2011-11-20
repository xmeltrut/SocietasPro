{extends file="standard.tpl"}

{block name=body}
<h2>{$lang_audit_logs}</h2>

<form action="" method="get">
	<select name="action">
		<option value="">{$lang_any} {$lang_action|lower}</option>
		{foreach from=$actions key=key item=value}
		<option value="{$key}" {if $key==$actionID}selected="selected"{/if}>{eval var=$value}</option>
		{/foreach}
	</select>
	<select name="member">
		<option value="">{$lang_any} {$lang_member|lower}</option>
		{foreach from=$members key=key item=value}
		<option value="{$key}" {if $key==$memberID}selected="selected"{/if}>{$value}</option>
		{/foreach}
	</select>
	<input type="submit" value="{$lang_submit}" />
</form><br />

<table border="1">
	<tr>
		<th>{$lang_date}</th>
		<th>{$lang_action}</th>
		<th>{$lang_member}</th>
		<th>{$lang_old}</th>
		<th>{$lang_new}</th>
	</tr>
	{foreach $logs as $log}
	<tr>
		<td>{$log["entryDate"]}</td>
		<td>{eval var=$log["actionLocalised"]}</td>
		<td>{$log["entryMember"]}</td>
		<td>{$log["entryOldData"]|wordwrap:40:"<br />\n":true}</td>
		<td>{$log["entryNewData"]|wordwrap:40:"<br />\n":true}</td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="5">{$lang_no_records_found}</td>
	</tr>
	{/foreach}
	{if $totalPages > 1}
	<tr>
		<td colspan="5" class="pagingRow">
			{$lang_page}: {for $i=1 to $totalPages}
				{if $i == $pageNum}
					{$i}
				{else}
					<a href="{$root}admin/reporting/auditlogs/{$i}">{$i}</a>
				{/if}
			{/for}
		</td>
	</tr>
	{/if}
</table>
{/block}