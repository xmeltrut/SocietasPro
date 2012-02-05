{extends file="layout.tpl"}

{block name=head}
<link rel="alternate" type="application/rss+xml" title="Events" href="{$root}public/events/feed" />
{/block}

{block name=body}
<a href="{$root}public/events/feed" class="floatright"><img src="{$root}public/resources/images/feedicon.png" alt="RSS Feed" /></a>

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