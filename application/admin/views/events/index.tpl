{extends file="standard.tpl"}

{block name=body}
<h2>{$lang_events}</h2>

<table border="1">
	<tr>
		<th>{$lang_id}</th>
		<th>{$lang_name}</th>
		<th>{$lang_date}</th>
		<th>{$lang_edit}</th>
		<th>{$lang_delete}</th>
	</tr>
	{foreach $events as $event}
	<tr>
		<td>{$event->getData("eventID")}</td>
		<td>{$event->getData("eventName")}</td>
		<td>{$event->getFormattedDate()}</td>
		<td><a href="{$root}admin/events/edit/{$event->getData("eventID")}">{$lang_edit}</a></td>
		<td>
			<form action="" method="post" onSubmit="return areYouSure();">
				<input type="submit" value="{$lang_delete}" />
				<input type="hidden" name="action" value="delete" />
				<input type="hidden" name="id" value="{$event->getData("eventID")}" />
			</form>
		</td>
	</tr>
	{/foreach}
</table>

<p>
	<a href="{$root}admin/events/create">{$lang_create} {$lang_event|lower}</a>
</p>

<p>
	<a href="{$root}admin/locations">{$lang_manage} {$lang_locations|lower}</a>
</p>
{/block}