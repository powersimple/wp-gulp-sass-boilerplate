<?php 
function getGenres(){
			global $wpdb;
			$q = $wpdb->get_results("
            select ID, post_title, post_content, post_name
            from wp_posts
			where post_type = 'book'
			and post_parent = '0'
			and post_status='publish'
			
			order by menu_order
				");
			$genres = array();
			foreach($q as $key => $value){
				extract((array) $value);
				array_push($genres,
				array(
					"id" => $ID,
					"title" =>$post_title,
					"content" => $post_content,
                    "slug" => $post_name,
                    "books"=>getBooksByGenre($ID)
					
				));

			}
			return $genres;
        }
        function getBooksByGenre($id){
            global $wpdb;
			$q = $wpdb->get_results("
            select ID, post_title, post_content, post_name
            from wp_posts
			where post_type = 'book'
			and post_parent = $id
			and post_status='publish'
			order by menu_order
				");
            $genres = array();
            $books = array();
            foreach($q as $key => $value){
                extract((array) $value);
            array_push($books,
				array(
					"id" => $ID,
					"title" =>$post_title,
					"content" => $post_content,
                    "slug" => $post_name,
                    "amazon_url"=>get_post_meta($ID,"amazon_url",true),
                    "ibooks_url"=>get_post_meta($ID,"ibooks_url",true),
                    "kobo_url"=>get_post_meta($ID,"kobo_url",true),
                    "bn_url"=>get_post_meta($ID,"google_url",true),
                    "googleplay_url"=>get_post_meta($ID,"googleplay_url",true),
                    "goodreads_url"=>get_post_meta($ID,"goodreads_url",true),
                    "thumbnail" => get_post_thumbnail_id($ID),
					
				));

            }
            return $books;

        }
        


        function getMediums(){
			global $wpdb;
			$q = $wpdb->get_results("
            select ID, post_title, post_content, post_name
            from wp_posts
			where post_type = 'appearance'
			and post_parent = '0'
			and post_status='publish'
			
			order by menu_order
				");
			$mediums = array();
			foreach($q as $key => $value){
				extract((array) $value);
				array_push($mediums,
				array(
					"id" => $ID,
					"title" =>$post_title,
					"content" => $post_content,
                    "slug" => $post_name,
                    "appearances"=>getAppearanceByMedium($ID)
					
				));

			}
			return $mediums;
        }
        function getAppearanceByMedium($id){
            global $wpdb;
			$q = $wpdb->get_results("
            select ID, post_title, post_content, post_name
            from wp_posts
			where post_type = 'appearance'
			and post_parent = $id
			and post_status='publish'
			order by menu_order
				");
            $mediums = array();
            $books = array();
            foreach($q as $key => $value){
                extract((array) $value);
            array_push($books,
				array(
					"id" => $ID,
					"title" =>$post_title,
					"content" => $post_content,
                    "slug" => $post_name,
                    "external_url"=>get_post_meta($ID,"external_url",true),
                    "embed_url"=>get_post_meta($ID,"embed_url",true),
                    "appearance"=>get_post_meta($ID,"appearance",true),
                    "thumbnail" => get_post_thumbnail_id($ID),
				));

            }
            return $books;

        }
        function getLinkImage($vendor){
            $link_images = array(
                "amazon"=>array('src'=>"/wp-content/uploads/amazon1.jpg",
                'src_over'=>"/wp-content/uploads/amazon-over.jpg", )
            );
            
            $attr = 'src="'.$link_images[$vendor]['src'].'" onmouseover="this.src=\''.$link_images[$vendor]['src_over'].'\'" onmouseout="this.src=\''.$link_images[$vendor]['src'].'\'"';


            return $attr;

        }

        function displayBookLinks($book){
            extract((array) $book);
            if($amazon_url != ''){
                $img = getLinkImage("amazon");
                print "<li class='amazon'><a href='$amazon_url' title=\"Order $title on Amazon\" target='_blank'><img $img alt='amazon'>For Kindle and in Paperback</a></a>";

            }


        }
?>