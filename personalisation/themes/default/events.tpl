{extends file="layout.tpl"}

{block name=body}
<h2>Events</h2>

{foreach $events as $event}
<p>
	<a href="{$root}public/events/details/{$event->eventID}">{$event->eventName}</a>
</p>
{$event->eventDescription}
{/foreach}
{/block}