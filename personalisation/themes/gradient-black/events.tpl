{extends file="layout.tpl"}

{block name=body}
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