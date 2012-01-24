{extends file="layout.tpl"}

{block name=body}
<h1>{$event->eventName}</h1>

<p>
	<em>{$event->getFormattedDate()}</em>
</p>

{$event->eventDescription}
{/block}