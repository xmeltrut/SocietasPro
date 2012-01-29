{extends file="layout.tpl"}

{block name=body}
<div class="post">
	<h2 class="title">{$page->pageName}</h2>
	<div class="entry">
		{$page->pageContent}
	</div>
</div>
{/block}