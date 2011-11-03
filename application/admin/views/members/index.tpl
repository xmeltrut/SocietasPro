{extends file="standard.tpl"}

{block name=body}
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
			<td><input type="checkbox" name="ids[]" value="{$member->getData("memberID")}" /></td>
			<td>{$member->getData("memberID")}</td>
			<td>{$member->getData("memberEmail")}</td>
			<td>{$member->getData("memberForename")}</td>
			<td>{$member->getData("memberSurname")}</td>
			<td><a href="{$root}admin/members/edit/{$member->getData("memberID")}">{$lang_edit}</a></td>
			<td>
				<input type="submit" name="delete_{$member->getData("memberID")}" value="{$lang_delete}" onClick="return areYouSure();" />
			</td>
		</tr>
		{/foreach}
	</table>
	<select name="option">
		<option value="">{$lang_select_action}</option>
		<option value="delete">{$lang_delete}</option>
	</select>
	<input type="submit" value="{$lang_submit}" />
	<input type="hidden" name="action" value="mass" />
</form>

<p>
	<a href="{$root}admin/members/create">{$lang_create} {$lang_member|lower}</a>
</p>

<p>
	<a href="{$root}admin/members/import">{$lang_import} {$lang_members|lower}</a>
</p>

<p>
	<a href="{$root}admin/members/csv">{$lang_export_as_csv}</a>
</p>
{/block}