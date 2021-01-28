<?php

    /* OLD RELIABLE!
        HASN'T CHANGED IN YEARS
            RETURNS URL BY ID, AND OPTIONAL SIZE */
		function getThumbnail($id,$use="full"){
			global $post;
			$thumbnail_id = get_post_thumbnail_id( $id);
			
			$img = wp_get_attachment_image_src( $thumbnail_id, $use);
			if($img[0] !=""){

			} 
			return $img[0];
			
		}
		function getFeaturedImage($post_id,$use="full"){
			global $post;
			$thumbnail_id = get_post_thumbnail_id( $post_id);
			$content_post = get_post($thumbnail_id);
			$content = $content_post->post_content;
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			$src = wp_get_attachment_image_src( $thumbnail_id, $use);
			$data = array(
			'src' => $src[0],
			'width' => $src[1],
			'height' => $src[2],
			'alt' => get_post_meta($thumbnail_id,"_wp_attachment_image_alt",true),
			'caption' => wpautop(wp_get_attachment_caption($thumbnail_id)),
			'title'=> get_the_title($thumbnail_id),
			'desc' => $content
			);
			return $data;
		}
	

		function getHero($id,$use="full"){
			global $post;
			
			$hero_id = get_post_meta($id,"hero",true);
			$img = wp_get_attachment_image_src(  $hero_id, $use);
			if($img[0] !=""){
			} 
			return @$img[0];
			
		}


	
	
		
	
	
		/* 	PASS ID AND IT RETURNS OBJECT OF SIZES BY URL */
		function getThumbnailVersions($id){
				global $post;
				$thumbnail_id = get_post_thumbnail_id( $id);
				$thumbnail_versions = array(); //creates the array of size by url
			//	var_dump( get_intermediate_image_sizes() );
				foreach(get_intermediate_image_sizes() as $key => $size){//loop through sizes
					$img = wp_get_attachment_image_src($thumbnail_id,$size);//get the url 
					
					if($img[0] !=""){
						$thumbnail_versions[$size]=$img[0];//sets size by url
					} 
				}
				return $thumbnail_versions;
			
		}
	
	
	
	
		//Embed Video  Shortcode
	
		function video_shortcode( $atts, $content = null ) {
			//set default attributes and values
			$values = shortcode_atts( array(
				'url'   	=> '#',
				'className'	=> 'video-embed',
				'aspect' => '56.25%'
			), $atts );
			
			ob_start();
			?>
			<div class="video-wrapper">
				<iframe src="<?php echo $values['url']?>" class="<?php echo $values['className']?>"></iframe>
			</div> 
			<?php
			return ob_get_clean();
			//return '<a href="'. esc_attr($values['url']) .'"  target="'. esc_attr($values['target']) .'" class="btn btn-green">'. $content .'</a>';
		
		}
		add_shortcode( 'embed_video', 'video_shortcode' );

        function get_media_data( $id ) { //this function builds the data for a lean json packet of media
			$data = array();   
			$url = wp_upload_dir();
			$upload_path = $url['baseurl']."/";
			$file_path = str_replace($upload_path,'',wp_get_attachment_url($id));
			$file = basename($file_path);
			$path = str_replace($file,"",$file_path);
			$mime = get_post_mime_type( $id );
			$meta  = (array) wp_get_attachment_metadata( $id,true);
			$meta_data = array();
			/*
			
				The meta data properties are only accessible inside a loop for some dumb reason.
			*/
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

			
			$content_post = get_post($id);
			$content = $content_post->post_content;
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);

			$data = array(
			
				'alt' => get_post_meta($id,"_wp_attachment_image_alt",true),
				'caption' => wpautop(wp_get_attachment_caption($id)),
				'title'=> get_the_title($id),
				'desc' => $content,
				'path'=> $path,
				'file' => $file,
				'mime' => $mime,
				'meta' => $meta_data
				
			);
		return $data;//from functions.php,
		}

		function getEmbedLink($url){

		}

		function embedVideoFromURL($url){


		}

		function displayFeaturedImage(){
			global $post;
			  $img = getFeaturedImage($post->ID,"large");
                extract($img);
                                    //local hero
                                
			if($src != ''){
				//  print $src;
				print "<div class='featured'>";
					print "<div class='featured-wrap'>";
					
						print "<img src='$src' alt='$alt'>";
						if($desc != ''){
							print "<span class='credit reverse'>".strip_tags($desc)."</span>";

						}
					print '</div>';
					print "<div class='caption'>";
					if(trim($title) != ''){
					
						print "<span class='img-title'>$title</span>";
					}
					if(trim($caption) != ''){
					
						print "<caption>$caption</caption>";
					}
					print "</div>";
				print "</div>";
				
			} else {
				print "<div class='top-spacer'></div>";
			}
		}
?>