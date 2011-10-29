{extends file="standard.tpl"}

{block name=body}
<h2>{$lang_locations}</h2>

<table border="1">
	<tr>
		<th>{$lang_id}</th>
		<th>{$lang_name}</th>
		<th>{$lang_edit}</th>
		<th>{$lang_delete}</th>
	</tr>
	{foreach $locations as $location}
	<tr>
		<td>{$location->getData("locationID")}</td>
		<td>{$location->getData("locationName")}</td>
		<td><a href="{$root}admin/events/edit/{$location->getData("locationID")}">{$lang_edit}</a></td>
		<td>
			<form action="" method="post" onSubmit="return areYouSure();">
				<input type="submit" value="{$lang_delete}" />
				<input type="hidden" name="action" value="delete" />
				<input type="hidden" name="id" value="{$location->getData("locationID")}" />
			</form>
		</td>
	</tr>
	{/foreach}
</table>

<p>
	<a href="{$root}admin/locations/create">{$lang_create} {$lang_location|lower}</a>
</p>
{/block}