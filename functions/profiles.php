<?php
    function getProfiles($parent = 0){
        global $wpdb;

    	
		
			$q = $wpdb->get_results("
			select ID, post_name, post_date, post_excerpt, post_title, post_content
			from wp_posts
            where post_type = 'profile'
            and post_status = 'publish'
            and post_parent = $parent
			order by post_title
                ");
                
        $profiles = array();
           
			foreach($q as $key=> $profile){
				array_push($profiles,$profile);
				
            }
            return $profiles;

		

    }
    function displayProfileBoxes($profiles){

        
        
        
        
        foreach($profiles as $key=> $profile){
            extract((array) $profile);
            
            ?>

            <div class="col-xs-12  col-md-4 bio-box">
                <div class="row">
                <div class="col-xs-3 col-md-12">
                <a href="<?=get_permalink($ID)?>"><img src="<?=getThumbnail($ID)?>" alt="<?=$post_title?>"></a>
                </div>
                <div class="col-xs-9 col-md-12">
                
                <h4><a href="<?=get_permalink($ID)?>"><?=$post_title?></a></h4>
                <?php
                print wpautop($post_excerpt);
                ?>
                <a href="<?=get_permalink($ID)?>">Read More</a>
                </div>
                </div>
            </div>

            <?php

        }

    }





    function displayProfilesList($profiles){
        global $post;
        $by_letter = array();
        
        foreach($profiles as $key=> $profile){
          
           
             $letter = substr($profile->post_title, 0, 1);


            if ( ! isset($by_letter[$letter]) ){
                $by_letter[$letter] = array();
               
    
            } 
             $by_letter[$letter][] = $profile;
            if ( ! empty( $by_letter ) ) {
                //ksort($by_letter); // order the array

                // fill the array with letters have no posts
              //  $by_letter = fill_by_letter_array( $by_letter );

             //   display_letters_anchors( array_keys( $by_letter ) );

               
            }
             
 
           // extract((array) $profile);
         // print "<li><a href='/profile/$post_name'>$post_title</a></li>";   
 
        }
        /*
        print "<div class='alphanav'>
        <ul>";
        foreach( $by_letter as $letter =>$posts) {
            print "<li><a href='#$letter' class='section-scroll'>$letter</a></li>";
        }
        print "</ul>
        </div>";
*/
        print "<div class='profile-nav'>
        <ul>";

        foreach( $by_letter as $letter => $posts ) {
            
          //  echo "<span class='letter' title='Scroll to Profiles Beginning with $letter'>$letter</span>";
          //  print "<ul id='$letter'>";
            foreach($by_letter[$letter] as $key => $value){
                $selected = '';
                if($value->ID == $post->ID){
                    $selected = ' class="selected-bio"';
                }
                $permalink = get_permalink($value->ID);
                print "<li$selected><a href='$permalink'>$value->post_title</a></li>";
            }
           // print '</ul>';
              //  echo "<a class='back-to-top section-scroll' title='Back To Top' href='#list-top'>^</a>";
           
           
        }
         print '</ul>
         </div>';
  
                        

       

    }

?>