{extends file="layout.tpl"}

{block name=head}
<link rel="alternate" type="application/rss+xml" title="Events" href="{$root}public/events/feed" />
{/block}

{block name=body}
<a href="{$root}public/events/feed" class="floatright"><img src="{$root}public/resources/images/feedicon.png" alt="RSS Feed" /></a>

<div>
	<h2 class="pagetitle">Events</h2>
	<div class="entry">&nbsp;</div>
</div>

<div class="post">
	{foreach $events as $event}
	<h2 class="title"><a href="{$root}public/events/details/{$event->eventID}">{$event->eventName}</a></h2>
	<p class="meta">
		{$event->getFormattedDate()}
	</p>
	<div class="entry">
		{$event->eventDescription}
	</div>
	{/foreach}
</div>
{/block}