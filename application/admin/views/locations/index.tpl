{extends file="standard.tpl"}

{block name=body}
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
			<td><input type="checkbox" name="ids[]" value="{$location->getData("locationID")}" /></td>
			<td>{$location->getData("locationID")}</td>
			<td>{$location->getData("locationName")}</td>
			<td><a href="{$root}admin/locations/edit/{$location->getData("locationID")}">{$lang_edit}</a></td>
			<td>
				<input type="submit" name="delete_{$location->getData("locationID")}" value="{$lang_delete}" onClick="return areYouSure();" />
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
	<a href="{$root}admin/locations/create">{$lang_create} {$lang_location|lower}</a>
</p>
{/block}