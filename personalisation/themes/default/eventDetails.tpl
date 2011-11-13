{extends file="layout.tpl"}

{block name=body}
<h2>{$event->eventName}</h2>

<p>
	{$event->getFormattedDate()}
</p>

{$event->eventDescription}
{/block}