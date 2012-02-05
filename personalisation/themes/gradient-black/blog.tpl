{extends file="layout.tpl"}

{block name=head}
<link rel="alternate" type="application/rss+xml" title="Blog" href="{$root}public/blog/feed" />
{/block}

{block name=body}
<a href="{$root}public/blog/feed" class="floatright"><img src="{$root}public/resources/images/feedicon.png" alt="RSS Feed" /></a>

<div>
	<h2 class="pagetitle">Blog</h2>
	<div class="entry">&nbsp;</div>
</div>

<div class="post">
	{foreach $posts as $post}
	<h2 class="title"><a href="{$root}public/blog/post/{$post->postSlug}">{$post->postName}</a></h2>
	<div class="entry">
		{$post->postContent}
	</div>
	{/foreach}
</div>
{/block}