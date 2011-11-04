{foreach $tweets as $tweet}
<p>
	<img src="{$tweet->userProfileImage}" alt="" align="left" />
	{$tweet->text}
</p>
<p>
	{$tweet->longDate}
</p>
{/foreach}