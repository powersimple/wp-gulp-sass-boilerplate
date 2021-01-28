<?php
    add_action( 'widgets_init', 'theme_slug_widgets_init' );
    function theme_slug_widgets_init() {

        register_sidebar( array(
            'name' => __( 'Header Logo', 'boilerplate' ),
            'id' => 'header-logo',
            'description' => __( 'Header Logo', 'boilerplate' ),
            'before_widget' => '',
            'before_title'  => '',
        ) );
         register_sidebar( array(
            'name' => __( 'Header Menu', 'boilerplate' ),
            'id' => 'header-menu',
            'description' => __( '', 'boilerplate' ),
            'before_widget' => '',
            'before_title'  => '',
        ) );
      register_sidebar( array(
            'name' => __( 'Page Sidebar', 'boilerplate' ),
            'id' => 'page-sidebar',
            'description' => __( '', 'boilerplate' ),
            'before_widget' => '',
            'before_title'  => '',
        ) );
         register_sidebar( array(
            'name' => __( 'Post Sidebar', 'boilerplate' ),
            'id' => 'post-sidebar',
            'description' => __( '', 'boilerplate' ),
            'before_widget' => '',
            'before_title'  => '',
        ) );

        register_sidebar( array(
            'name' => __( 'Footer 1', 'boilerplate' ),
            'id' => 'footer-1',
            'description' => __( 'footer 1', 'boilerplate' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5 class="widget-title font-alt">',
            'after_title'   => '</h5>',
        ) );
   
   
        register_sidebar( array(
            'name' => __( 'Footer 2', 'boilerplate' ),
            'id' => 'footer-2',
            'description' => __( 'footer 2', 'boilerplate' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widget-title font-alt">',
        'after_title'   => '</h5>',
        ) );
    
        register_sidebar( array(
            'name' => __( 'Footer 3', 'boilerplate' ),
            'id' => 'footer-3',
            'description' => __( 'footer 3', 'boilerplate' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widget-title font-alt">',
        'after_title'   => '</h5>',
        ) );
   
        register_sidebar( array(
            'name' => __( 'Footer 4', 'boilerplate' ),
            'id' => 'footer-4',
            'description' => __( 'footer 4', 'boilerplate' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widget-title font-alt">',
        'after_title'   => '</h5>',
        ) );
        register_sidebar( array(
            'name' => __( 'Category Subnav', 'boilerplate' ),
            'id' => 'cat_subnav',
            'description' => __( '', 'boilerplate' ),
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '',
            'after_title'   => '',
        ) );
        register_sidebar( array(
            'name' => __( 'SDG Subnav', 'boilerplate' ),
            'id' => 'sdg_subnav',
            'description' => __( '', 'boilerplate' ),
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '',
            'after_title'   => '',
        ) );
        register_sidebar( array(
            'name' => __( 'Register', 'boilerplate' ),
            'id' => 'register',
            'description' => __( '', 'boilerplate' ),
            'before_widget' => '<div id="register-button">',
            'after_widget'  => '</div>',
            'before_title'  => '',
            'after_title'   => '',
        ) );
        
    }
    function get_dynamic_sidebar($i = 1) {
    $c = '';
    ob_start();
    dynamic_sidebar($i);
    $c = ob_get_clean();
    return $c;
    }
?>