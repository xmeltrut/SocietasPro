{extends file="members/standard.tpl"}

{block name=innerbody}


<h2>{$lang_members} {$lang_fields}</h2>

<form action="" method="post">
	<table border="1">
		<tr>
			<th>{$lang_id}</th>
			<th>{$lang_name}</th>
			<th>{$lang_type}</th>
			<th>{$lang_edit}</th>
			<th>{$lang_delete}</th>
		</tr>
		{foreach $fields as $field}
		<tr>
			<td>{$field->fieldID}</td>
			<td>{$field->fieldName}</td>
			<td>{$field->fieldType|capitalize}</td>
			<td><a href="{$root}admin/members/editfield/{$field->fieldID}">{$lang_edit}</a></td>
			<td>
				<input type="submit" name="delete_{$field->fieldID}" value="{$lang_delete}" onClick="return areYouSure();" />
			</td>
		</tr>
		{foreachelse}
		<tr>
			<td colspan="7">{$lang_no_records_found}</td>
		</tr>
		{/foreach}
	</table>
	<input type="hidden" name="action" value="mass" />
</form>
{/block}