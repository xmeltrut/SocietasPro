{extends file="layout.tpl"}

{block name=body}
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