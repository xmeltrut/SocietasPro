{extends file="standard.tpl"}

{block name=body}
<h2>{$lang_blog}</h2>

<form action="" method="post">
	<table border="1">
		<tr>
			<th>&nbsp;</th>
			<th>{$lang_id}</th>
			<th>{$lang_name}</th>
			<th>{$lang_date}</th>
			<th>{$lang_edit}</th>
			<th>{$lang_delete}</th>
		</tr>
		{foreach $posts as $post}
		<tr>
			<td><input type="checkbox" name="ids[]" value="{$post->postID}" /></td>
			<td>{$post->postID}</td>
			<td>{$post->postName}</td>
			<td>{$post->getFormattedDate()}</td>
			<td><a href="{$root}admin/blog/edit/{$post->postID}">{$lang_edit}</a></td>
			<td>
				<input type="submit" name="delete_{$post->postID}" value="{$lang_delete}" onClick="return areYouSure();" />
			</td>
		</tr>
		{foreachelse}
		<tr>
			<td colspan="6">{$lang_no_records_found}</td>
		</tr>
		{/foreach}
		{if $totalPages > 1}
		<tr>
			<td colspan="7">
				{$lang_page}: {for $i=1 to $totalPages}
				<a href="{$root}admin/blog/index/{$i}">{$i}</a>
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

<p>
	<a href="{$root}admin/blog/create">{$lang_create} {$lang_blog|lower} {$lang_post|lower}</a>
</p>
{/block}