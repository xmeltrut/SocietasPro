{extends file="layout.tpl"}

{block name=body}
<h2>{$event->eventName}</h2>

<p>
	<em>{$event->getFormattedDate()}</em>
</p>

{$event->eventDescription}
{/block}