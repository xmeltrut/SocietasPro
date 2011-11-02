{extends file="layout.tpl"}

{block name=body}
<p>
	Events
</p>

{foreach $events as $event}
<p>
	<a href="{$root}events/{$event->eventID}">{$event->eventName}</a>
</p>
{$event->eventDescription}
{/foreach}
{/block}