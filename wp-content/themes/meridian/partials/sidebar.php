<div class="col-md-3 sidebar mobile-hide">
    <?php /*
    <div id="user-display">
        <?php if ( is_active_sidebar( 'home_right_1' ) ) : ?>
            <div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
                <?php dynamic_sidebar( 'home_right_1' ); ?>
            </div><!-- #primary-sidebar -->
        <?php endif; ?>
    </div>*/?>
    <?php
    /*
<div id="user-display">

    global $current_user;
    get_currentuserinfo();
    //m59_print($current_user);

    if(! empty($current_user)) {
        echo get_avatar($current_user->ID, 64);
        echo $current_user->user_nicename;
    }else{
        do_action( 'wordpress_social_login' );
    }

    </div>
    */
    ?>
    <div id="desktop-menu">
        <?php
        wp_nav_menu(array('container'=> false, 'depth'=>2, 'menu'=>'main', 'menu_class'=>'', 'menu-id'=>''));
        ?>
    </div>
</div>