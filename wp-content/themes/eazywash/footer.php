<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

	
<section class="footer py-5">
  <div class="container">
      <div class="row">
          <div class="col-sm-12 text-center mb-5">
            <img class="img-fluid" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/foot-logo.png" alt="Footer Logo">
          </div>

          <div class="col-sm-4 d-none d-sm-block">
            <h5>{{'footer_user_links' | translate}}</h5>
			<?php 
				wp_nav_menu(array('menu' => 'Footer Menu', 'container' => '', 'menu_class' => 'foot-menu'));
			?>  
              
          </div>
          
          <div class="col-sm-4 d-none d-sm-block contact my-5 my-sm-0">
            <h5 class="text-upper">{{'footer_contact_us' | translate}}</h5>

            <h6>EazyWash</h6>
            <p>Address Example 17</p>
            <p>{{'basic_details.tel' | translate}}: <a href="tel:0123456789">01 234 567 89</a></p>  
            <p>{{'basic_details.email' | translate}}: <a href="mailto:eazywash@example.com">eazywash@example.com</a></p>

            <div class="social mt-3">
              <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
              <a href="javascript:void(0)"><i class="fab fa-twitter"></i></a>
              <a href="javascript:void(0)"><i class="fab fa-google-plus-g"></i></a>
              <a href="javascript:void(0)"><i class="fab fa-linkedin-in"></i></a>
            </div>


          </div>

          <div class="col-sm-4 foot-form">
            <h5 class="d-sm-none text-center">{{'footer_contact_us' | translate}}</h5>
            <?php 
              echo do_shortcode('[contact-form-7 id="11" title="Footer Contact Form"]');
            ?>
            <div class="mobadd contact text-center d-sm-none">
              <h6>EazyWash</h6>
              <p>Address Example 17</p>
              <p>{{'basic_details.tel' | translate}}: <a href="tel:0123456789">01 234 567 89</a></p>  
              <p>{{'basic_details.email' | translate}}: <a href="mailto:eazywash@example.com">eazywash@example.com</a></p>
              </div>
          </div>

      </div>
      <div class="row text-center copyright">
        <div class="col-sm-12 mt-4">
          <p>© <?php echo date('Y'); ?> Eazywash — {{'footer_copyright' | translate}}</p>
        </div>
      </div>
  </div>
</section>

<?php require_once('inc/modal.php'); ?>

<?php wp_footer(); ?>

<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery-3.3.1.slim.min.js"></script>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/popper.min.js"></script>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/bootstrap.min.js"></script>   

</body>
</html>
