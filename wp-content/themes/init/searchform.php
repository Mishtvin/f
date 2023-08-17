<form role="search" method="get" class="search-form input-wrapper" action="<?php echo home_url( '/' ); ?>">
	<input type="text" class="search-field" placeholder="<?php echo esc_attr_x( 'Поиск', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
	<button class="btn medium ghost"><span class="icon icon-search"></span></button>
</form>