<?php 
    function video_meta( $meta_boxes ) {
        $prefix = '';

        $meta_boxes[] = array(
            'id' => 'featured_video',
            'title' => esc_html__( 'Featured Video', 'ps-video' ),
            'post_types' => array( 'page','post','project' ),
            'context' => 'side',
            'priority' => 'default',
            'autosave' => false,
            'fields' => array(
                array(
                    'id' => 'featured_video',
                    'type' => 'video',
                    'name' => esc_html__( 'Video', 'ps-video' ),
                    'max_file_uploads' => 4,
                ),
                array(
                    'id' => $prefix . 'featured_video_url',
                    'type' => 'url',
                    'name' => esc_html__( 'Featured Video URL', 'ps-video' ),
                ),
                array(
                    'id' => $prefix . 'video_aspect',
                    'name' => esc_html__( 'Video Aspect', 'ps-video' ),
                    'type' => 'select',
                    'placeholder' => esc_html__( 'Select an Item', 'ps-video' ),
                    'options' => array(
                        'hd' => '16:9',
                        'sd' => '4:3',
                    ),
                    'std' => 'hd',
                ),
            ),
        );

        return $meta_boxes;
    }
    add_filter( 'rwmb_meta_boxes', 'video_meta' );


    function social_meta( $meta_boxes ) {
        $prefix = '';

        $meta_boxes[] = array(
            'id' => 'social_url',
            'title' => esc_html__( 'Social', 'ps-social' ),
            'post_types' => array( 'social' ),
            'context' => 'side',
            'priority' => 'default',
            'autosave' => false,
            'fields' => array(
               
                array(
                    'id' => $prefix . 'social_url',
                    'type' => 'url',
                    'name' => esc_html__( 'URL', 'ps-social' ),
                ),
                
            ),
        );

        return $meta_boxes;
    }
    add_filter( 'rwmb_meta_boxes', 'social_meta' );



    function ps_metabox( $meta_boxes ) {
        $prefix = '';

        $meta_boxes[] = array(
            'id' => 'project_info',
            'title' => esc_html__( 'Project Info', 'ps_metabox' ),
            'post_types' => array( 'project' ),
            'context' => 'side',
            'priority' => 'default',
            'autosave' => false,
            'fields' => array(
                array(
                    'id' => $prefix . 'project_url',
                    'type' => 'url',
                    'name' => esc_html__( 'Project URL', 'ps_metabox' ),
                ),
                array(
                    'id' => $prefix . 'project_title',
                    'type' => 'text',
                    'name' => esc_html__( 'Project Title', 'ps_metabox' ),
                ),
                array(
                    'id' => $prefix . 'project_client',
                    'type' => 'text',
                    'name' => esc_html__( 'Client', 'ps_metabox' ),
                ),
                array(
                    'id' => $prefix . 'project_agency',
                    'type' => 'text',
                    'name' => esc_html__( 'Agency', 'ps_metabox' ),
                ),
                array(
                    'id' => $prefix . 'project_era',
                    'type' => 'text',
                    'name' => esc_html__( 'Era', 'ps_metabox' ),
                ),
            
            ),
        );

        return $meta_boxes;
    }
    add_filter( 'rwmb_meta_boxes', 'ps_metabox' );
            
function selectScreenImage( $meta_boxes ) {
	$prefix = '';

	$meta_boxes[] = array(
		'id' => 'screen_image',
		'title' => esc_html__( 'Screen Image', 'metabox-online-generator' ),
		'post_types' => array( 'post', 'page','project' ),
		'context' => 'side',
		'priority' => 'default',
		'autosave' => false,
		'fields' => array(
			array(
				'id' => 'screen_image',
				'type' => 'image_advanced',
				'name' => esc_html__( 'Screen Image', 'metabox-online-generator' ),
				'desc' => esc_html__( 'Appears in Screen', 'metabox-online-generator' ),
				'force_delete' => false,
				'max_file_uploads' => '10',
				'options' => array(),
				'attributes' => array(),
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'selectScreenImage' );


    
?>