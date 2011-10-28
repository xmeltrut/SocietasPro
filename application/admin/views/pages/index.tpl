{extends file="standard.tpl"}

{block name=body}
<h2>{$lang_pages}</h2>

<table border="1">
	<tr>
		<th>{$lang_id}</th>
		<th>{$lang_name}</th>
		<th>{$lang_edit}</th>
		<th>{$lang_delete}</th>
	</tr>
	{foreach $pages as $page}
	<tr>
		<td>{$page->getData("pageID")}</td>
		<td>{$page->getData("pageName")}</td>
		<td><a href="{$root}admin/pages/edit/{$page->getData("pageID")}">{$lang_edit}</a></td>
		<td>
			<form action="" method="post" onSubmit="return areYouSure();">
				<input type="submit" value="{$lang_delete}" />
				<input type="hidden" name="action" value="delete" />
				<input type="hidden" name="id" value="{$page->getData("pageID")}" />
			</form>
		</td>
	</tr>
	{/foreach}
</table>

<p>
	<a href="{$root}admin/pages/create">{$lang_create} {$lang_page|lower}</a>
</p>
{/block}