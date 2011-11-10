{extends file="standard.tpl"}

{block name=body}
<h2>{$lang_pages}</h2>

<form action="" method="post">
	<table border="1">
		<tr>
			<th>&nbsp;</th>
			<th>{$lang_id}</th>
			<th>{$lang_name}</th>
			<th>{$lang_edit}</th>
			<th>{$lang_delete}</th>
		</tr>
		{foreach $pages as $page}
		<tr>
			<td><input type="checkbox" name="ids[]" value="{$page->getData("pageID")}" /></td>
			<td>{$page->getData("pageID")}</td>
			<td>{$page->getData("pageName")}</td>
			<td><a href="{$root}admin/pages/edit/{$page->getData("pageID")}">{$lang_edit}</a></td>
			<td>
				<input type="submit" name="delete_{$page->getData("pageID")}" value="{$lang_delete}" onClick="return areYouSure();" />
				<input type="submit" name="clone_{$page->getData("pageID")}" value="{$lang_clone}" />
				{if $page->canMoveUp()}<input type="submit" name="up_{$page->getData("pageID")}" value="{$lang_move_up}" />{/if}
				{if $page->canMoveDown()}<input type="submit" name="down_{$page->getData("pageID")}" value="{$lang_move_down}" />{/if}
			</td>
		</tr>
		{foreachelse}
		<tr>
			<td colspan="6">{$lang_no_records_found}</td>
		</tr>
		{/foreach}
	</table>
	<select name="option">
		<option value="">{$lang_select_action}</option>
		<option value="delete">{$lang_delete}</option>
	</select>
	<input type="submit" value="{$lang_submit}" />
	<input type="hidden" name="action" value="mass" />
</form>

<p>
	<a href="{$root}admin/pages/create">{$lang_create} {$lang_page|lower}</a>
</p>
{/block}