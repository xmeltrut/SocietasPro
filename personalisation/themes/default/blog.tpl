{extends file="layout.tpl"}

{block name=body}
<h2>Blog</h2>

{foreach $posts as $post}
<p>
	<a href="{$root}public/blog/post/{$post->postSlug}">{$post->postName}</a>
</p>
{$post->postContent}
{/foreach}
{/block}