{extends file="layout.tpl"}

{block name=head}
<link rel="alternate" type="application/rss+xml" title="Events" href="{$root}public/events/feed" />
{/block}

{block name=body}
<div class="post">
	<h2 class="title">{$event->eventName}</h2>
	<p class="meta">
		{$event->getFormattedDate()}
	</p>
	<div class="entry">
		{$event->eventDescription}
	</div>
</div>
{/block}