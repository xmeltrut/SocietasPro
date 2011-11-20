{extends file="standard.tpl"}

{block name=body}
<h2>{$lang_error_logs}</h2>

<table border="1">
	<tr>
		<th>{$lang_date}</th>
		<th>{$lang_code}</th>
		<th>{$lang_url}</th>
		<th>{$lang_details}</th>
		<th>&nbsp;</th>
	</tr>
	{foreach $logs as $log}
	<tr>
		<td>{$log["logDate"]}</td>
		<td>{$log["logCode"]}</td>
		<td>{$log["logURL"]}</td>
		<td>{$log["logDetails"]}</td>
		<td>{$log["logSQL"]}</td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="5">{$lang_no_records_found}</td>
	</tr>
	{/foreach}
	{if $totalPages > 1}
	<tr>
		<td colspan="5">
			{$lang_page}: {for $i=1 to $totalPages}
				{if $i == $pageNum}
					{$i}
				{else}
					<a href="{$root}admin/reporting/errorlogs/{$i}">{$i}</a>
				{/if}
			{/for}
		</td>
	</tr>
	{/if}
</table>
{/block}