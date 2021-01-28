<?php
    	function getSpeaker($speaker_id){
			global $wpdb;
			$q = $wpdb->get_row("
			select ID, post_name, post_date, post_excerpt, post_title, post_content
			from wp_posts
			where ID= $speaker_id
			
			order by menu_order
				");
				extract((array) $q);
			$speaker = array(
				"id" => $speaker_id,
				"speaker_name" =>@$post_title,
				"content" => @$post_content,
				"excerpt" => @$post_excerpt,
				
				"slug" => @$post_name,
				"speaker_title" => get_post_meta($speaker_id,"speaker_title",true),
				"speaker_company" => get_post_meta($speaker_id,"speaker_company",true),
				"speaker_website" => get_post_meta($speaker_id,"speaker_website",true),
				"speaker_wikipedia" => get_post_meta($speaker_id,"speaker_wikipedia",true),
				"speaker_twitter" => get_post_meta($speaker_id,"speaker_twitter",true),
				"speaker_facebook" => get_post_meta($speaker_id,"speaker_facebook",true),
				"speaker_linkedin" => get_post_meta($speaker_id,"speaker_linkedin",true),
				"speaker_flickr" => get_post_meta($speaker_id,"speaker_flickr",true),
				"speaker_instagram" => get_post_meta($speaker_id,"speaker_instagram",true),
				
                "thumbnail" => get_post_thumbnail_id(@$ID),
                "permalink" => get_permalink($speaker_id)
			);
			
			return $speaker;

		}
		function displaySpeaker($speaker_data,$media_size,$context="none"){
			extract($speaker_data);
			$src= getThumbnail($id,$media_size);
			if($context=="long"){
				print '<div class="speaker-long-bio">';
				
			} else if($context=="speaker-list"){
				print '<div class="speaker-list col-sm-6 col-md-3 col-lg-3">';
				print '<strong>'.@$speaker_name."</strong></a><br>";
			} else {
				print '<div class="speaker-short-bio">';
				print '<strong>'.@$speaker_name."</strong></a><br>";
			}
			
         //  print '<div class="speaker-info col-sm-12 col-md-6 col-lg-6">';
           
            
			if($src != ""){
                print '<div class="speaker-image">';
                print '<a href="'.$permalink.'">';
                print '<img src="'.$src.'" alt="'.$speaker_name.'"></a></div>';
            }
           
            print '<div class="speaker-vitals">';
            print '<a href="'.$permalink.'">';
			
			if(@$speaker_title && @$context != "speaker-list"){
				print @$speaker_title.",<br>";
			} 
			if(@$speaker_company){
				print @$speaker_company."<br>";
			}
			if(@$speaker_website){
				print '<a href="'.$speaker_website.'" target="_blank"><i class="fa fa-link"></i></a>';
			}
			if(@$speaker_wikipedia){
				print '<a href="'.$speaker_wikipedia.'" target="_blank"><i class="fa fa-wikipedia-w"></i></a>';
			}
			if(@$speaker_twitter){
				print '<a href="'.$speaker_twitter.'" target="_blank"><i class="fa fa-twitter"></i></a>';
			}
			if(@$speaker_facebook){
				print '<a href="'.$speaker_facebook.'" target="_blank"><i class="fa fa-facebook"></i></a>';
			}
			if(@$speaker_linkedin){
				print '<a href="'.$speaker_linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></a>';
			}
			if(@$speaker_instagram){
				print '<a href="'.$speaker_instagram.'" target="_blank"><i class="fa fa-instagram"></i></a>';
			}
			if(@$speaker_flickr){
				print '<a href="'.$speaker_flickr.'" target="_blank"><i class="fa fa-flickr"></i></a>';
			}
			
			
				
			
				
            print "</div>
            </div>";
			if(@$context == 'long'){
                print do_blocks($content);
            } else if(@$context=="speaker-list"){
				//print '<div style="clear:both;width:100%;"></div>';
			//	print "SESSION:".$session;
			} else if(@$context == 'short'){
				 print '<div class="speaker-excerpt col-sm-12 col-md-6 col-lg-6">';
			   print wpautop($excerpt);
			    print '</div>';
            } else{
                
            }
			
			print '</div>';
			
        }
        function speakerList($speakers){
            $speaker_list = array();
           
			foreach($speakers as $key=>$speaker){
				array_push($speaker_list,getSpeaker($speaker));
				
            }
            return $speaker_list;
		}
		

		function getSpeakers(){
			global $wpdb;
			$q = $wpdb->get_results("
			select ID
			from wp_posts
			where post_status = 'publish' 
			and post_type = 'speaker'
			order by menu_order
				");
			$speaker_list = array();
			foreach($q as $key=>$value){
				array_push($speaker_list,getSpeaker($value->ID));
				
            }
				
			return $speaker_list;

		}


		

?>