<?php
/* 
Template Name: Pricing 
*/

get_header(); while(have_posts()) : the_post(); ?>

<section class="about">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center my-5 mx-auto">
				<h2 class="mb-3"><?php if(CFS()->get('page_title')){ echo CFS()->get('page_title'); } else{ the_title(); } ?></h2>
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</section>

<section class="pricing">
	<div class="container">
		<div class="col-sm-12 col-xl-8 mx-auto">
			<div class="row">
				<div class="col-sm-4 price">
					<div class="price-logo text-center">
						<img class="img-fluid" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/price-top.png" alt="price">
						<strong>$20</strong>
					</div>
					<div class="price-text mt-3">
						<p>Option Example 1</p>
						<p>Option Example 2</p>
						<a class="cust-button mt-3" href="#">CHECK</a>
					</div>
				</div>
				<div class="col-sm-4 price-active">
					<div class="price-logo text-center">
						<img class="img-fluid" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/price-top-active.png" alt="price">
						<strong>$20</strong>
					</div>
					<div class="price-text mt-3">
						<p>Option Example 1</p>
						<p>Option Example 2</p>
						<p>Unlimited Option</p>
						<p>Extra Option</p>
						<a class="cust-button mt-3" href="#">CHECK</a>
					</div>
				</div>
				<div class="col-sm-4 price">
					<div class="price-logo text-center">
						<img class="img-fluid" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/price-top.png" alt="price">
						<strong>$20</strong>
					</div>
					<div class="price-text mt-3">
						<p>Option Example 1</p>
						<p>Option Example 2</p>
						<a class="cust-button mt-3" href="#">CHECK</a>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<?php endwhile; get_footer(); ?>
