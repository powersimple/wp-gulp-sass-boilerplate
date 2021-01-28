<?php
    get_header();
?>

    <div class="row">
        
                <h1 class='reverse'></h1>
                <div class="col-sm-8  text-body">
           
               
                    <?php
                   
                  
                    
                     $search_query = get_search_query();

                  //  var_dump($search_query);
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                    
                            the_post(); 
                          if($post->post_type == 'resource'){
                              ?>
                            <div class="panel-body outer-shadow">
                            <?php
                            displayFeaturedImage();
                            ?>
                             <div class="panel-content">
                             <?php
                            $resource = getResourceFromSearchResult($post,$search_query);
                            displayResourceCard($resource);

                        print "</div>
                        </div>";
                        } else {

                        


                  //          var_dump($wp_query->query_vars);
                  
                            ?>
                  <?php echo get_search_query(); ?>
                    
                    <div class="panel-body outer-shadow">
                        <?php
                        displayFeaturedImage();
                        $link = get_the_permalink();
                        
                        ?>
                        <div class="panel-content">
                         
                        <?php
                     //   print get_the_post_name();
                        print "<a href='$link'>".get_the_title()."</a><br>";


                       echo the_content();
                       
                       ?>
                        </div>
                    
                    </div>
                            
                    
                        <?php
                            } //not resoruce
                        }//loop
                    }//if

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