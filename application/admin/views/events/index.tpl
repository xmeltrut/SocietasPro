{extends file="standard.tpl"}

{block name=body}
<h2>Events</h2>

<table border="1">
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Date</th>
		<th>Location</th>
		<th>Options</th>
	</tr>
	{foreach $events as $event}
	<tr>
		<td>{$event->getData("eventID")}</td>
		<td>{$event->getData("eventName")}</td>
		<td>{$event->getData("eventDate")}</td>
		<td>{$event->getData("eventLocation")}</td>
		<td><a href="{$root}admin/events/edit/{$event->getData("eventID")}">Edit</a></td>
	</tr>
	{/foreach}
</table>

<p>
	<a href="{$root}admin/events/create">Create a new event</a>
</p>
{/block}