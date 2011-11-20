{extends file="members/standard.tpl"}

{block name=innerbody}
<h2>{$lang_members}</h2>

<form action="" method="post">
	<table border="1">
		<tr>
			<th>&nbsp;</th>
			<th>{$lang_id}</th>
			<th>{$lang_email}</th>
			<th>{$lang_forename}</th>
			<th>{$lang_surname}</th>
			<th>{$lang_edit}</th>
			<th>{$lang_delete}</th>
		</tr>
		{foreach $members as $member}
		<tr>
			<td><input type="checkbox" name="ids[]" value="{$member->memberID}" /></td>
			<td>{$member->memberID}</td>
			<td>{$member->memberEmail}</td>
			<td>{$member->memberForename}</td>
			<td>{$member->memberSurname}</td>
			<td><a href="{$root}admin/members/edit/{$member->memberID}">{$lang_edit}</a></td>
			<td>
				<input type="submit" name="delete_{$member->memberID}" value="{$lang_delete}" onClick="return areYouSure();" />
			</td>
		</tr>
		{foreachelse}
		<tr>
			<td colspan="7">{$lang_no_records_found}</td>
		</tr>
		{/foreach}
		{if $totalPages > 1}
		<tr>
			<td colspan="7">
				{$lang_page}: {for $i=1 to $totalPages}
				<a href="{$root}admin/members/index/{$i}">{$i}</a>
				{/for}
			</td>
		</tr>
		{/if}
	</table>
	<select name="option">
		<option value="">{$lang_select_action}</option>
		<option value="delete">{$lang_delete}</option>
	</select>
	<input type="submit" value="{$lang_submit}" />
	<input type="hidden" name="action" value="mass" />
</form>

<p>
	<a href="{$root}admin/members/csv">{$lang_export_as_csv}</a>
</p>
{/block}