{extends file="standard.tpl"}

{block name=head}
<script type="text/javascript">
function loadTweets () {
	$.getJSON("{$root}admin/default/tweets", function (data) {
		$.each (data, function (key, val) {
			$("#tweets").append(val);
		});
	});
}
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

<div id="tweets">
</div>
{/block}