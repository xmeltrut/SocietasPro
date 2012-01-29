{extends file="layout.tpl"}

{block name=body}
<h1>Blog</h1>

{foreach $posts as $post}
<h2><a href="{$root}public/blog/post/{$post->postSlug}">{$post->postName}</a></h2>
{$post->postContent}
{/foreach}
{/block}