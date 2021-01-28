<?php
    get_header();
?>
    <div class="row">
      
                <h1><?php echo $post->post_title;?></h1>
                <div class="col-sm-8">
           
               
                    <?php
                     
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                    
                            the_post(); 
                           
                            ?>
                  
                    
                    <div class="panel-body">
                         <?php
                        displayFeaturedImage();
                        ?>
                                            <div class="panel-content">
                            
                        <?php
                       echo the_content();
                       if(@$post->post_type == 'conference'){
                        $sessions = getPastSessions($post->ID);
                        displaySessions($sessions);
                       }
                       
                       ?>
                        </div>
                    
                    </div>
                            
                    
                        <?php }
                    }

                    ?>
                </div>
                <div class="col-sm-4 col-md-3  sidebar scaffold reverse">
                    <div class="box">
                    
                    
                        <?php
                        
                        dynamic_sidebar("page-sidebar");?>
                    </div>
                
            </div>
    </div>
<?php
    get_footer();
?>                                                                   