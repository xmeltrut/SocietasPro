{extends file="layout.tpl"}

{block name=body}
<h2>Blog</h2>

{foreach $posts as $post}
<h3><a href="{$root}public/blog/post/{$post->postSlug}">{$post->postName}</a></h3>
{$post->postContent}
{/foreach}
{/block}