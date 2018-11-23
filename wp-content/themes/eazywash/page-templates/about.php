<?php
/* 
Template Name: About 
*/

get_header(); while(have_posts()) : the_post(); ?>

<section class="about">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center mt-5 mx-auto">
				<h2 class="mb-3"><?php if(CFS()->get('page_title')){ echo CFS()->get('page_title'); } else{ the_title(); } ?></h2>
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</section>

<section class="bottom-car">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 p-0">
				<img class="bottom-img img-fluid" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/about-car.png" alt="<?php the_title(); ?>">
			</div>
		</div>
	</div>
</section>

<?php endwhile; get_footer(); ?>
