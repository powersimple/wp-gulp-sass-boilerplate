<?php
    function importMeta($post_type,$table,$id,$profile_id){
        $fields = 'name,acronym,URL,email,location,title,logo_url,share_image_url,logo_svgtag,contact_url,blog_url,twitter,facebook,linkedin,github,medium,slack,telegram,skype,instagram,snapchat,foursquare,youtube,vimeo,tumblr,google_plus,pinterest,behance,flickr,rss,jobs_url,apply_url,events_url,conference_url';
        global $wpdb;
        $sql = "select ID, post_title from wp_posts where ID >= $profile_id";
        $field_array = explode(",",$fields);
        $q = $wpdb->get_results($sql);
        $new_id = $id;
        $new_profile = $profile_id;
        foreach ($q as $key => $value) {
            print "$value->ID $value->post_title";
            print "<br>";
            if($new_id == 117){
                $new_id = 118;
            }

           $profile_sql = "select * from profile_data where id = $new_id ";


             foreach($wpdb->get_results($profile_sql) as $p => $profile){
                 $profile = (array) $profile;
                foreach($field_array as $key =>$field){
                    if($profile[$field] != ''){
                   // print "$field =";
                    //print $field_value = $profile[$field];


                    $field_val = str_replace("///","/'",$profile[$field]);
                    $field_val = str_replace("://",":|'",$profile[$field]);
                  $field_val = str_replace("//","/'",$profile[$field]);
                  $field_val = str_replace(":|","://'",$profile[$field]);
                  $field_val = str_replace("//","/'",$profile[$field]);
                    $field_val = str_replace("'","\'",$profile[$field]);
                    print $insert = "INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (NULL, '$value->ID', '$field', '$field_val');";
                    print "<br>";
                  // $wpdb->query($insert);
                    }

                }
print "<br>";

             }
             
             $new_id++;


             $new_profile = $new_id+$new_profile;



            




print "<br>";
            print "<br>";
        }





    }
?>
