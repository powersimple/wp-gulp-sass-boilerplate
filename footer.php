          </div>


    </section>
</main>
  <!--   -->
  <?php 
  $bootstrap = "col-sm-12 col-md-6 col-lg-3";
  ?>
  <div class="module-small footer-widgets">
          <div class="container">
            <div class="row">
              <div class="<? echo $bootstrap;?>">
                
                 <?php dynamic_sidebar( 'footer-1' ); ?> 
               
              </div>
              <div class="<? echo $bootstrap;?>">
                
                  <?php dynamic_sidebar( 'footer-2' ); ?> 
                
              </div>
              <div class="<? echo $bootstrap;?>">
                
                 <?php dynamic_sidebar( 'footer-3' ); ?> 
                
              </div>
              <div class="<? echo $bootstrap;?>">
               
                  <?php dynamic_sidebar( 'footer-4' ); ?> 
                
              </div>
            </div>
          </div>
        </div>
        <hr class="divider-d">
   
        <footer>
       
            <div class="row">
              <div class="col-sm-12">
                <p class="copyright">&copy; <?php  echo date("Y"); ?> <?php  bloginfo("name"); ?>, All Rights Reserved | <a href="https://www.facebook.com/ctaun/" target="blank"><i class="fa fa-facebook"></i></a></p>
              </div>
              
            </div>

        </footer>
      </div>
      <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
        </div><!---main-->
 
</main>
    
  

<?php wp_footer(); ?>
<script src="<?php echo get_stylesheet_directory_uri()?>/assets/lib/jquery/dist/jquery.js"></script>
<script src="<?php echo get_stylesheet_directory_uri()?>/assets/lib/bootstrap/dist/js/bootstrap.min.js"></script>
     
    
    <script src="<?php echo get_stylesheet_directory_uri()?>/vendor.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri()?>/assets/js/plugins.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri()?>/assets/js/main.js"></script>
  <!--  <script src="<?php echo get_stylesheet_directory_uri()?>/main.min.js"></script>-->

</body>
</html>