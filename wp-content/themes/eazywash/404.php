<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

<section class="error-404 not-found">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h2 class="my-3">404</h2>
				<h4><?php _e( 'Oops! That page can&rsquo;t be found.', 'twentyfifteen' ); ?></h4>
				<p><?php _e( 'It looks like nothing was found at this location.', 'twentyfifteen' ); ?></p>
			</div>
		</div>
	</div>

</section>

		

<?php get_footer(); ?>
