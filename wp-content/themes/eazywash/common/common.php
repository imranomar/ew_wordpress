<?php
	$is_login = is_user_login();
	$user = array();
	//print_r($wp_session);die;
	if($is_login)	{
		$user = get_user_session();
        echo '<style>.login-not-required{display:none  !important;}</style>';
        echo '<script>const is_user_logged_in = true; </script>';
	} else {
        echo '<style>.login-required{display:none !important;}</style>';
        echo '<script>const is_user_logged_in = false; </script>';
	}
?>