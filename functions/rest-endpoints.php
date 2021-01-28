<?php
    /*Optimize page loads by rendering restapi queries to static json files and save them in app/json/*/
/*
  ===BEWARE OF REST API PAGINATION AND SORT ORDER!====
Pagination:
Keep in mind, the rest API has a default of 16 records, so you have to set the parameter
&per_page=, and the limit is 100. If you need to return more than 100 results from any of the queries below
you have to paginate the results
Otherwise, the results you want, may not be the results it returns.
Sort: For sanity's sake, it's best that you sort posts by ID, so when inspecting your endpoint, they are in order
Hence, the REST_post_filter variable below.
*/
$GLOBALS['REST_post_filter'] = "filter[orderby]=ID&order=asc&per_page=100";// handles order and pagination

$GLOBALS['REST_CONFIG'] =array(//An array of url arguments
         /*   */  
         // "posts"=>"fields=id,type,title,content,slug,excerpt,languages,featured_media,screen_images,video,type,cats,tags&".$GLOBALS['REST_post_filter'],
           // "pages"=>"fields=id,type,title,content,slug,excerpt,languages,featured_media,screen_images,featured_video,cats,tags,type&".$GLOBALS['REST_post_filter'],
           "profile"=>"fields=id,title,content,slug,excerpt,languages,info,cats,tags,sdgs,countries&".$GLOBALS['REST_post_filter'],
           "resource"=>"fields=id,type,title,content,slug,meta,cats,tags,countries,gradelevel,sdgs&".$GLOBALS['REST_post_filter'],
           "sdg"=>"fields=id,title.rendered,slug,content&".$GLOBALS['REST_post_filter'],
            //"social"=>"fields=id,type,title,content,slug,excerpt,featured_media,social_url&".$GLOBALS['REST_post_filter'],
            "countries"=>"fields=id,name,slug,posts,children&filter[posts_per_page]=-1",
            "gradelevel"=>"fields=id,name,slug,parent,posts&filter[posts_per_page]=-1",
            "taxonomies"=>"fields=name,slug,types,rest_base,hierarchical",
            "resource_type"=>"fields=id,type,name,slug,posts&filter[orderby]=ID&order=asc&per_page=100",
            "categories"=>"fields=id,name,count,posts,slug,description,posts,children",
            "tags"=>"fields=id,name,slug,posts&".$GLOBALS['REST_post_filter'],
            "menus"=>"menus",
            "media"=>"fields=id,data&".$GLOBALS['REST_post_filter']
        );
add_filter( 'rest_endpoints', function( $endpoints ){
    if ( ! isset( $endpoints['/wp/v2/countries'] ) ) {
        return $endpoints;
    }
    unset( $endpoints['/wp/v2/countries'][0]['args']['per_page']['maximum'] );
    return $endpoints;
});
// for WPML Comment this out if you aren't using it.
require_once("functions-wpml-languages.php");

        
    function getEndpoints(){ // BUILDS URLS FOR REST API ENDPOINTS

       $content = array();

        $url_path = "http://".$_SERVER['HTTP_HOST']."/wp-json/wp/v2/";//pendpoint path
        $server_path = get_template_directory()."/data/";//destination folder for writing
 
        if(@$_GET['endpoints']){//header for list of endpoints
                print "<strong>ENDPOINTS:</strong>
                <ul>";
        }
        
        foreach($GLOBALS['REST_CONFIG'] as $key => $value){//loops through the array of endpoints above

           $url = $url_path.$key."?".$value; // default, value passes params in REST_CONFIG array
     
            if(function_exists('icl_object_id')){// if WPML is here. 
                if($value == 'language'){ //language = $key, will not work with arguments
                    //see path registrations in WPML Languages
                    $url = $url_path.$key;// this is the REST API url with the language last
                }

            }

           
           $server = $server_path.$key.".json";
           if(@$_GET['publish']){
            
            //print $url;
            $content[$key] = json_decode(getJSON($url));

           // writeJSON($server,)$content[$key];
           }

              if(@$_GET['endpoints']){//prints endpoint urls
                print "<li><a href='$url'>$key</a><br></li>";
              }

            
        }
        if(@$_GET['endpoints']){
            print "</ul>";
            die();//kills the page load so you can see the endpoint urls
        }
        if(@$_GET['publish']){
           // header('Content-Type: application/json');
            $content = json_encode($content,true); // writes the whole shebang into a json packet
            writeJSON($server_path."content.json",$content);
            print $content;
            die();//kills the page load so you can see the endpoint urls
        }
      //writeJSON($posts_path,$file_path);

        

    }
    function getJSON($data_path){
        print $data_path;
        return file_get_contents($data_path);
    }

    function writeJSON($file_path,$data){
        //$data = file_get_contents($posts_path);
        $handle = fopen($file_path, 'w') or die('Cannot open file:  '.$file_path);
        fwrite($handle, $data);
        fclose($handle);
    }
    
    $user = wp_get_current_user();
    $allowed_roles = array('administrator');
    if( array_intersect($allowed_roles, $user->roles ) ) {  
       //stuff here for allowed roles
     
        
    if(@$_GET['publish'] || @$_GET['endpoints']){
        getEndpoints();
       
    }
} 

add_filter( 'rest_post_collection_params', 'big_json_change_post_per_page', 10, 1 );
function big_json_change_post_per_page( $params ) {
    if ( isset( $params['per_page'] ) ) {
        $params['per_page']['maximum'] = 300;
    }
    return $params;
}
    //add_action( 'save_post', 'refreshJSON');// this will run if you save a post. Too much overhead for every save so better to trigger manually
?>