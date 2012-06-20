<aside>

	<h3>Search</h3>
	<form action="/" method="get">
		<input type="search" name="s" placeholder="Search" />
		<button type="submit">Search</button>
	</form>
	
	<h3>Archives</h3>
	<ul>
		<?php wp_get_archives('type=monthly'); ?>
	</ul>
	
	<h3>Categories</h3>
	<ul>
		<?php wp_list_categories('show_count=1&title_li='); ?>
	</ul>
	
	<h3>Bookmarks</h3>
	<ul>
		<?php wp_list_bookmarks('title_li=0&categorize=0'); // 'categorize=0' is a hack really, lets you use your own title as 'title_li=' isn't enough. ?>
	</ul>
	
</aside>