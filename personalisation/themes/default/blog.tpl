<p>
	Blog
</p>

{foreach $posts as $post}
<p>
	Hmm
	{$post->postTitle}
	{$post->getData("postTitle")}
</p>
{/foreach}