<aside>
	
	<h2>Archives</h2>
	<ul>
		<?php wp_get_archives('type=monthly'); ?>
	</ul>
	
	<h2>Categories</h2>
	<ul>
		<?php wp_list_categories('show_count=1&title_li='); ?>
	</ul>
	
	<h2>Bookmarks</h2>
	<ul>
		<?php wp_list_bookmarks('title_li=0&categorize=0'); // 'categorize=0' is a hack really, lets you use your own title as 'title_li=' isn't enough. ?>
	</ul>
	
</aside>