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
	{/foreach}
</table>
{/block}