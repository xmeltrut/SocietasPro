{extends file="layout.tpl"}

{block name=body}
<p>
	Blog
</p>

{foreach $posts as $post}
<p>
	<a href="{$root}blog/{$post->postSlug}">{$post->postName}</a>
</p>
{$post->postContent}
{/foreach}
{/block}