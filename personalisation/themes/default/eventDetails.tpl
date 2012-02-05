{extends file="layout.tpl"}

{block name=head}
<link rel="alternate" type="application/rss+xml" title="Events" href="{$root}public/events/feed" />
{/block}

{block name=body}
<h1>{$event->eventName}</h1>

<p>
	<em>{$event->getFormattedDate()}</em>
</p>

{$event->eventDescription}
{/block}