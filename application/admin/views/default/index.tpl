{extends file="standard.tpl"}

{block name=head}
<script type="text/javascript">
function loadTweets () {
	$.get("{$root}admin/default/tweets", function (data) {
		$("#tweets").html(data);
	});
}

$(document).ready( function () {
	loadTweets();
});
</script>
{/block}

{block name=body}
<h2>{$lang_control_panel}</h2>

<table border="1">
	<tr>
		<th>{$lang_members}:</th>
		<td>{$total_members}</td>
	</tr>
	<tr>
		<th>{$lang_mailing_list}:</th>
		<td>{$total_subscribers}</td>
	</tr>
</table>

<p>
	<strong>Twitter</strong>
</p>
<div id="tweets">
	<p>
		<img src="{$root}images/admin/loader1.gif" alt="" />
	</p>
</div>
{/block}