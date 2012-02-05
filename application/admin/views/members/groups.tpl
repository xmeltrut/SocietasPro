{extends file="members/standard.tpl"}

{block name=innerbody}


<h2>{$lang_members} {$lang_groups}</h2>

<form action="" method="post">
	<table border="1">
		<tr>
			<th>{$lang_id}</th>
			<th>{$lang_name}</th>
			<th>{$lang_edit}</th>
			<th>{$lang_delete}</th>
		</tr>
		{foreach $groups as $group}
		<tr>
			<td>{$group->groupID}</td>
			<td>{$group->groupName}</td>
			<td><a href="{$root}admin/members/editgroup/{$group->groupID}">{$lang_edit}</a></td>
			<td>
				<input type="submit" name="delete_{$group->groupID}" value="{$lang_delete}" onClick="return areYouSure();" />
			</td>
		</tr>
		{foreachelse}
		<tr>
			<td colspan="4">{$lang_no_records_found}</td>
		</tr>
		{/foreach}
	</table>
	<input type="hidden" name="action" value="mass" />
</form>
{/block}