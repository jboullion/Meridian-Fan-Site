<form class="search-wrapper" role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<button type="submit"><i class="fa fa-search"></i></button>
    <input type="text" name="s" id="s" placeholder="Search" value="<?php echo (! empty($_GET['s'])&&! isset($_GET['post_type'])? $_GET['s']:'')?>" maxlength="30">
    
</form>