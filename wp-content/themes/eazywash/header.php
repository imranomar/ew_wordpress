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
global $theme_options;
$favicon = $theme_options['site-favicon']['url'];
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" ng-app="laundryApp" ng-cloak>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="shortcut icon test" href="<?php echo $favicon; ?>" >
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
        <li><a class="uk" href="javascript:void(0)" <?php if($theme_options['first-lang-icon']['url']) { echo "style='background-image: url(".$theme_options['first-lang-icon']['url'].");'"; }?> ng-click="changeLanguage('en')">uk</a></li>
		<li><a class="dm" href="javascript:void(0)" <?php if($theme_options['second-lang-icon']['url']) { echo "style='background-image: url(".$theme_options['second-lang-icon']['url'].");'"; }?> ng-click="changeLanguage('dm')">dm</a></li>
		<li class="dupserchbtn"><a class="search" href="#search">search</a></li>
	</ul>

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
		
		<?php 
			wp_nav_menu(array('menu' => 'Header Menu', 'container' => '', 'menu_class' => 'navbar-nav header-nav'));
		?>  
      
    </div>

    <ul class="navbar-nav float-right search-menu">
	
	<?php if($is_login == true): ?>
     	<li class="menu-item <?php if(strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false){ echo 'current-menu-item'; }?>">
	  		<a href="<?php echo get_permalink( get_page_by_path( 'dashboard' ) ); ?>"><?php echo $user['full_name']; ?>'s {{'menu_link_dashboard' | translate}}</a>
		</li>
		<li class="login-required logout-form-handler menu-item"><a href="javascipt:void(0)">{{'menu_link_logout' | translate}}</a></li>
		<?php endif; ?>
		<li class="login-not-required login-form-handler menu-item"><a href="javascipt:void(0)">{{'menu_link_login' | translate}}</a></li>
      	<li><a class="search" href="#search">search</a></li>
  	 </ul>
	 
	 <div id="search">
		<button type="button" class="close">×</button>
		<form method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
			<input type="search" class="search-field"
					placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>"
					value="<?php echo get_search_query() ?>" name="s"
					title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" autocomplete="off" required />
			<input type="submit" class="cust-button search-submit btn btn-primary"
				value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
		</form>
	</div>
	 
      
  </div>
  

</nav>

<?php if(!is_front_page()) { ?>
	<div class="page-heading text-center" <?php if($theme_options['page-header-bg-img']['url']) { echo "style='background-image: url(".$theme_options['page-header-bg-img']['url'].");'"; }?>>
	<?php if($theme_options['header-logo']['url']) { ?>
		<img class="img-fluid main-logo" src="<?php echo esc_url( $theme_options['header-logo']['url'] ); ?>" alt="<?php echo get_bloginfo('name'); ?>">
	<?php } ?>
	</div>
<?php } ?>