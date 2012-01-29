{extends file="layout.tpl"}

{block name=body}
<h1>Events</h1>

{foreach $events as $event}
<h3><a href="{$root}public/events/details/{$event->eventID}">{$event->eventName}</a></h3>
<p>
	<em>{$event->getFormattedDate()}</em>
</p>
{$event->eventDescription}
<p>&nbsp;</p>
{/foreach}
{/block}