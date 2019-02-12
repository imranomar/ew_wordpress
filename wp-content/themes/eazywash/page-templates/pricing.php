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

<section class="pricing"  ng-controller="PricingCtrl">
	<div class="container">
		<div class="col-sm-12 col-xl-10 mx-auto">
			<div class="row">
				<div class="col-sm-4 price" ng-repeat="(key, price) in prices | orderBy: '-category_name'" ng-class="{'price-active': $odd}">
					<div class="price-logo text-center">
						<img class="img-fluid" ng-src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/price-top{{$odd?'-active':''}}.png" alt="price">
						<img ng-src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/upper.png" class="category upper" alt="upper" width="50" ng-if="price.category_name.toLowerCase().indexOf('upper') > -1" /> 
						<img ng-src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/lower.png" class="category lower" alt="lower" width="50" ng-if="price.category_name.toLowerCase().indexOf('lower') > -1" /> 
						<img ng-src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/non-wearable.png" class="category non-wearable" width="50" alt="non wearable" ng-if="price.category_name.toLowerCase().indexOf('non') > -1" />
					</div>
					<div class="price-heading mt-2 text-center">
						<h3>{{price.category_name}}</h3>
					</div>
					<div class="price-text mt-3">
						<p ng-repeat="item in price.items"><label class="pull-left">{{item.title}}</label> <strong class="pull-right text-right">{{item.price | currency}}</strong></p>
						<!-- <a class="cust-button mt-3" href="#">CHECK</a> -->
					</div>
				</div>
			</div>
		</div>
		
		<!-- <div class="col-md-12">
			<table class="table table-bordered">
				<tr>
					<th>{{'basic_details.name' | translate}}</th>
					<th>{{'text.type' | translate}}</th>
					<th>{{'text.price' | translate}}</th>
				</tr>
				<tr ng-repeat="price in prices">
					<td>{{price.title}}</td>
					<td>{{price.type}}</td>
					<td>{{price.price | currency}}</td>
				</tr>
			</table>
		</div> -->
	</div>
</section>

<?php endwhile; get_footer(); ?>
