<?php

add_filter( 'wp_setup_nav_menu_item','add_translate_attribute' );
function add_translate_attribute($item) {
	if (strpos($_SERVER['REQUEST_URI'], 'wp-admin') === false)
    	$item->title = "{{&apos;" . $item->title . "&apos; | translate}}"; 

    return $item;
}

/* Custom Functions */

/* Init Session */
add_action('init','register_session');
function register_session(){
    if( !session_id() )
        session_start();
}

/* Check logged in user method */
function is_user_login() {
	$user = get_user_session();
	if(isset($user) && !empty($user)) {
		return true;
	}
	return false;
 }

 /* Get User Session */
 function get_user_session() {
	 return $_SESSION['user'];
 }

 /* Set User Session */
 function set_user_session($user) {
	unset($user['password']);
	
	$_SESSION['user'] = $user;
 } 

 /* Authenticate api calls */
 add_action( 'wp_ajax_nopriv_authenticate_ajax_call', 'authenticate_ajax_call' );
 add_action( 'wp_ajax_authenticate_ajax_call', 'authenticate_ajax_call' );

function authenticate_ajax_call() {
	$result = array();
	$result["Success"] = false;
	$result["Message"] = "Invalid request method";;

	if(!is_user_login()) {
		$result["Message"] = "User is logged out";
		echo json_encode($result); die; 
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$url = null;
		$method = 'POST';
		$data = $_POST;
		unset($data['action']);
		unset($data['sub_action']);

		$user = get_user_session();
		
		switch($_POST["sub_action"]) {
			case "address":
				$method = 'GET';
				$data = array();
				$url = 'customersapi/view/?id='. $user['id'] .'&expand=addresses';
			break;

			case "vaults":
				$method = 'GET';
				$data = array();
				$url = 'customersapi/view/?id='.$user['id'].'&expand=vault';
			break;

			case "vaultById":
				$method = 'GET';
				$vaultId = $_POST['vault_id'];
				$data = array();
				$url = 'vaultapi/view/?id='.$vaultId;
			break;

			case 'create_address':
				$data['customer_id'] = $user['id'];
				if(isset($data['id']) && $data['id'] > 0):
					$method = 'PUT';
					$url = 'addressesapi/update/?id='.$data['id'];
				else:
					$url = 'addressesapi/create';
				endif;
			break;

			case 'create_order':
				$method = 'POST';
				$data['customer_id'] = $user['id'];
				$url = 'ordersapi/createorder';
			break;

			case 'update_user_details':
				$method = 'PUT';
				$url = 'customersapi/update/?id='.$user['id'];
			break;

			case "change_password":
				$method = 'POST';
				$data['customer_id'] = $user['id'];
				$url = 'customersapi/changepassword?customer_id='.$user['id'];
			break;

			case "set_default_address":
				$method = 'POST';
				$data['customer_id'] = $user['id'];				
				$url = 'addressesapi/setdefault?id='.$data['id'];
			break;

			case "delete_address":
				$method = 'DELETE';
				$url = 'addressesapi/delete?id='.$data['id'];
				$data = array();
			break;

			case "set_default_vault":
				$method = 'POST';
				$data['customer_id'] = $user['id'];				
				$url = 'vaultapi/setdefault?id='.$data['id'];
			break;

			case "delete_vault":
				$method = 'DELETE';
				$url = 'vaultapi/delete?id='.$data['id'];
				$data = array();
			break;

			case 'create_tasks':
				$method = 'POST';
				$url = 'tasksapi/createtasks';
			break;
		}
		
		if(!empty($url)) {
			$result = callAPI($method, $url, $data);
		}
	}

	echo json_encode($result); die;
}

/* Api calls */
add_action( 'wp_ajax_nopriv_ajax_call', 'ajax_call' );
add_action( 'wp_ajax_ajax_call', 'ajax_call' );

function ajax_call() {
   $result = array();
   $result["Success"] = false;
   $result["Message"] = "Invalid request method";;

   	if(is_user_login()) {
		$result["Message"] = "User already logged in";
		echo json_encode($result); die; 
	}
	

   	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$url = null;
		$method = 'POST';
		$data = $_POST;
		unset($data['action']);
		unset($data['sub_action']);
	   
	   switch($_POST["sub_action"]) {
			case "login":
				$result = callAPI('GET', 'customersapi/authenticate', $data);
				
				if($result["Success"] == true) {
					$user = array();
					
					$user = callAPI('GET', 'customersapi/view?id='.$result['data'], null);
					
					if($user["Success"] == true) {
						set_user_session($user['data']);
					}
				} else {
					$result['Message'] = 'Invalid Username or Password !!!';
				}
				echo json_encode($result); die;
			break;
			

			case "register":
				if(isset($data['id']) && $data['id'] > 0):
					$method = 'PUT';
					$url = 'customersapi/update/?id='.$data['id'];
				else:
					$url = 'customersapi/create';
				endif;
			break;

			case 'create_address':
				if(isset($data['id']) && $data['id'] > 0):
					$method = 'PUT';
					$url = 'addressesapi/update/?id='.$data['id'];
				else:
					$url = 'addressesapi/create';
				endif;
			break;

			case "vaults":
				$method = 'GET';
				$url = 'customersapi/view/?id='.$data['user_id'].'&expand=vault';
				$data = array();
			break;

			case 'create_order':
				$url = 'ordersapi/createorder';
			break;
			
			case 'create_tasks':
				$method = 'POST';
				$url = 'tasksapi/createtasks';
			break;

			case "forgot_password":
				$method = 'POST';
				$url = 'customersapi/forgotpassword';
			break;

			case "set_default_address":
				$method = 'POST';			
				$url = 'addressesapi/setdefault?id='.$data['id'];
			break;

			case "set_default_vault":
				$method = 'POST';			
				$url = 'vaultapi/setdefault?id='.$data['id'];
			break;
	   }
	   
	   if(!empty($url)) {
		   	$result = callAPI($method, $url, $data);

		   	if($result['Success'] == true) {
				if($data['allow_login'] == true) {
					$user = array();
					
					$user = callAPI('GET', 'customersapi/view?id='.$result['data']['id'], null);
					
					if($user["Success"] == true) {
						set_user_session($user['data']);
					}
				}
				if(isset($result['data'])) {
					unset($result['data']['api_token']);
					unset($result['data']['password']);
				}
			}
	   }
   }

   echo json_encode($result); die;
}

/* Order Creation Data */
add_action( 'wp_ajax_nopriv_order_creation_data', 'order_creation_data' );
add_action( 'wp_ajax_order_creation_data', 'order_creation_data' );

function order_creation_data() {
	$result = array();
	$result["Success"] = false;
	$result["Message"] = NULL;
	$result["Message"] = "Invalid request method";

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$url = null;
		$data = array();
		$api_result = array();

		$customer_id = $_POST['customer_id'];

		$isUserLoggedIn = is_user_login();

		/* Calling Cities api */
		$url = 'citiesapi';
		$method = 'GET';
		$api_result = callAPI($method, $url, $data);

		if($api_result["Success"] == true && isset($api_result['data'])) {
			$result['cities'] = $api_result['data'];
		}


		/* Calling Options api */
		$url = 'optionsapi';
		$method = 'GET';
		$api_result = callAPI($method, $url, $data);

		if($api_result["Success"] == true && isset($api_result['data'])) {
			$result['options'] = $api_result['data'];
		}

		/* Calling slotspricingapi api */
		$url = 'slotspricingapi';
		$method = 'GET';
		$api_result = callAPI($method, $url, $data);

		if($api_result["Success"] == true && isset($api_result['data'])) {
			$result['timeslots'] = $api_result['data'];
		}

		if($isUserLoggedIn == true || $customer_id > 0) {
			$user = get_user_session();

			if($customer_id <= 0)
				$customer_id = $user['id'];

			/* Calling customer api for getting addresses api */
			$url = 'customersapi/view/?id='. $customer_id .'&expand=addresses,vault';
			$method = 'GET';
			$api_result = callAPI($method, $url, $data);

			if($api_result["Success"] == true && isset($api_result['data']['addresses'])) {
				$result['addresses'] = $api_result['data']['addresses'];
			}

			if($api_result["Success"] == true && isset($api_result['data']['vault'])) {
				$result['vaults'] = $api_result['data']['vault'];
			}
		}

		$result["Success"] = true;
		$result["Message"] = null;
	} 
	echo json_encode($result); die;
}

/* Dashboard Creation Data */
add_action( 'wp_ajax_nopriv_dashboard_data', 'dashboard_data' );
add_action( 'wp_ajax_dashboard_data', 'dashboard_data' );

function dashboard_data() {
	$result = array();
	$result["Success"] = false;
	$result["Message"] = NULL;
	$result["Message"] = "Invalid request method";


	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(!is_user_login()) {
			$result["Message"] = "User is logged out";
			echo json_encode($result); die; 
		}

		$user = get_user_session();

		$url = null;
		$data = array();
		$api_result = array();

		/* Calling Cities api */
		$url = 'citiesapi';
		$method = 'GET';
		$api_result = callAPI($method, $url, $data);

		if($api_result["Success"] == true && isset($api_result['data'])) {
			$result['cities'] = $api_result['data'];
		}


		/* Calling customer api for getting addresses and vaults api */
		$url = 'customersapi/view/?id='. $user['id'] .'&expand=addresses,vault';
		$method = 'GET';
		$api_result = callAPI($method, $url, $data);

		if($api_result["Success"] == true && isset($api_result['data'])) {
			$result['user_details'] = $api_result['data'];
			unset($result['user_details']['password']);
			unset($result['user_details']['addresses']);
			unset($result['user_details']['vault']);
		}

		if($api_result["Success"] == true && isset($api_result['data']['addresses'])) {
			$result['addresses'] = $api_result['data']['addresses'];
		}


		if($api_result["Success"] == true && isset($api_result['data']['vault'])) {
			$result['vaults'] = $api_result['data']['vault'];
		}

		$result["Success"] = true;
		$result["Message"] = null;
	} 
	echo json_encode($result); die;
}

/* Loggout Method */
add_action( 'wp_ajax_nopriv_logout_method', 'logout_method' );
add_action( 'wp_ajax_logout_method', 'logout_method' );

function logout_method() {
	$result = array();
	$result["Success"] = false;
	$result["Message"] = NULL;
	$result["Message"] = "Invalid request method";


	if(!is_user_login()) {
		$result["Message"] = "User already logged out";
		echo json_encode($result); die; 
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		unset($_SESSION['user']);

		$result["Success"] = true;
		$result["Message"] = "Logged out succesfully";
	} 
	echo json_encode($result); die;
}

/* Common Method for Calling API's */
function callAPI($method, $parital_url, $data) {
	
	$valid_status_codes = [200, 201];

	$response = array();
	$response["Success"] = false;
	$response["Message"] = "Something went wrong !!!";
			

	$baseUrl = 'http://localhost/advanced/backend/web/';

	$api = $baseUrl.$parital_url;

	$curl = curl_init();

	switch ($method){
	   case "POST":
		  curl_setopt($curl, CURLOPT_POST, 1);
		  if ($data)
			 curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
		  break;
	   case "PUT":
		  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
		  if ($data)
			 curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));			 					
		  break;
		case "DELETE":
		  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		  if ($data)
			 curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));			 					
		  break;
	   default:
		  if ($data)
			$api = sprintf("%s?%s", $api, http_build_query($data));
	}

	// OPTIONS:
	curl_setopt($curl, CURLOPT_URL, $api);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	   //'APIKEY: 111111111111111111111',
	   'Content-Type: application/x-www-form-urlencoded',
	));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
 
	// EXECUTE:
	$result = curl_exec($curl);
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);
	$isValidJson = isJson($result);
	//echo 'ok'.$isValidJson;die;
	if($isValidJson) {
		$final_result = json_decode($result, true);
		
		if (in_array($httpcode, $valid_status_codes)) {
			if(isset($final_result['Success']) && $final_result['Success'] == false) {
				$response["data"] = $final_result;
				$response["Message"] = $final_result["Message"];
				$response["Success"] = false;
			} else {
				$response["data"] = $final_result;
				$response["Message"] = null;
				$response["Success"] = true;
			}
		} else {
			$response["data"] = $final_result;
			$response["Message"] = !empty($final_result[0]['message'])?$final_result[0]['message']: $response["Message"];
		}
	} else if($result === 1 || $method == "DELETE") {
		$response["Success"] = true;
		$response["data"] = $result;
		$response["Message"] = null;
	}

	return $response;
 }

 function isJson($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}

 function pr($data) {
	echo '<pre>';print_r($data);echo '</pre>';die;
}
?>