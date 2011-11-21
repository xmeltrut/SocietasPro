{extends file="layout.tpl"}

{block name=body}
<h2>Events</h2>

{foreach $events as $event}
<h3><a href="{$root}public/events/details/{$event->eventID}">{$event->eventName}</a></h3>
<p>
	<em>{$event->getFormattedDate()}</em>
</p>
{$event->eventDescription}
{/foreach}
{/block}