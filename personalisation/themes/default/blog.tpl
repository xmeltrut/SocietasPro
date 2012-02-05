{extends file="layout.tpl"}

{block name=head}
<link rel="alternate" type="application/rss+xml" title="Blog" href="{$root}public/blog/feed" />
{/block}

{block name=body}
<a href="{$root}public/blog/feed" class="floatright"><img src="{$root}public/resources/images/feedicon.png" alt="RSS Feed" /></a>

<h1>Blog</h1>

{foreach $posts as $post}
<h2><a href="{$root}public/blog/post/{$post->postSlug}">{$post->postName}</a></h2>
{$post->postContent}
{/foreach}
{/block}