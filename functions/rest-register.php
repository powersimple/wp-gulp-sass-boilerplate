<?php
add_action( 'init', 'socials_to_cpt' );
function socials_to_cpt() {
    $args = array(
      'public'       => true,
      'show_in_rest' => true,
      'label'        => 'social'
    );
    register_post_type( 'social', $args );
}


/*WP REST API CUSTOM ENDPOINTS. RETURNS SPECIFIC THUMBNAIL URL*/ 



/*

	CATEGORIES

*/

add_action( 'rest_api_init', 'register_posts_by_category' );
 
function register_posts_by_category() {
 
	register_rest_field( 'category', 'posts', array(
		'get_callback' => 'get_posts_by_category',
		'schema' => null,
		)
	);
}



 

add_action( 'rest_api_init', 'register_category_children' );
 
function register_category_children() {
	//this registers the children field
	register_rest_field( 'category', 'children', array(
		'get_callback' => 'get_cat_children',
		'schema' => null,
		)
	);
}
function get_cat_children( $object ) {// this returns the child categories to the rest API

	$categories=get_categories(
		array( 'parent' => $object['id'],//sends category parent
		'fields' => 'ids'//returns only the id fields
		)
	);
	
		
	return $categories; 
}




function get_posts_by_category( $object ) {

	$args = array(
    'post_type'      => array('post','page','profile','resource'), // where post types are represented
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'fields' => 'ids',
    'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $object['id']
			)
		)
	);
	
		
	return get_posts($args); 
}


/*resource_type*/


function get_posts_by_gradelevel( $object ) {

	$args = array(
    'post_type'      => array('post','page','profile','resource'), // where post types are represented
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'fields' => 'ids',
    'tax_query' => array(
			array(
				'taxonomy' => 'gradelevel',
				'field'    => 'term_id',
				'terms'    => $object['id']
			)
		)
	);
	
		
	return get_posts($args); 
}


add_action( 'rest_api_init', 'register_posts_by_gradelevel' );
 
function register_posts_by_gradelevel() {
 
	register_rest_field( 'gradelevel', 'posts', array(
		'get_callback' => 'get_posts_by_gradelevel',
		'schema' => null,
		)
	);
}

/*resource_type*/


function get_posts_by_resource_type( $object ) {

	$args = array(
    'post_type'      => array('post','page','profile','resource'), // where post types are represented
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'fields' => 'ids',
    'tax_query' => array(
			array(
				'taxonomy' => 'resource_type',
				'field'    => 'term_id',
				'terms'    => $object['id']
			)
		)
	);
	
		
	return get_posts($args); 
}


add_action( 'rest_api_init', 'register_posts_by_resource_type' );
 
function register_posts_by_resource_type() {
 
	register_rest_field( 'resource_type', 'posts', array(
		'get_callback' => 'get_posts_by_resource_type',
		'schema' => null,
		)
	);
}

/*COUNTRIES*/


function get_posts_by_country( $object ) {

	$args = array(
    'post_type'      => array('post','page','profile','resource'), // where post types are represented
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'fields' => 'ids',
    'tax_query' => array(
			array(
				'taxonomy' => 'countries',
				'field'    => 'term_id',
				'terms'    => $object['id']
			)
		)
	);
	
		
	return get_posts($args); 
}


add_action( 'rest_api_init', 'register_posts_by_country' );
 
function register_posts_by_country() {
 
	register_rest_field( 'countries', 'posts', array(
		'get_callback' => 'get_posts_by_country',
		'schema' => null,
		)
	);
}






/*
	CUSTOM MENU ROUTING
*/

function get_menu() {
    # Change 'menu' to your own navigation slug.
    return wp_get_nav_menu_items('menu');
}

add_action( 'rest_api_init', function () {
        register_rest_route( 'myroutes', '/menu', array(
        'methods' => 'GET',
		'callback' => 'get_menu',
		'schema' => null
    ) );
} );

 

/* 
	media
*/
add_action( 'rest_api_init', 'register_media_data' );
 function register_media_data() {
 

	register_rest_field( 'attachment', 'data', array(//THE ROUTE IS MEDIA/the type is attachment
		'get_callback' => 'media_data'

		)
	);
}

function media_data( $object ) { //this function builds the data for a lean json packet of media

	$data = array();   
	$url = wp_upload_dir();
	$upload_path = $url['baseurl']."/";
	$file_path = str_replace($upload_path,'',wp_get_attachment_url($object['id']));
	$file = basename($file_path);
	$path = str_replace($file,"",$file_path);
	$mime = get_post_mime_type( $object['id'] );
	$meta  = (array) wp_get_attachment_metadata( $object['id'],true);


	$meta_data = array();
	
	
//		The meta data properties are only accessible inside a loop for some dumb reason.
	
	if(strpos($mime,'mage/') && !strpos($mime,'svg')){ // the i is left of so the strpos returns a postive value
		$meta_data = array();
		foreach($meta as $key => $value){
			if($key == 'width'){
				$meta_data['w'] = $value;
			} else if($key == 'height'){
				$meta_data['h'] = $value;
			} else if($key == 'sizes'){
				$meta_data['sizes'] = array();
				foreach($meta[$key] as $size_name => $props){
					$meta_data['sizes'][$size_name] = $meta[$key][$size_name]['file'];
				}
			}

			//
		}
	} else {
		//let non image mimetypes pass their full metadata
		$meta_data = $meta;
	}
	$data = array(
	
		'alt' => get_post_meta($object['id'],"_wp_attachment_image_alt",true),
		'caption' => wp_get_attachment_caption($object['id']),
		'title'=> get_the_title($object['id']),
		'desc' => wpautop(get_the_content($object['id'])),
		'path'=> $path,
		'file' => $file,
		'mime' => $mime,
		'meta' => $meta_data
		
	);

 return $data;//from functions.php,

}

/* 
Social_url
*/
add_action( 'rest_api_init', 'register_social_url' );
function register_social_url() {
 

	register_rest_field( ['social'], 'social_url', array(
		'get_callback' => 'get_social_url',
		'schema' => null,
		)
	);
}
 
function get_social_url( $object ) {
	
 return get_post_meta($object['id'],"social_url",true);//from functions.php,
}



/* 
	IMAGES
*/
add_action( 'rest_api_init', 'register_thumbnail_url' );
function register_thumbnail_url() {
 

	register_rest_field( ['profile','resource','page','post'], 'thumbnail_url', array(
		'get_callback' => 'get_thumbnail_url',
		'schema' => null,
		)
	);
}
 
function get_thumbnail_url( $object ) {
	
 return getThumbnailVersions($object['featured_media']);//from functions.php,
}


/* 
	IMAGE VERSIONS
*/

add_action( 'rest_api_init', 'register_thumbnail_url_versions' );
 function register_thumbnail_url_versions() {
 

	register_rest_field( array('profile','resource','page','post'), 'thumbnail_versions', array(
		'get_callback' => 'get_thumbnail_versions',
		'schema' => null,
		)
	);
}
 
function get_thumbnail_versions( $object ) {

 return getThumbnailVersions( $object['id'] );//from functions.php,
}

/*
	Screen Images

*/
add_action( 'rest_api_init', 'register_screen_images' );
 function register_screen_images() {
 

	register_rest_field( array('page','post'), 'screen_images', array(
		'get_callback' => 'get_screen_images'

		)
	);
}
 
function get_screen_images( $object ) {

 return get_post_meta($object['id'],"screen_image") ;//from functions.php,
}


/* 
	FEATURED VIDEO
*/

add_action( 'rest_api_init', 'register_featured_video' );
 function register_featured_video() {
 

	register_rest_field( array('post','page'), 'featured_video', array(
		'get_callback' => 'get_featured_video',
		'schema' => null,
		)
	);
}
 
function get_featured_video( $object ) {
	$post_id = $object['id'];
	$video_id = get_post_meta($post_id,"featured_video",true);
	$url = wp_upload_dir();
	$path = $url['baseurl']."/";
		
		 
		$video = array(
			"video_id"=>$video_id,
			"video_url"=>get_post_meta($post_id,"featured_video_url",true),
			"video_aspect"=>get_post_meta($post_id,"video_aspect",true),
		);


	return @$video;//from functions.php,
}

/*
	REGISTER POST CATEGORIES		
*/

add_action( 'rest_api_init', 'register_post_cats' );

function register_post_cats() {

		register_rest_field( array('profile','resource','post','page'), 'cats', array(
			'get_callback' => 'get_post_cats',
			'schema' => null,
		)
	);
}
function get_post_cats($object){
	$post_id = $object['id'];
	return wp_get_post_categories( $post_id,array( 'fields' => 'ids' ));
}


add_action( 'rest_api_init', 'register_sdgs' );
		
function register_sdgs() {
    
    register_rest_field( 
        array('resource','profile','award'), 
        'sdgs', 
        array(
        'get_callback' => function ( $object ) {
            return get_post_meta( $object['id'],"sdg");
            },
        'schema' => null,
        )
    );
}

add_action( 'rest_api_init', 'register_profiles' );
		
function register_profiles() {
    
    register_rest_field( 
        array('resource'), 
        'profiles', 
        array(
        'get_callback' => function ( $object ) {
            return get_post_meta( $object['id'],"profile");
            },
        'schema' => null,
        )
    );
}
		




	add_action( 'rest_api_init', 'register_resource_meta' );
		
	function register_resource_meta() {
		
		register_rest_field( array('resource'), 'meta', array(
			'get_callback' => 'get_resource_meta',
			'schema' => null,
			)
		);
	}
		
    function get_resource_meta( $object ) {
        $post_id = $object['id'];
        $resource_meta = array(

			"url"=>get_post_meta($post_id,"resource_url",true),
			"type"=>get_post_meta($post_id,"resource_type",true),
		);





        return $resource_meta;
    }


/*WP REST API CUSTOM ENDPOINT. RETURNS SPECIFIC OBJECT OF resource INFO*/ 

	add_action( 'rest_api_init', 'register_profile_info' );
		
	function register_profile_info() {
		
		register_rest_field( 'profile', 'info', array(
			'get_callback' => 'get_profile_info',
			'schema' => null,
			)
		);
	}
		
    function get_profile_info( $object ) {
        $post_id = $object['id'];
        $fields = "description,email,facebook,flickr,GitHub,google_plus,instagram,linkedin,location,medium,pinterest,rss,skype,slack,telegram,Tumblr,twitter,vimeo,website,wikipedia,youtube,acronym,name,apply_url,blog_url,conference_url,contact_url,events_url,jobs_url,logo_svgtag,logo_url";

        $profile_info = array();

        foreach(explode(",",$fields) as $key =>$value){
            if(@get_post_meta($post_id,$value,true)  != ''){
                $profile_info[$value] = get_post_meta($post_id,$value,true);
            }
        }

        return $profile_info;
    }
/*
		/profile info endpoint
*/
//without this the widgets and menus options in wp-admin disappear.
if ( function_exists('register_sidebars') ){
    register_sidebar( array(
        'name' => __( 'Footer', 'powersimple' ),
        'id' => 'footer',
        'description' => __( '', 'powersimple' ),
        'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '',
	'after_title'   => '',
    ) );
}

function get_all_posts( $data, $post ) {
	return [
		
        'title'    	=> $data->data['title']['rendered'],
        'content' => $data->data['content']['rendered']
		
	];
}
add_filter( 'rest_prepare_post', 'get_all_posts');


?>