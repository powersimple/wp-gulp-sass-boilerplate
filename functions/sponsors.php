<?php

    function sponsorGridLevel($sponsor_level){
        if($sponsor_level == 'Terrabit' || $sponsor_level == 'Gigabit'){
            return 'col-sm-12 col-md-6 col-lg-6';
        } else if($sponsor_level == 'Megabit'){
             return 'col-sm-6 col-md-4 col-lg-4';
        } else{
            return 'col-sm-6 col-md-3 col-lg-3';
        }
    }


    function displaySponsors($sponsors){
        



        foreach($sponsors as $key => $sponsor){
            extract( $sponsor);
            //var_dump($sponsor);
            print '<div class="'.sponsorGridLevel($sponsor_level).' sponsor '.strtolower($sponsor_level).'">';
            $src= getThumbnail($thumbnail,"Full");
            print '<a href="'.$sponsor_url.'">';
            if($src == ''){
                print "<strong>$sponsor_name</strong>";
            } else {
            print '<img src="'.$src.'" alt="'.$sponsor_name.'">';
            }

            print '</a></div>';

        }
        
    }
    function getSponsorLevel($level){
        global $wpdb;
        
        $q = $wpdb->get_results("
            select p.ID, p.post_name, p.post_date, p.post_title, p.post_content
            from wp_posts p, wp_postmeta m
            where p.post_type = 'sponsor' 
            and p.post_status='publish'
            and m.meta_key = 'sponsor_level'
            and m.meta_value = '$level'
            and m.post_id = p.ID
            order by menu_order
        ");
        $sponsors = array();
        foreach($q as $key => $value){
            extract((array) $value);

            array_push($sponsors,
            array(
                "id" => $ID,
                "sponsor_name" =>$post_title,
                "sponsor_url"=>get_post_meta($ID,"sponsor-url",true),
                "sponsor_level"=>get_post_meta($ID,"sponsor_level",true),
                "thumbnail" => get_post_thumbnail_id($ID)
            ));

        }
    return $sponsors;
    }
    function sponsorList($sponsors){
        $sponsor_list = array();
        foreach($sponsors as $key=>$sponsor_id){
            array_push($sponsor_list,getSponsor($sponsor_id));
        }
        return $sponsor_list;
    }
    function getSponsor($sponsor_id){
        global $wpdb;
        $q = $wpdb->get_row("
        select ID, post_name, post_date, post_excerpt, post_title, post_content
        from wp_posts
        where ID= $sponsor_id
        
        order by menu_order
            ");
            extract((array) $q);
        $sponsor = array(
            "id" => $sponsor_id,
            "sponsor_name" =>$post_title,
            "content" => $post_content,
            "excerpt" => $post_excerpt,
            
            
            "sponsor_url" => get_post_meta($sponsor_id,"sponsor-url",true),
            "sponsor_level" => get_post_meta($sponsor_id,"sponsor_level",true),
            "thumbnail" => get_post_thumbnail_id($ID),
        );
        
        return $sponsor;

    }
    function displaySponsor($sponsor_data){
        extract($sponsor_data);

         $src= getThumbnail($thumbnail,"thumbnail");
        
    
        print '<a class="" href="'.$sponsor_url.'" target="blank">';
        if($src != ''){
            print '<img class="sponsor '.strtolower($sponsor_level).'" src="'.$src.'" alt="'.$sponsor_name.'">';
        } else {
            print $sponsor_name;
        }
        
        print '</a>';

       
    }
?>