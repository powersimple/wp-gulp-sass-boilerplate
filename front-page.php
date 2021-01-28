

<?php
get_header(); 


                    
?>
    
        
      <?php
 //require_once('lava.html');
$pages = get_home_children();
foreach($pages as $key => $value){
  extract((array)$value);

  if(!get_post_meta($ID,"redirect",true)){ //don't render if external url.

  

  ?>
      <section class="module whitebg homebox" id="<?php echo $slug?>">
          <div class="wrap">
            <h2><?php print $title?></h2>
            <?php
            if(file_exists (get_stylesheet_directory()."/page-$slug.php") ){
              require_once(get_stylesheet_directory()."/page-$slug.php"); // includes page-slug.php if it exists
            } else {

            ?>
           
             <div class="row multi-columns-row post-columns">
                
                <div class="col col-sm-8">
                     
                    <?php print wpautop($content);?>
        
                  </div>

                  <div class="col-sm-4">

                    <img src="<?php print getThumbnail($ID,"medium_large");?>" alt=""> 
                </div>

        
            
            <?php 
              } 
            ?>

            </div>
          <div id="wrap">
           <?php
          }
          ?>
        </section>
        <?php 
          
          if(trim(@$section_foot) != ''){
            ?><div class="section-foot">
              <img  src="<?php echo getThumbnail($section_foot,"medium_large size");?>">

        </div>
       <script>
        jQuery(".site-title").addClass("sticky-header");
         </script>

<?php
    }
  }
get_footer(); ?>