{extends file="layout.tpl"}

{block name=head}
<link rel="alternate" type="application/rss+xml" title="Events" href="{$root}public/events/feed" />
{/block}

{block name=body}
<h1>Calendar</h1>

<div style="width: 33%; float: left; text-align: left;">&laquo; <a href="{$root}public/events/calendar/{$previousMonthLink}">{$previousMonthName}</a></div>
<div style="width: 34%; float: left; text-align: center; font-weight: bold;">{$currentMonthName}</div>
<div style="width: 33%; float: left; text-align: right;"><a href="{$root}public/events/calendar/{$nextMonthLink}">{$nextMonthName}</a> &raquo;</div>
<div class="spacer"></div><br /><br />

<table width="100%" cellpadding="3" cellspacing="1" border="1" class="tbl">
	<tr>
		<th>Monday</th>
		<th>Tuesday</th>
		<th>Wednesday</th>
		<th>Thursday</th>
		<th>Friday</th>
		<th>Sat</th>
		<th>Sun</th>
	</tr>
	{foreach from=$days key=key item=day}
	{if $day["position"] == -1}
	<tr valign="top">
	{/if}
		<td>
			{if $day["placeholder"]}
				&nbsp;
			{else}
				{$key}
				{foreach from=$day["events"] item=event}
					<p><a href="{$root}public/events/details/{$event->eventID}">{$event->eventName}</a></p>
				{/foreach}
			{/if}
		</td>
	{if $day["position"] == 1}
	</tr>
	{/if}
	{/foreach}
</table>
{/block}