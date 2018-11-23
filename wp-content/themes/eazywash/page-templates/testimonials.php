<?php
/* 
Template Name: Testimonials 
*/

get_header(); while(have_posts()) : the_post(); ?>

<section class="testimonials">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center mb-4 p-0">
				<h2 class="mt-6"><?php if(CFS()->get('page_title')){ echo CFS()->get('page_title'); } else{ the_title(); } ?></h2>
				<?php the_content(); ?>
			</div>
		</div>

		<div class="row">
		<div class="text-center mx-auto col-md-12  col-xl-7">
					<div id="demo" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">
							<div class="testimonial-box carousel-item active">
								<div class="user-img">
									<img class="img-fluid" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/testi-img.png" alt="<?php the_title(); ?>">
								</div>
								<div class="test-text">
									<p>Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum nunc putamus parum.</p>
									<strong class="title">David Miller</strong>
									<strong>CEO Example</strong>
								</div>
							</div>

							<div class="testimonial-box carousel-item">
								<div class="user-img">
									<img class="img-fluid" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/testi-img.png" alt="<?php the_title(); ?>">
								</div>
								<div class="test-text">
									<p>Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum nunc putamus parum.</p>
									<strong class="title">David Miller 2</strong>
									<strong>CEO Example</strong>
								</div>
							</div>

							<div class="testimonial-box carousel-item">
								<div class="user-img">
									<img class="img-fluid" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/testi-img.png" alt="<?php the_title(); ?>">
								</div>
								<div class="test-text">
									<p>Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum nunc putamus parum.</p>
									<strong class="title">David Miller 3</strong>
									<strong>CEO Example</strong>
								</div>
							</div>
						</div>

						<!-- Left and right controls -->
						<a class="carousel-control-prev" href="#demo" data-slide="prev">
						<i class="fa fa-chevron-left"></i>
						</a>
						<a class="carousel-control-next" href="#demo" data-slide="next">
						<i class="fa fa-chevron-right"></i>
						</a>
						
					</div>
				</div>
		</div>
	</div>
</section>

<?php endwhile; get_footer(); ?>