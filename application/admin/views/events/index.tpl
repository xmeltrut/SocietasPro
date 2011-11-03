{extends file="standard.tpl"}

{block name=body}
<h2>{$lang_events}</h2>

<form action="" method="post">
	<table border="1">
		<tr>
			<th>&nbsp;</th>
			<th>{$lang_id}</th>
			<th>{$lang_name}</th>
			<th>{$lang_date}</th>
			<th>{$lang_edit}</th>
			<th>{$lang_delete}</th>
		</tr>
		{foreach $events as $event}
		<tr>
			<td><input type="checkbox" name="ids[]" value="{$event->getData("eventID")}" /></td>
			<td>{$event->getData("eventID")}</td>
			<td>{$event->getData("eventName")}</td>
			<td>{$event->getFormattedDate()}</td>
			<td><a href="{$root}admin/events/edit/{$event->getData("eventID")}">{$lang_edit}</a></td>
			<td>
				<input type="submit" name="delete_{$event->getData("eventID")}" value="{$lang_delete}" />
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
	<a href="{$root}admin/events/create">{$lang_create} {$lang_event|lower}</a>
</p>

<p>
	<a href="{$root}admin/locations">{$lang_manage} {$lang_locations|lower}</a>
</p>
{/block}