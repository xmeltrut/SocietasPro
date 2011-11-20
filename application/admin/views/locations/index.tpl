{extends file="events/standard.tpl"}

{block name=innerbody}
<h2>{$lang_locations}</h2>

<form action="" method="post">
	<table border="1">
		<tr>
			<th>&nbsp;</th>
			<th>{$lang_id}</th>
			<th>{$lang_name}</th>
			<th>{$lang_edit}</th>
			<th>{$lang_delete}</th>
		</tr>
		{foreach $locations as $location}
		<tr>
			<td><input type="checkbox" name="ids[]" value="{$location->locationID}" /></td>
			<td>{$location->locationID}</td>
			<td>{$location->locationName}</td>
			<td><a href="{$root}admin/locations/edit/{$location->locationID}">{$lang_edit}</a></td>
			<td>
				<input type="submit" name="delete_{$location->locationID}" value="{$lang_delete}" onClick="return areYouSure();" />
			</td>
		</tr>
		{foreachelse}
		<tr>
			<td colspan="5">{$lang_no_records_found}</td>
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
{/block}