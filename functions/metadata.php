<?php
function getMetaData($id){
    global $wpdb;
    $sql = "select * from wp_postmeta where post_id = $id";
    $meta = array();
    foreach($wpdb->get_results($sql) as $key =>$value){
        $meta[$value->meta_key] = $value->meta_value;
    }

    return $meta;


}

function external_meta(){
    $links = array(
        'URL' => "Website",
        'about_url' => "About",
        'blog_url' => "Blog",
        'events_url' => "Events",
        'jobs_url' => "Jobs",
        'conference_url' => 'Conference',
        'apply_url' => "Apply",
        'contact_url' => "Contact",
        
    );
    $social = array(
        'facebook' => "Facebook",
        'twitter' => "Twitter",
        'linkedin' => "LinkedIn",
        'google_plus' => "Google Plus",
        'instagram' => "Instagram",
        'tumblr' => 'Tumblr',
        'flickr' => "Flickr"
    );
    $images = array(
        
        'share_image' => "Share URL",
        'logo_svgtag' => "Logo SVG",
        'logo_url' => "Logo URL",
    );
     return array ('links'=>$links,
     'social'=> $social,
     'images' => $images
    );   

}

function displayExternalLinks($metadata){
   
    $meta_groups = external_meta();

    print "<div class='profile-logo'>";
    foreach($meta_groups['images'] as $field =>$label){
        $img = '';
        if(@$metadata[$field] != ''){
           
           $img .= "<a href='$metadata[URL]' target='_blank' class='external external-image'>";
            $img .= "<img src='$metadata[$field]' alt=''>";//$meta_groups['links'][$field];
            $img .= "</a>";


        }
        print $img;
    }
    print "</div>";

     print "<nav class='profile-meta'>";
    foreach($meta_groups['links'] as $field =>$label){
        if(@$metadata[$field] != ''){
            print "<a href='$metadata[$field]' target='_blank' class='external external-link'>";
            print $meta_groups['links'][$field];
            print "</a>";


        }
    }
     foreach($meta_groups['social'] as $field =>$label){
        if(@$metadata[$field] != ''){
            print "<a href='$metadata[$field]' target='_blank' class='external external-social'>";
            print "<i class='fa fa-$field'></i>";
            print "</a>";


        }
    }
    print "</nav>";
     


}
?>