<?php
/* ON MENU SAVE */
add_action('wp_update_nav_menu', 'renderMenu');
function renderMenu($nav_menu_selected_id) {
		
		
	
		$menu = getMenus($nav_menu_selected_id);


 	 
	

}
function getMenus($nav_menu_selected_id){
		$url_path = "http://".$_SERVER['HTTP_HOST']."/wp-json/wp/v2/menus";//pendpoint path
		$json = getJSON($url_path);
		$menus = json_decode($json,TRUE);
		$server_path = get_template_directory()."/data/";//destination folder for writing

		foreach($menus as $key => $menu){
			ob_start();
		
			var_dump($menu);
			writeJSON($server_path.$menu['name'].".html",ob_get_clean());
			 
		}
		
}




    function get_home_children(){
		$home_id = get_option( 'page_on_front' );
		$children = get_children( array("post_type"=>"page","post_parent"=>$home_id,'orderby' => 'menu_order ASC','order' => 'ASC') );
		$child_list = array();
	
		foreach ($children as $key => $value) {
			
			array_push($child_list,
				array(
					"ID"=>$value->ID,
					"slug"=>$value->post_name,
					"title"=>$value->post_title,
					"content"=>$value->post_content,
					"section_foot"=>get_post_meta($value->ID,"section_foot",true),
					"thumbnail" => get_post_thumbnail_id($value->ID)
					)
				);
		}
		return $child_list;
	}

	function home_children_menu(){
		$home_id = get_option( 'page_on_front' );
		$children = get_children( array("post_type"=>"page","post_parent"=>$home_id,'orderby' => 'menu_order ASC','order' => 'ASC') );
		$child_list = array();
		foreach ($children as $key => $value) {
			//var_dump($value);
			if(get_post_meta($value->ID,"redirect",true)){
				$href=get_post_meta($value->ID,"redirect",true);
				$target=' target="_blank"';
            } else if(!is_front_page()) {
                $href = get_home_url()."/#".$value->post_name;
                $target="";
            } else {
				$href = "#".$value->post_name;
				$target="";
			}

          
			print '<li><a class="section-scroll" href="'.$href.'"'.$target.'>'.$value->post_title.'</a>';// if printed, shows this.
            
		}
	}

    function linkThis($url,$label,$blank_target=true){
        $target = '';  
        $absolute = '';
        if($blank_target == true){
          $target = 'target="_blank"';
        }
        
        if($url != ''){
          return '<a href="'. $absolute.$url.'" '.$target.'>'.$label.'</a>';
        } 
	  }
	  function isSelected($id,$match){
		$selected = '';
		if($id == $match){
			$selected = ' selected';
		}
		return $selected;
	  }

	  function sdgSubNav(){
			global $post;
			global $wpdb;
			$post_type = '';
				$post_type = get_post_meta(@$post->ID,"postype_subnav",true);
			if($post_type == @get_post_meta(@$post->ID,"postype_subnav",true)){


				

	  		}
			if(@$post->post_parent == 0){
				if($post_type == ''){
				
					
					$parent =  0;
					$post_type = @$post->post_type;
				} else {
					$parent = 0;
				}

				$parent_link = '';
				$title = @$post->post_title;
				$sql = "select ID, post_title,post_name from wp_posts where post_status = 'publish' and post_parent = $parent and post_type='$post_type' order by menu_order";
			} else{
				 $parent = $post->post_parent;
				$parent_link = get_permalink( $post->post_parent);
				$title = $wpdb->get_var("select post_title from wp_posts where ID = $post->post_parent");
				$sql = "select ID, post_title,post_name from wp_posts where post_status = 'publish' and post_type='$post_type' and post_parent = $parent";
			}
	//print $sql;

		$q = $wpdb->get_results($sql);
		print "<ul id='sdg-menu' class='constrain'>";
			//print "<li class='parent-link'><a href='$parent_link'>$title</a></li>";
			$counter=0;
			foreach($q as $key => $item){
				$class="";
				$link = get_permalink($item->ID);
				$slug = explode("-",$item->post_name);
				$sdgbg = str_replace("0","",$slug[0])."bg";

				if($item->ID == $post->ID){
					
					$class = ' selected';
				}
				print "<li class='$sdgbg'><a href='$link' class='item $class'>$item->post_title</a></li>";
			}
			 
		print "</ul>";


	  }

	  function parentSubNav(){
			global $post;
			global $wpdb;
			$post_type = '';
				$post_type = get_post_meta(@$post->ID,"postype_subnav",true);
			if($post_type == @get_post_meta(@$post->ID,"postype_subnav",true)){


				

	  		}
			if($post->post_parent == 0){
				if($post_type == ''){
				
					
					$parent =  0;
					$post_type = $post->post_type;
				} else {
					$parent = 0;
				}

				$parent_link = '';
				$title = $post->post_title;
				$sql = "select ID, post_title from wp_posts where post_status = 'publish' and post_parent = $parent and post_type='$post_type' order by menu_order";
			} else{
				 $parent = $post->post_parent;
				$parent_link = get_permalink( $post->post_parent);
				$title = $wpdb->get_var("select post_title from wp_posts where ID = $post->post_parent");
				$sql = "select ID, post_title from wp_posts where post_status = 'publish' and post_type='$post_type' and post_parent = $parent";
			}
	//print $sql;

		$q = $wpdb->get_results($sql);
		print "<ul class='parent-menu'>";
			//print "<li class='parent-link'><a href='$parent_link'>$title</a></li>";
			$counter=0;
			foreach($q as $key => $item){
				$class="";
				$link = get_permalink($item->ID);
				if($item->ID == $post->ID){
					
					$class = ' selected';
				}
				print "<li><a href='$link' class='item $class'>$item->post_title</a></li>";
			}
			 
		print "</ul>";


	  }
	  function getPostType($post_type){
		global $wpdb;
			$sql = "select ID, post_title from wp_posts where post_status = 'publish' and post_parent = 0 and post_type='$post_type' order by menu_order";
	  
		}
		function sdgMenu(){
		global $wpdb;
		global $post;
		$sql = "select ID, post_title from wp_posts where post_status = 'publish' and post_parent = 0 and post_type='sdg' order by menu_order";
		$q = $wpdb->get_results($sql);
			  $counter=1;
			print "<nav id='sdg-nav' class='constrain' role='navigation'>
				<ul>";
			foreach($q as $key => $item){
				$selected = '';
				if(@$post->ID == $item->ID){
					$selected = ' selected';
				}
				print "<li class='sdg sdg$counter"."bg $selected' title='$item->post_title'>";
				$src= getThumbnail($item->ID);
				$link = get_permalink($item->ID);
				print "<a href='$link'>";
				print "<span class='sdg-icon'><img src='$src' alt='$item->post_title icon'></span>";
				print "</a>";

				print "</li>";
				$counter++;
			}
			print "</ul>
			</nav>";
		}
		function exclude_widget_categories($args){
			$exclude = "1,328";
			$args["exclude"] = $exclude;
			return $args;
		}
		add_filter("widget_categories_args","exclude_widget_categories");

		function getTermMenu($term){
			if($term->taxonomy == 'category'){
				if ( is_active_sidebar('cat_subnav')){
					dynamic_sidebar("cat_subnav");
					}
			}
		}

		function dynamicSubnav(){
			global $post;
			global $wpdb;
			$sql = '';
			$term = get_queried_object();
		
			if(@$post->post_type == 'sdg'){

				sdgSubnav();
			
			} else if($post == NULL){
				
				 
				 
				 if($term != NULL){
					 getTermMenu($term);
				 }
				 resourceAccordion();
			} else {

			$subnav = get_post_meta(@$post->ID,"subnav",true);
				$sql = '';

			if(@$post->post_type){ // subnav variable is declared in admin
			
				if($subnav != ''){
				

					if($post->post_type == 'page'){
						if($subnav == 'award' || $subnav == 'conference'){
							$sql = "select ID, post_title from wp_posts where post_status = 'publish' and post_type='$subnav' order by menu_order";
						
						} else if($subnav == 'resources'){
							resourceAccordion();
							
						} else {

						}
					}

						
				} else {
		
					if($post->post_type == 'resource' || $post->post_type == 'profile'){
						resourceAccordion();
					
					} else if($post->post_type == 'conference'|| $post->post_type == 'award'){	
$sql = "select ID, post_title from wp_posts where post_status = 'publish' and post_parent = 0 and post_type='$post->post_type' order by menu_order";
					} else {
				
						if($post->post_parent == 0){
			//	print "subnav else parent 0"; 
							$parent =  $post->ID;
							$parent_link = '';
							$title = $post->post_title;
							$sql = "select ID, post_title from wp_posts where post_status = 'publish' and post_parent = $parent and post_type='$post->post_type' order by menu_order";
						} else{
							
							$parent = $post->post_parent;
							$parent_link = get_permalink( $post->post_parent);
							$title = $wpdb->get_var("select post_title from wp_posts where ID = $post->post_parent");
							 $sql = "select ID, post_title from wp_posts where post_status = 'publish' and post_type='$post->post_type' and post_parent = $parent";
						}
					}
				}
				

				

			} else if (@$post->post_type != 'page') { // use post_type
				

					$sql = "select ID, post_title from wp_posts where post_status = 'publish' and post_type='$post->post_type' and post_parent=0 order by menu_order";
				
			} else{
				

			
				
			}
			
			menuList($sql,$subnav);
			}
		}

		function menuList($sql,$class){
			if($sql != ''){
				global $wpdb;
				global $post;
				$q = $wpdb->get_results($sql);
				print "<ul class='$class'>";
			
				foreach($q as $key => $item){
					$class="";
					$link = get_permalink($item->ID);
					if($item->ID == $post->ID){
						
						$class = ' selected';
					}
					print "<li><a href='$link' class='item $class'>$item->post_title</a></li>";
				}
				
				print "</ul>";
			}
		}

		function resourceAccordion(){
			$taxonomies = "category,resource_type,";
			ob_start();
			?>
			<div id="resource-accordion">
			
			</div>
<?php
			print ob_get_clean();

		}


?>