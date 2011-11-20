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
		<td><a href="{$root}admin/reporting/errorlogs?code={$log["logCode"]}">{$log["logCode"]}</a></td>
		<td>{$log["logURL"]|wordwrap:40:"<br />\n":true}</td>
		<td>{$log["logDetails"]|wordwrap:40:"<br />\n":true}</td>
		<td>{$log["logSQL"]|wordwrap:40:"<br />\n":true}</td>
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
					<a href="{$root}admin/reporting/errorlogs/{$i}">{$i}</a>
				{/if}
			{/for}
		</td>
	</tr>
	{/if}
</table>
{/block}