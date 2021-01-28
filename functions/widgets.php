<?php


function load_widget() { // Register and load the widgets here
    register_widget( 'onepage_menu' ); 
     register_widget( 'ParentSidebar' ); 
     register_widget( 'SDGSidebar' ); 
     register_widget( 'PostTypeSidebar' ); 
}

add_action( 'widgets_init', 'load_widget' );

class onepage_menu extends WP_Widget {
    
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'blank', 
        
        // Widget name will appear in UI
        __('One Page Menu', 'boilerplate'), 
        
        // Widget description
            array( 'description' => __( 'no params required, set pages as children of the home page', 'boilerplate' ), ) 
        );
    }
    
    // Creating widget front-end
    
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        print home_children_menu();




        if ( ! empty( $title ) )
        
            echo $args['before_title'] . $title . $args['after_title'];
            
            // This is where you run the code and display the output
            echo __( '', 'boilerplate' );
            echo $args['after_widget'];
        }
                
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'boilerplate' );
        }
        // Widget admin form
        ?>
        <p>
        no params required, set pages as children of the home page
        </p>
        <!--
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>-->
        <?php 
    }
        
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
} // Class widget ends here



class ParentSidebar extends WP_Widget {
    
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'blank', 
        
        // Widget name will appear in UI
        __('Page SubNav', 'boilerplate'), 
        
        // Widget description
            array( 'description' => __( 'no params required, set pages as children of the home page', 'boilerplate' ), ) 
        );
    }
    
    // Creating widget front-end
    
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
            print parentSubnav();



        if ( ! empty( $title ) )
        
            echo $args['before_title'] . $title . $args['after_title'];
            
            // This is where you run the code and display the output
            echo __( '', 'boilerplate' );
            echo $args['after_widget'];
        }
                
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'boilerplate' );
        }
        // Widget admin form
        ?>
        <p>
        no params required, set pages as children of the home page
        </p>
        <!--
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>-->
        <?php 
    }
        
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
} // Class widget ends here



class PostTypeSidebar extends WP_Widget {
    
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'blank', 
        
        // Widget name will appear in UI
        __('Dynamic SubNav', 'boilerplate'), 
        
        // Widget description
            array( 'description' => __( 'no params required, set pages as children of the home page', 'boilerplate' ), ) 
        );
    }
    
    // Creating widget front-end
    
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
     
            print dynamicSubnav();



        if ( ! empty( $title ) )
        
            echo $args['before_title'] . $title . $args['after_title'];
            
            // This is where you run the code and display the output
            echo __( '', 'boilerplate' );
            echo $args['after_widget'];
        }
                
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'boilerplate' );
        }
        // Widget admin form
        ?>
        <p>
        no params required, set pages as children of the home page
        </p>
        <!--
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>-->
        <?php 
    }
        
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
} // Class widget ends here

class Register extends WP_Widget {
    
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'blank', 
        
        // Widget name will appear in UI
        __('Dynamic SubNav', 'boilerplate'), 
        
        // Widget description
            array( 'description' => __( 'no params required, set pages as children of the home page', 'boilerplate' ), ) 
        );
    }
    
    // Creating widget front-end
    
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
     
            registerButton();

        if ( ! empty( $title ) )
        
            echo $args['before_title'] . $title . $args['after_title'];
            
            // This is where you run the code and display the output
            echo __( '', 'boilerplate' );
            echo $args['after_widget'];
        }
                
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'boilerplate' );
        }
        // Widget admin form
        ?>
        <p>
        no params required, set pages as children of the home page
        </p>
        <!--
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>-->
        <?php 
    }
        
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
} // Class widget ends here

class SDGSidebar extends WP_Widget {
    
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'blank', 
        
        // Widget name will appear in UI
        __('SDG SubNav', 'boilerplate'), 
        
        // Widget description
            array( 'description' => __( 'no params required, set pages as children of the home page', 'boilerplate' ), ) 
        );
    }
    
    // Creating widget front-end
    
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
            print sdgSubnav();



        if ( ! empty( $title ) )
        
            echo $args['before_title'] . $title . $args['after_title'];
            
            // This is where you run the code and display the output
            echo __( '', 'boilerplate' );
            echo $args['after_widget'];
        }
                
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'boilerplate' );
        }
        // Widget admin form
        ?>
        <p>
        no params required, set pages as children of the home page
        </p>
        <!--
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>-->
        <?php 
    }
        
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
} // Class widget ends here










class PostSiblings extends WP_Widget {
    
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'blank', 
        
        // Widget name will appear in UI
        __('Page SubNav', 'boilerplate'), 
        
        // Widget description
            array( 'description' => __( 'no params required, set pages as children of the home page', 'boilerplate' ), ) 
        );
    }
    
    // Creating widget front-end
    
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
            print parentSubnav();



        if ( ! empty( $title ) )
        
            echo $args['before_title'] . $title . $args['after_title'];
            
            // This is where you run the code and display the output
            echo __( '', 'boilerplate' );
            echo $args['after_widget'];
        }
                
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'boilerplate' );
        }
        // Widget admin form
        ?>
        <p>
        no params required, set pages as children of the home page
        </p>
        <!--
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>-->
        <?php 
    }
        
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
} 


class ProfileSubnav extends WP_Widget {
    
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'blank', 
        
        // Widget name will appear in UI
        __('Profile SubNav', 'boilerplate'), 
        
        // Widget description
            array( 'description' => __( 'no params required, set pages as children of the home page', 'boilerplate' ), ) 
        );
    }
    
    // Creating widget front-end
    
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
            print profileSubnav();



        if ( ! empty( $title ) )
        
            echo $args['before_title'] . $title . $args['after_title'];
            
            // This is where you run the code and display the output
            echo __( '', 'boilerplate' );
            echo $args['after_widget'];
        }
                
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'boilerplate' );
        }
        // Widget admin form
        ?>
        <p>
        no params required, set pages as children of the home page
        </p>
        <!--
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>-->
        <?php 
    }
        
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
} // Class widget ends here


add_action( 'widgets_init', 'load_widget' );

// Class widget ends here


/*
        /////
        // BELOW IS THE BLANK WIDGET, KEEP IT A AT THE BOTTOM.


// Creating the widget 
class widget extends WP_Widget {
    
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'blank', 
        
        // Widget name will appear in UI
        __('Blank Widget Template', 'boilerplate'), 
        
        // Widget description
        array( 'description' => __( 'blank', 'boilerplate' ), ) 
        );
    }
    
    // Creating widget front-end
    
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
    if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];
        
        // This is where you run the code and display the output
        echo __( '', 'boilerplate' );
        echo $args['after_widget'];
    }
            
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'boilerplate' );
        }
        // Widget admin form
        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php 
    }
        
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
} // Class widget ends here

*/

?>