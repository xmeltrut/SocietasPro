{extends file="standard.tpl"}

{block name=body}
<h2>{$lang_mailing_list}</h2>

<table border="1">
	<tr>
		<th>{$lang_id}</th>
		<th>{$lang_email}</th>
		<th>{$lang_date}</th>
		<th>{$lang_delete}</th>
	</tr>
	{foreach $recent as $subscriber}
	<tr>
		<td>{$subscriber->getData("subscriberID")}</td>
		<td>{$subscriber->getData("subscriberEmail")}</td>
		<td>{$subscriber->getFormattedDate()}</td>
		<td>
			<form action="" method="post">
				<input type="submit" value="{$lang_delete}" />
				<input type="hidden" name="action" value="delete" />
				<input type="hidden" name="id" value="{$subscriber->getData("subscriberID")}" />
			</form>
		</td>
	</tr>
	{/foreach}
</table>

<p>
	<a href="{$root}admin/mailinglist/generate">{$lang_view} {$lang_mailing_list|lower}</a>
</p>
<p>
	<a href="{$root}admin/mailinglist/import">{$lang_import} {$lang_subscribers|lower}</a>
</p>
<p>
	<a href="{$root}admin/mailinglist/csv">{$lang_export_as_csv}</a>
</p>

<h3>{$lang_create} {$lang_subscriber}</h3>
<p>
	<form action="" method="post">
		<input type="text" name="email" />
		<input type="hidden" name="action" value="create" />
		<input type="submit" />
	</form>
</p>

<h3>{$lang_delete} {$lang_subscriber}</h3>
<p>
	<form action="" method="post">
		<input type="text" name="email" />
		<input type="hidden" name="action" value="deleteByEmail" />
		<input type="submit" />
	</form>
</p>

{/block}