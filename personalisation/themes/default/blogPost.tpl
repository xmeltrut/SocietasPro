{extends file="layout.tpl"}

{block name=body}
<h2>{$post->postName}</h2>

{$post->postContent}
{/block}