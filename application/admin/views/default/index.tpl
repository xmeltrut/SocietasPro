{extends file="standard.tpl"}

{block name=body}
<h2>{$lang_control_panel}</h2>

<table border="1">
	<tr>
		<th>{$lang_members}:</th>
		<td>{$total_members}</td>
	</tr>
	<tr>
		<th>{$lang_mailing_list}:</th>
		<td>{$total_subscribers}</td>
	</tr>
</table>
{/block}