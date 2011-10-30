{extends file="standard.tpl"}

{block name=body}
<h2>{$lang_blog}</h2>

<table border="1">
	<tr>
		<th>{$lang_id}</th>
		<th>{$lang_name}</th>
		<th>{$lang_date}</th>
		<th>{$lang_edit}</th>
		<th>{$lang_delete}</th>
	</tr>
	{foreach $posts as $post}
	<tr>
		<td>{$post->getData("postID")}</td>
		<td>{$post->getData("postName")}</td>
		<td>{$post->getFormattedDate()}</td>
		<td><a href="{$root}admin/blog/edit/{$post->getData("postID")}">{$lang_edit}</a></td>
		<td>
			<form action="" method="post" onSubmit="return areYouSure();">
				<input type="submit" value="{$lang_delete}" />
				<input type="hidden" name="action" value="delete" />
				<input type="hidden" name="id" value="{$post->getData("postID")}" />
			</form>
		</td>
	</tr>
	{/foreach}
</table>

<p>
	<a href="{$root}admin/blog/create">{$lang_create} {$lang_blog|lower} {$lang_post|lower}</a>
</p>
{/block}