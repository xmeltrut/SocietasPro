{extends file="events/standard.tpl"}

{block name=innerbody}
<h2>{$lang_events}</h2>

<form action="" method="post">
	<table border="1">
		<tr>
			<th>&nbsp;</th>
			<th>{$lang_id}</th>
			<th>{$lang_name}</th>
			<th>{$lang_date}</th>
			<th>{$lang_edit}</th>
			<th>{$lang_options}</th>
		</tr>
		{foreach $events as $event}
		<tr>
			<td><input type="checkbox" name="ids[]" value="{$event->eventID}" /></td>
			<td>{$event->eventID}</td>
			<td>{$event->eventName}</td>
			<td>{$event->getFormattedDate()}</td>
			<td><a href="{$root}admin/events/edit/{$event->eventID}">{$lang_edit}</a></td>
			<td>
				<input type="submit" name="delete_{$event->eventID}" value="{$lang_delete}" onClick="return areYouSure();" />
				<input type="submit" name="clone_{$event->eventID}" value="{$lang_clone}" />
			</td>
		</tr>
		{foreachelse}
		<tr>
			<td colspan="6">{$lang_no_records_found}</td>
		</tr>
		{/foreach}
		{if $totalPages > 1}
		<tr>
			<td colspan="6" class="pagingRow">
				{$lang_page}: {for $i=1 to $totalPages}
					{if $i == $pageNum}
						{$i}
					{else}
						<a href="{$root}admin/events/index/{$i}">{$i}</a>
					{/if}
				{/for}
			</td>
		</tr>
		{/if}
	</table>
	<select name="option">
		<option value="">{$lang_select_action}</option>
		<option value="delete">{$lang_delete}</option>
	</select>
	<input type="submit" value="{$lang_submit}" />
	<input type="hidden" name="action" value="mass" />
</form>
{/block}