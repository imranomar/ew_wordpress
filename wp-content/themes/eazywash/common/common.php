<?php
	$is_login = is_user_login();
	
	$user = array();
	//print_r($wp_session);die;
	if($is_login)	{
		$user = get_user_session();
        echo '<style>.login-not-required{display:none  !important;}</style>';
        echo '<script>const is_user_logged_in = true; const logged_in_user_id = '.$user['id'].'; </script>';
	} else {
        echo '<style>.login-required{display:none !important;}</style>';
        echo '<script>const is_user_logged_in = false; const logged_in_user_id = -1;</script>';
	}
?>