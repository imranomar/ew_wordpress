<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" ng-app="laundryApp" ng-cloak>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100i,300,400,700,900" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">

	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/angular-wizard.min.css" rel="stylesheet">
	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/style.css" rel="stylesheet">
	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/custom.css" rel="stylesheet">
	

	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/media.css" rel="stylesheet">
	
	<?php require_once('common/common.php'); ?>
	
</head>

<body <?php body_class(); ?> ng-controller="AppController">

<nav class="navbar navbar-expand-lg top-nav">
  <div class="container position-relative">
     <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <i class="fas fa-bars"></i>
	</button>
	
	<ul class="navbar-nav header-nav lang">
        <li><a class="uk" href="javascript:void(0)" ng-click="changeLanguage('en')">uk</a></li>
		<li><a class="dm" href="javascript:void(0)" ng-click="changeLanguage('dm')">dm</a></li>
	</ul>

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
		
		<?php 
			wp_nav_menu(array('menu' => 'Header Menu', 'container' => '', 'menu_class' => 'navbar-nav header-nav'));
		?>  
      
    </div>

    <ul class="navbar-nav float-right search-menu">
	<?php if($is_login == true): ?>
      <li>
	  	<a href="javascipt:void(0)"><?php echo $user['full_name']; ?></a>
		</li>
	<?php endif; ?>
      <li><a class="search" href="javascript:void(0);">search</a></li>
  	 </ul>
      
  </div>
  

</nav>

<?php if(!is_front_page()) { ?>
	<div class="page-heading text-center">
		<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo.png" class="img-fluid mt-5" alt="<?php echo get_bloginfo('name'); ?>">
	</div>
<?php } ?>