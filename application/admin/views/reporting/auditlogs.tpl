{extends file="standard.tpl"}

{block name=body}
<h2>{$lang_audit_logs}</h2>

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
		<td>{$log["entryAction"]}</td>
		<td>{$log["entryMember"]}</td>
		<td>{$log["entryOldData"]}</td>
		<td>{$log["entryNewData"]}</td>
	</tr>
	{/foreach}
	{if $totalPages > 1}
	<tr>
		<td colspan="5">
			{$lang_page}: {for $i=1 to $totalPages}
			<a href="{$root}admin/reporting/auditlogs/{$i}">{$i}</a>
			{/for}
		</td>
	</tr>
	{/if}
</table>
{/block}