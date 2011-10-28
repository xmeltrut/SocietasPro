{extends file="standard.tpl"}

{block name=body}
<h2>{$lang_members}</h2>

<table border="1">
	<tr>
		<th>{$lang_id}</th>
		<th>{$lang_email}</th>
		<th>{$lang_forename}</th>
		<th>{$lang_surname}</th>
		<th>{$lang_edit}</th>
		<th>{$lang_delete}</th>
	</tr>
	{foreach $members as $member}
	<tr>
		<td>{$member->getData("memberID")}</td>
		<td>{$member->getData("memberEmail")}</td>
		<td>{$member->getData("memberForename")}</td>
		<td>{$member->getData("memberSurname")}</td>
		<td><a href="{$root}admin/members/edit/{$member->getData("memberID")}">{$lang_edit}</a></td>
		<td>
			<form action="" method="post" onSubmit="return areYouSure();">
				<input type="submit" value="{$lang_delete}" />
				<input type="hidden" name="action" value="delete" />
				<input type="hidden" name="id" value="{$member->getData("memberID")}" />
			</form>
		</td>
	</tr>
	{/foreach}
</table>

<p>
	<a href="{$root}admin/members/create">{$lang_create} {$lang_member|lower}</a>
</p>
{/block}