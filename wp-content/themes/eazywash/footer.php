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
global $theme_options;
?>

	
<section class="footer py-5" id="footer" <?php if($theme_options['footer-bg-img']['url']) { echo "style='background-image: url(".$theme_options['footer-bg-img']['url'].");'"; }?>>
  <div class="container">
      <div class="row">
          <div class="col-sm-12 text-center mb-5">
          <?php if($theme_options['footer-logo']['url']) { ?>
            <img class="img-fluid main-logo" src="<?php echo esc_url( $theme_options['footer-logo']['url'] ); ?>" alt="<?php echo get_bloginfo('name'); ?>">
          <?php } ?>
          </div>

          <div class="col-sm-4 d-none d-sm-block">
          <?php if($theme_options['first-col-title']) { ?> 
            <h5><?php echo $theme_options['first-col-title']; ?></h5>
          <?php } ?>

            <?php 
              wp_nav_menu(array('menu' => 'Footer Menu', 'container' => '', 'menu_class' => 'foot-menu'));
            ?>  
              
          </div>
          
          <div class="col-sm-4 d-none d-sm-block contact my-5 my-sm-0">

            <?php if($theme_options['second-col-title']) { ?> 
              <h5><?php echo $theme_options['second-col-title']; ?></h5>
            <?php } ?>

            <?php if($theme_options['second-col-subtitle']) { ?> 
              <h6><?php echo $theme_options['second-col-subtitle']; ?></h6>
            <?php } ?>

            <?php if($theme_options['site-address']) { ?> 
              <p><?php echo wp_strip_all_tags($theme_options['site-address']); ?></p>
            <?php } ?>

            
            <?php if($theme_options['site-phone']) { ?> 
              <p>Tel: <a href="tel:<?php echo preg_replace("/[^0-9]/","",$theme_options['site-phone']); ?>"><?php echo ($theme_options['site-phone']); ?></a></p>
            <?php } ?>

            <?php if($theme_options['site-email']) { ?>   
              <p>Email: <a href="mailto:<?php echo ($theme_options['site-email']); ?>"><?php echo ($theme_options['site-email']); ?></a></p>
            <?php } ?> 

            <?php if($theme_options['facebook-link'] || $theme_options['twitter-link'] || $theme_options['gp-link'] || $theme_options['linkedin-link']  ) { ?>
              <div class="social mt-3">
                
                <?php if($theme_options['facebook-link']) { ?> 
                  <a href="<?php echo $theme_options['facebook-link']; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <?php } ?>

                <?php if($theme_options['twitter-link']) { ?> 
                  <a href="<?php echo $theme_options['twitter-link']; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                <?php } ?>

                <?php if($theme_options['gp-link']) { ?> 
                  <a href="<?php echo $theme_options['gp-link']; ?>" target="_blank"><i class="fab fa-google-plus-g"></i></a>
                <?php } ?>

                <?php if($theme_options['linkedin-link']) { ?> 
                  <a href="<?php echo $theme_options['linkedin-link']; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                <?php } ?>
                
              </div>
            <?php } ?>


          </div>

          <div class="col-sm-4 foot-form">
            <?php if($theme_options['second-col-title']) { ?> 
              <h5 class="d-sm-none text-center"><?php echo $theme_options['second-col-title']; ?></h5>
            <?php } ?>

            <?php 
              echo do_shortcode('[contact-form-7 id="11" title="Footer Contact Form"]');
            ?>

            <div class="mobadd contact text-center d-sm-none">
            <?php if($theme_options['second-col-subtitle']) { ?> 
              <h6><?php echo $theme_options['second-col-subtitle']; ?></h6>
            <?php } ?>

            <?php if($theme_options['site-address']) { ?> 
              <p><?php echo wp_strip_all_tags($theme_options['site-address']); ?></p>
            <?php } ?>

              
            <?php if($theme_options['site-phone']) { ?> 
              <p>Tel: <a href="tel:<?php echo preg_replace("/[^0-9]/","",$theme_options['site-phone']); ?>"><?php echo ($theme_options['site-phone']); ?></a></p>
            <?php } ?>

            <?php if($theme_options['site-email']) { ?>   
              <p>Email: <a href="mailto:<?php echo ($theme_options['site-email']); ?>"><?php echo ($theme_options['site-email']); ?></a></p>
            <?php } ?>

          </div>

          </div>

      </div>
      
      <?php if($theme_options['copyright-info']) { ?>
      <div class="row text-center copyright">
        <div class="col-sm-12 mt-4">
          <p><?php echo wp_strip_all_tags($theme_options['copyright-info']); ?></p>
        </div>
        
      </div>
      <?php } ?>

  </div>



</section>


<?php require_once('inc/modal.php'); ?>

<?php wp_footer(); ?>

</body>
</html>
