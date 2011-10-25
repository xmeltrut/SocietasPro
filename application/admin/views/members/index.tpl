{extends file="standard.tpl"}

{block name=body}
<h2>Members List</h2>

<table border="1">
	<tr>
		<th>ID</th>
		<th>Email</th>
		<th>Name</th>
		<th>Surname</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
	{foreach $members as $member}
	<tr>
		<td>{$member->getData("memberID")}</td>
		<td>{$member->getData("memberEmail")}</td>
		<td>{$member->getData("memberForename")}</td>
		<td>{$member->getData("memberSurname")}</td>
		<td><a href="{$root}admin/members/edit/{$member->getData("memberID")}">Edit</a></td>
		<td>
			<form action="" method="post">
				<input type="submit" value="Delete" />
				<input type="hidden" name="action" value="delete" />
				<input type="hidden" name="id" value="{$member->getData("memberID")}" />
			</form>
		</td>
	</tr>
	{/foreach}
</table>

<p>
	<a href="{$root}admin/members/create">Create a new member</a>
</p>
{/block}