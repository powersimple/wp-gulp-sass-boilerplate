<?php
    get_header();
?>

    <div class="row">
        
                <h1 class='reverse'><?php echo $post->post_title;?></h1>
                <div class="col-sm-8  text-body">
           
               
                    <?php
                     
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                    
                            the_post(); 
                               
                  
                            ?>
                  
                    
                    <div class="panel-body outer-shadow">
                        <?php
                        displayFeaturedImage();
                        ?>
                        <div class="panel-content">
                        <?php

                       echo the_content()?>
                        </div>
                    
                    </div>
                            
                    
                        <?php }
                    }

                    ?>
                </div>
                <div class="col-sm-4 col-md-3  sidebar scaffold reverse">
                    <div class="box">


                        <?php
                            
                            dynamic_sidebar('page-sidebar');
                        ?>
                    </div>
                
            </div>
    </div>
<?php
    get_footer();
?>                                                                   ``