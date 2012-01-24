{extends file="layout.tpl"}

{block name=body}
<h1>{$post->postName}</h1>

{$post->postContent}
{/block}