{extends file="layout.tpl"}

{block name=head}
<link rel="alternate" type="application/rss+xml" title="Blog" href="{$root}public/blog/feed" />
{/block}

{block name=body}
<h1>{$post->postName}</h1>

{$post->postContent}
{/block}