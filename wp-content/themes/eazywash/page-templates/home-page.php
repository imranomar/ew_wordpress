<?php
/* 
Template Name: Home Page 
*/

get_header(); ?>

<section class="slider">

<div class="slider-inner">
  <div class="container">
	  <div class="row pt-5">
		
		<div class="col-sm-5 text-sm-right">
			<img class="float-left img-fluid slide-img col-7 col-sm-12" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/Phones copy.png" alt="Phones">
			<img class="float-left img-fluid d-sm-none col-5" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo.png" alt="Logo">
		</div>

		<div class="col-sm-7 col-lg-6">
			<div class="logo text-center mb-4">
			  <img class="img-fluid d-none d-sm-inline-block" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo.png" alt="Logo">
			</div>
			
			<div class="slide-text">
			  <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam<br/>
				  nonummy nibh euismod ut laoreet dolore magna. </p>
				  <div class="buttons">
					<a href="javascript:void(0)" class="cust-button" data-toggle="modal" data-target="#requestPickupModal">Pickup My Laundry Now</a>
					<a href="#" class="cust-button my-sm-3 float-lg-right bg-red my-lg-0">Download</a>
				  </div>
			</div>

		</div>

	  </div>
  </div>
</div>

</section>

<section class="howitwork">
<div class="container">
  <div class="row">
	  <div class="col-sm-12 mt-5 text-center">
		<h1>How it Works</h1>
		<p>Investigationes demonstraverunt lectores legere me lius quod ii<br/> legunt saepius. Claritas est etiam processus dynamicus</p>

		<div class="row workchain mt-5">
			
		  <div class="install workchain-div">
			<div class="icon">
			  <img class="img-fluid" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/install-icon.png" alt="Install Our App">
			</div>
			<div class="text">
			  <h4>Install Our App</h4>
			  <p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.</p>
			</div>  
		  </div>

		  <div class="order workchain-div">
			<div class="icon">
			  <img class="img-fluid" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/order-icon.png" alt="Install Our App">
			</div>
			<h4>Order</h4>
			<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.</p>
		  </div>

		  <div class="pickup workchain-div">
			<div class="icon">
				<img class="img-fluid" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/pickup-icon.png" alt="Install Our App">
			</div>
			<h4>We Pickup</h4>
			<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.</p>
		  </div>

		  <div class="wash-magic workchain-div">
			<div class="icon">
				<img class="img-fluid" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/wash-icon.png" alt="Install Our App">
			</div>
			<h4>Our Wash Magic</h4>
			<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.</p>
		  </div>

		  <div class="deliver workchain-div">
			<div class="icon">
				<img class="img-fluid" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/deliver-icon.png" alt="Install Our App">
			</div>
			<h4>We Deliver</h4>
			<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.</p>
		  </div>

		</div>

		<a class="mt-5 cust-button w-auto" href="#">See More</a>

	  </div>
  </div>
</div>
</section>

<section class="spoffer">
<div class="container-fluid">
  <div class="row">
	<div class="col-sm-6 p-0">
	  <img class="img-fluid pr-lg-5" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/car.png" alt="Special Offer">
	</div>
	<div class="my-xl-5 my-sm-2 col-sm-6 justify-content-center align-self-center pl-xl-5">
	  <h2>Special Offer Up To<br/> 
		30% This Month!!!</h2>
		<p class="pt-lg-3">Mirum est notare quam littera gothica, quam nunc<br/> putamus parum claram, anteposuerit litterarum<br/> formas humanitatis per seacula quarta decima et</p>
		<a class="mt-xl-3 cust-button" href="#">Check Offer</a>

	</div>
  </div>
</div>
</section>

<section class="downloadapp">
<div class="container">
  <div class="row pt-lg-5 my-lg-5 pt-sm-0 my-sm-0">
	<div class="col-sm-6 my-5 justify-content-center align-self-center">
	  <h2 class="text-center">Download<br>
		App Store or Google Play</h2>
		<p class="mt-4 mb-5 text-center">Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.</p>
		<a class="cust-button app" href="#">App Store</a>
		<a class="cust-button float-lg-right bg-red play mt-3 mt-lg-0" href="#">Google Play</a>
	</div>
	<div class="col-sm-6 position-relative">
	  <img class="dwld-phone img-fluid float-right position-absolute" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/Phones copy.png" alt="Phones">
	</div>
  </div>
</div>
</section>


<?php get_footer(); ?>
