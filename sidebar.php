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

</aside>