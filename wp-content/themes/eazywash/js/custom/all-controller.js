// App Controller
app.controller('AppController', function ($scope, $rootScope, $translate, CommonService) {

	$scope.changeLanguage = function (lang) {
		$rootScope.SelectedLang = lang;
		CommonService.storeLanguageLocal(lang);
		$translate.use(lang);
	}
});

 //Login of Controller
 app.controller('LoginCtrl', function($scope,$location,$http, $httpParamSerializer, appInfo, updateFCMToken){
	$scope.loading = false;
	$scope.field = 'email';
 	$scope.logindata = {
		email: '',
		password: ''
	};
	$scope.err = false;
	$scope.errorMessage = null;
 	$scope.required = false;
	$scope.checkbox = true;

	$scope.loginsubmit = function () {
		$scope.err = false;
 		$scope.required = false;
		
		let email= $scope.logindata.email;
		let password= $scope.logindata.password;

		if(!email || !password){
			if(!email){
				$scope.field = 'please enter valid email address';
			}else
			if(!password){
				$scope.field = 'please enter password field';
			}
			$scope.required = true;
			return;
		}
		$scope.loading = true;

		var req = {
			method: 'POST',
			url: ajaxUrl,
			data: $httpParamSerializer({
				email: email,
				password: password,
				action: "ajax_call",
				sub_action: "login"
			}),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		};

		$http(req)
			.then(function(response){
				console.log(response);
				$scope.loading = false;
				var res = response.data;
				
				if(res.Success == true && res.data != 0) {
					localStorage.setItem('laundryUser', res.data);
					let date = new Date();
					updateFCMToken.test();
					if($scope.checkbox == true){
						localStorage.setItem('rememberMe', 'y');
						let date1 = new Date(date.setDate(date.getDate()+10)).toUTCString();
						document.cookie = 'laundryCookie=y; expires=' + date1;
					}else{
						localStorage.removeItem('rememberMe');
						let date1 = new Date(date.setHours(date.getHours()+1)).toUTCString();
						document.cookie = 'laundryCookie=y; expires=' + date1;
					}
					window.location.reload();
				}
				else
				{
					$scope.err = true;
					$scope.errorMessage = "Invalid login credentials";
				}
			}).catch(function(err){
				$scope.loading = false;
				console.log("error");
				console.log(err);
			});
	}		
});

 //Logout of Controller
 app.controller('LogoutCtrl', function($scope, $http, $httpParamSerializer){
	$scope.loading = false;

	$scope.err = false;
	$scope.errorMessage = null;

	$scope.logout = function () {
		$scope.err = false;
		
		$scope.loading = true;

		var req = {
			method: 'POST',
			url: ajaxUrl,
			data: $httpParamSerializer({
				action: "logout_method"
			}),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		};

		$http(req)
			.then(function(response){
				console.log(response);
				$scope.loading = false;
				var res = response.data;
				
				if(res.Success == true) {
					let date = new Date().toUTCString();
					document.cookie = 'laundryCookie=y; expires=' + date;

					localStorage.removeItem('laundryUser');
					localStorage.removeItem('rememberMe');

					window.location.reload();
				}
				else
				{
					$scope.err = true;
					$scope.errorMessage = res.Message;
				}
			}).catch(function(err){
				$scope.loading = false;
				console.log("error");
				console.log(err);
			});
	}		
 });


 // Signup of Controller
 app.controller('SignupCtrl',function($scope, $httpParamSerializer,$http, updateFCMToken) {
	$scope.loading = false;

	$scope.err = false;
	$scope.errorMessage = null;

	$scope.signupdata = {
		name: null,
		email: null,
		password: null,
		phone: null,
		sex: '1'
	};
	
	$scope.signupsubmitform = function(){
		$scope.loading = true;
		let data = {
			full_name: $scope.signupdata.name,
			email: $scope.signupdata.email,
			password: $scope.signupdata.password,
			phone: $scope.signupdata.phone,
			sex: $scope.signupdata.sex,
			action: "ajax_call",
			sub_action: "register",
			allow_login: true,
		};
		let req = {
			method: 'POST',
			url: ajaxUrl,
			data: $httpParamSerializer(data),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}

		$scope.err = '';
		$scope.loading = true;
		$http(req)
			.then(function(response){
				$scope.loading = false;
				
				var res = response.data;
				console.log(res.data);
				
				if(res.Success == true) {
					let date = new Date();
					localStorage.setItem('laundryUser', res.data.id);
					updateFCMToken.test();

					let date1 = new Date(date.setHours(date.getHours()+1)).toUTCString();
					document.cookie = 'laundryCookie=y; expires=' + date1;

					window.location.reload();
				} else
				{
					$scope.err = true;
					$scope.errorMessage = res.Message;
				}
			}).catch(function(error){
				$scope.loading = false;
				let err = error.data;
				$scope.err = false;
				$scope.errorMessage = err[0].message;
			});
	}
 });


 // Forget password of Controller

 app.controller('ForgetCtrl',function($scope) {

 	$scope.forgetdata1 = [];

 	$scope.sendemail = function(){
 		console.log($scope.forgetdata1);
 	}
 });

 // Dashboard of Controller

 app.controller('DashboardCtrl',function($scope,$location) {

	jQuery('.navbar-fixed').show();

 	$scope.menuopen = function(){
 		//$location.path("/menu");
	}

	$scope.closemenu = function(){
		angular.element('.Menu').remove();
	}
	
 });


 // Menu of Controller

 app.controller('MenuCtrl',function($scope,$location) {

	$scope.signout = function(){
		let date = new Date().toUTCString();
		document.cookie = 'laundryCookie=y; expires=' + date;
		localStorage.removeItem('laundryUser');
		localStorage.removeItem('rememberMe');
		$location.path('/login');
	}

 	$scope.closemenu = function () {
		 $location.path("/dashboard");
		 console.log("MenuCtrl");
 	}

 });


 // pricing of Controller

 app.controller('PricingCtrl',function($scope) {
 	// body...
 });



 // Aboutus of Controller

 app.controller('AboutusCtrl',function($scope) {
 	// body...
 });


 // Frequently asked questions of Controller

 app.controller('FaqsCtrl',function($scope) {
 	
 	  $scope.questions = [
 	  	{
 	  	'question':'How do I brighten my dingy white clothes and linens?','decription':'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English.'
 	  	},
 	  	{
 	  	'question':'How do I remove set-in stains that have been washed and dried?','decription':'washed and dried? Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for '
 	  	},
 	  	{
 	  	'question':'How can I prevent fading of my dark clothes?','decription':'fading of my dark clothes? There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable.'
 	  	},
 	  	{
 	  	'question':'How do I remove dye transfer from clothes?','decription':'dye transfer from clothes? Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for'
 	  	},
 	  	{
 	  	'question':'How do I remove yellow armpit stains?','decription':'yellow armpit stains? Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for'
 	  	},
 	  	{
 	  	'question':'How do I remove ink stains from clothes and leather?','decription':'ink stains from clothes and leather? Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for'
 	  	},
 	  	{
 	  	'question':'Why wont my washer/dryer work?','decription':'washer/dryer work? Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for'
 	    }
 	   ];

		$scope.toggleGroup = function(group) {

			if ($scope.isGroupShown(group)) {
			$scope.shownGroup = null;
			} 
			else {
			$scope.shownGroup = group;
			}

		};

		$scope.isGroupShown = function(group) {
			return $scope.shownGroup === group;
		};
 });



 // My details Page of Controller

 app.controller('MydetailsCtrl',function($scope,$location,$http, appInfo, $httpParamSerializer) {

	 // body...
 	    $scope.loading = false;
        let x = localStorage.getItem('laundryUser');
		$scope.userdata = {};
		$scope.asteriskPassword  = '';
		$scope.paymentDetails = [];
		$scope.cityids = [];
   		getPayment();
		getAddress();
		 
		function getPassword(){
			let p = $scope.userdata.password.split('').map(()=>{
				return '*';
			})
			$scope.asteriskPassword = p.join('');
		}
     	
        jQuery(".edit-btn").click(function(){
            jQuery(this).parent().css("display","none");
        	jQuery(this).parent().siblings(".clk-fade-out").css("display","none");
        	jQuery(this).parent().siblings(".clk-fade-in").css("display","block");
        	jQuery(this).parent().siblings(".whn-clk-edt").css("display","block");
		});
		
        jQuery(".whn-clk-edt").click(function(){
              jQuery(this).css("display","none");
              jQuery(this).siblings(".clk-fade-out").css("display","block");
              jQuery(this).siblings(".clk-fade-in").css("display","none");
              jQuery(this).siblings(".sib").css("display","block");
		});
		

		$scope.onSavePersonDetail = function(){
			let data = {
				full_name: $scope.userdata.full_name,
				email: $scope.userdata.email,
				password: $scope.userdata.password,
				phone: $scope.userdata.phone
			};	

			let req = {
				method: 'PUT',
				url: appInfo.url+'customersapi/update/?id='+x,
				data: $httpParamSerializer(data),
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			}
			$scope.loading = true;
			$http(req)
			.then(function(res){
				$scope.loading = false;
				console.log(res);
				$scope.userdata.password = res.data.password;
				getPassword();
			 }).catch(function(err){
				$scope.loading = false;
				console.log(err);
			 });
		}

     	function getAddress(){
	 	    $http.get(appInfo.url+'customersapi/view/?id='+x+'&expand=addresses')
	       .then(function(res){
	        //   console.log(res.data);
			$scope.userdata = res.data;
			for(let value of  $scope.userdata.addresses){
				getcity(value.city_id);
			}
			getPassword();
	       }).catch(function(err){
	             console.log(err);
	       });
	   }

	   function getPayment(){
			$http.get(appInfo.url+'customersapi/view/?id='+x+'&expand=payments')
			.then(function(res){
				$scope.loading = false;
				// console.log(res.data);
				$scope.userdata.payments = res.data.payments;
				for(let value of  $scope.userdata.payments){
					getVault(value.vault_id);
				}
			}).catch(function(err){
				$scope.loading = false;
				console.log(err);
			});
	   }
	   
       function getVault(id){
   	 	    $scope.loading = true;
	        $http.get(appInfo.url+'vaultapi/view/?id='+id)
	        .then(function(res){
	        	$scope.loading = false;
	        	// console.log(res.data);
				$scope.paymentDetails.push(res.data);
	        }).catch(function(err){
	        	$scope.loading = false;
                console.log(err);
	        });
       }

        function getcity(city){
          $http.get(appInfo.url+'citiesapi/view?id='+city)
	          .then(function(res){
                  console.log(res.data);
                  $scope.cityids.push(res.data);
	          }).catch(function(err){
	          	   console.log(err);
	          })
		}
		

      

 });


// Load Notification Page of Controller

app.controller('NotificationCtrl',function ($scope) {
		$scope.notificationtoday = [
	 	  	{
	 	  	'todayname':'LAUNDRY PICKUP TODAY','timing':'AT 8:00 AM','date':'Thu 17th August 2017'
	 	  	},
	 	  	{
	 	  	'todayname':'LAUNDRY PICKUP TODAY','timing':'AT 8:00 AM','date':'Thu 17th August 2017'
	 	  	},
	 	  	{
	 	  	'todayname':'LAUNDRY PICKUP TODAY','timing':'AT 8:00 AM','date':'Thu 17th August 2017'
	 	  	},
	 	  	{
	 	  	'todayname':'LAUNDRY PICKUP TODAY','timing':'AT 8:00 AM','date':'Thu 17th August 2017'
	 	  	},
	 	  	{
	 	  	'todayname':'LAUNDRY PICKUP TODAY','timing':'AT 3:00 AM','date':'Thu 17th August 2017'
	 	  	}
 	   ];		

 	   $scope.laundrypickup = [
	 	  	{
	 	  		'todayname':'LAUNDRY PICKUP','timing':'IN 1 HOUR!'
	 	  	},
	 	  	{
	 	  		'todayname':'LAUNDRY PICKUP','timing':'IN 1 HOUR!'
	 	  	},
	 	  	{
	 	  		'todayname':'LAUNDRY PICKUP','timing':'IN 1 HOUR!'
	 	  	}
	 	];
});


// Load addresses page of controller 

app.controller('AddressesCtrl',function($scope,$http, appInfo, $location, $httpParamSerializer){
	$scope.loading = false;
	let x = localStorage.getItem('laundryUser');
	$scope.userdata = {};
	$scope.cityids = [];
	$scope.cityData = [];
	getAddress();
	getAllcity();

	

	jQuery('body').on('click', '.magic-edit', function(){
		jQuery(this).css("display","none");
		jQuery(this).siblings(".magic-check").css("display","block");
		jQuery(this).siblings(".magic-input").css("display","block");
		jQuery(this).siblings(".main-data").css("display","none");
	
	});

	jQuery('body').on('click', '.magic-check', function(){
		jQuery(this).css("display","none");
		jQuery(this).siblings(".magic-edit").css("display","block");
		jQuery(this).siblings(".magic-input").css("display","none");
		jQuery(this).siblings(".main-data").css("display","block");
	});

	jQuery('body').on('click', '.magic-check', function(){
		let bodyfont = jQuery(this).parents('.bodyfont');

		var streetname = bodyfont.find('.xxx-control[name="streetname"]').val();
		var pobox = bodyfont.find('.xxx-control[name="pobox"]').val();
		var floor = bodyfont.find('.xxx-control[name="floor"]').val();
		var city = bodyfont.find('.xxx-control[name="city"]').val();
		var id = bodyfont.find('.id[name="id"]').val();
		var index = bodyfont.find('.index[name="index"]').val();

		let data = {
			street_name: streetname,
			floor: floor,
			pobox: pobox,
			city_id: city
		};
		
		let req = {
			method: 'PUT',
			url: appInfo.url+'addressesapi/update?id='+id,
			data: $httpParamSerializer(data),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}
		$scope.loading = true;
		$http(req)
			.then(function(res){
				$scope.loading = false;
				console.log(res.data);
				console.log("address");
				$scope.userdata.addresses[index] = res.data;
			}).catch(function(err){
				$scope.loading = false;
				   console.log(err);
			})

	});

	

$scope.onDelteAddress = function (data) {
		let req = {
			method: 'DELETE',
			url: appInfo.url+'addressesapi/delete?id='+data.id,
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}
		$scope.err = '';
		$scope.loading = true;
		$http(req)
			.then(function(res){
				$scope.loading = false;
				console.log(res.data);
				getAddress();
			}).catch(function(error){
				$scope.loading = false;
				let err = error.data;
				$scope.err = err[0].message;
				// console.log(error);
			})
	}


	function getAddress(){
		$scope.loading = true;
		$http.get(appInfo.url+'customersapi/view/?id='+x+'&expand=addresses')
		.then(function(res){
			$scope.loading = false;
			console.log(res.data.id);
			$scope.getAddressId = res.data.id;

			$scope.userdata = res.data;
			for(let value of  $scope.userdata.addresses){
				getcity(value.city_id);
			}
		}).catch(function(err){
			$scope.loading = false;
			console.log(err);
		});
	}
	  
	function getcity(city){
		$http.get(appInfo.url+'citiesapi/view?id='+city)
			.then(function(res){
				console.log(res.data);
				$scope.cityids.push(res.data);
			}).catch(function(err){
				   console.log(err);
			})
	  }

	  function getAllcity(){
		$http.get(appInfo.url+'citiesapi')
			.then(function(res){
				$scope.cityData = res.data;
				console.log($scope.cityData);
			}).catch(function(err){
				   console.log(err);
			})
	  }



});


// Load Controller of DeliverydateCtrl

app.controller('DeliverydateCtrl',function($scope) {
	// body...
})


// Load Controller of OrdersummaryCtrl

app.controller('OrdersummaryCtrl',function($scope, $http, $timeout, $httpParamSerializer, $location, updateFCMToken, WizardHandler){
	$scope.showLoading = true;
	$scope.loading = false;

	let userId = localStorage.getItem('laundryUser');

	$scope.isUserLoggedIn = is_user_logged_in;
	$scope.orderCreationDone = false;

	$scope.lastStepNumber = $scope.isUserLoggedIn?5:8;

	$scope.showAddressDetailStep = false;
	$scope.showPaymentDetailStep = false;

	$scope.cityData = [];
	$scope.AllAddresses = [];
	$scope.AllPaymets = [];
	$scope.optionsData = null;

	$scope.getAddress = null;
	$scope.getPayment = null;
	$scope.TimeSlots = [];

	$scope.pickupDateList = [];
	$scope.showAllpickupDateList = false;

	$scope.deliveryDateList = [];
	$scope.showAlldeliveryDateList = false;

	$scope.Wizard = null;
	$scope.stepValidation = true;

	$scope.err = false;
	$scope.errorMessage = null;

	$scope.userErr = false;
	$scope.userErrorMessage = null;

	$scope.addressErr = false;
	$scope.addressErrorMessage = null;
	
	$scope.Steps = {
		pickup_date: "PickupDate",
		pickup_time: "PickupTime",
		drop_date: "DropDate",
		drop_time: "DropTime",
		user_detail: "UserDetail",
		address_detail: "AddressDetail",
		payment_detail: "PaymentDetail",
		order_summary: "OrderSummary"
	};
	
	//  localstorage keys
	$scope.localData = {
		pickupDate : {},
		pickupTime: {},
		deliveryDate: {},
		deliveryTime: {},
		userDetails: {
			id: null,
			full_name: null,
			email: null,
			password: null,
			phone: null
		},
		addressDetails: {
			id: null,
			street_name: null,
			floor: null,
			pobox: null,
			unit_number: null,
			city_id: null
		},
		paymentDetails: {}
	};

	var days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
	var months = new Array();
	months[0] = "January";
	months[1] = "February";
	months[2] = "March";
	months[3] = "April";
	months[4] = "May";
	months[5] = "June";
	months[6] = "July";
	months[7] = "August";
	months[8] = "September";
	months[9] = "October";
	months[10] = "November";
	months[11] = "December";


	initializeOrderCreation();

	function initializeOrderCreation() 
	{
		let req = {
			method: 'POST',
			url: ajaxUrl,
			data: $httpParamSerializer({action: "order_creation_data"}),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		};
		
		$http(req)
		.then(function(response) {
			var res = response.data;
			console.log(res);

			if(res.Success == true) {
				if(res.cities && res.cities.length > 0)
					$scope.cityData = res.cities;

				if(res.options && res.options.length > 0)
					$scope.optionsData = res.options[0];

				if(res.timeslots && res.timeslots.length > 0)
					$scope.TimeSlots = res.timeslots;
				
				if($scope.isUserLoggedIn)
				{
					if(res.addresses && res.addresses.length > 0) {
						$scope.AllAddresses = res.addresses;
						$scope.getAddress = $scope.AllAddresses[0];
					} else {
						$scope.showAddressDetailStep = true;
						$scope.lastStepNumber += 1;
					}

					if(res.vaults && res.vaults.length > 0) 
					{
						$scope.AllPaymets = res.vaults;
						$scope.getPayment = $scope.AllPaymets[0];
					} else {
						$scope.showPaymentDetailStep = true;
						$scope.lastStepNumber += 1;
					}
				}
			}
			$scope.showLoading = false;
		}).catch(function(err){
			$scope.showLoading = false;
			console.log(err);
		});
	}

	$scope.initializeWizard = function()
	{
		functionForPickupDate();
		
		$scope.Wizard = WizardHandler.wizard("requestPickupWizard");

		if(getLocalStorageData()) {
			jQuery("#requestPickupModal").modal('show');

			$scope.localData = getLocalStorageData();

			if(!$scope.isUserLoggedIn)
			{
				$scope.getAddress = $scope.localData.addressDetails;
				$scope.getPayment = $scope.localData.paymentDetails;
			}

			var goToStep = 0;

			if(!$scope.isUserLoggedIn && getObjectLength($scope.localData.paymentDetails) != 0)
			{
				goToStep = 7;
			}
			else if(!$scope.isUserLoggedIn && getObjectLength($scope.localData.addressDetails) > 0)
			{
				goToStep = 6;
			} 
			else if(!$scope.isUserLoggedIn && getObjectLength($scope.localData.userDetails) > 0)
			{
				goToStep = 5;
			}
			else if(getObjectLength($scope.localData.deliveryTime) != 0)
			{
				goToStep = 4;
			} 
			else if(getObjectLength($scope.localData.deliveryDate) != 0)
			{
				goToStep = 3;
			}
			else if(getObjectLength($scope.localData.pickupTime) != 0)
			{
				goToStep = 2;
			} 
			else if(getObjectLength($scope.localData.pickupDate) != 0)
			{
				goToStep = 1;
			} 

			if ($scope.Wizard) {
				$scope.Wizard.goTo(goToStep);
			}
		}
	}

	$scope.validateStep = function() {
		if($scope.stepValidation == true) 
		{
			var step = $scope.Wizard.currentStep();
			var stepTitle = step.wzHeadingTitle;

			return validationByStepTitle();
		}
		return true;
	};
	

	$scope.noValidation = function() { 
		$scope.stepValidation = false;
	}

	$scope.checkValidation = function() { 
		$scope.stepValidation = true;
	}

	$scope.$on('wizard:stepChanged',function(event, args) {
		var stepTitle = args.step.wzHeadingTitle;
		
		console.log(stepTitle);

		switch(stepTitle) {
			case $scope.Steps.pickup_date:
				$scope.showAllpickupDateList = false;
			break;

			case $scope.Steps.pickup_time:
				console.log('second');
			break;

			case $scope.Steps.drop_date:
				$scope.showAlldeliveryDateList = false;
				functionForDropDate();
			break;

			case $scope.Steps.payment_detail:
				functionForPaymentDetail();
				break;
		}
	});


	// wizard one start
	function functionForPickupDate(){
		debugger;
		if($scope.optionsData == null)
			return;
		
		let array = [];	
		let date  = new Date();

		let holidays = $scope.optionsData.holidays.split(',');
		let length = $scope.optionsData.holidays.split(',').length;
		if($scope.optionsData.weekend){
			length += 1;
		}
		for(var i = 0; i < 16 + length ; i++){
			let name = '';
			let price = '';
			date  = new Date();
			let d = new Date(date.setDate(date.getDate()+i));
			if(d.getDate() == new Date().getDate()){
				// if  day is tomorrow
				name = 'Today';
				price = $scope.optionsData.same_day_pickup_price;
			}else if(d.getDate() == new Date().getDate()+1){
				// if day is day after 
				name = 'Tomorrow';
			}
			else
			{ 
				name = days[d.getDay()];
			}
			
			array.push({
				date: d,
				name: name,
				price: price,
				shortDate: d.getDate()+'th '+months[d.getMonth()]
			});
		}
	
		for(var i = 0; i < array.length; i++){
			for(let j = 0; j < holidays.length; j++){
				if(array[i]){
					if(array[i].date.toLocaleDateString() == new Date(holidays[j] * 1000).toLocaleDateString()){
						array.splice(i, 1);
					}	
				}
			}
			
			if($scope.optionsData.weekend){
				if(array[i]){
					if(days.indexOf($scope.optionsData.weekend) > -1){
						if(array[i].date.getDay() == days.indexOf($scope.optionsData.weekend)){
							array.splice(i, 1);
						}
					}
				}
			}	
		}
		array.length = 15;
		$scope.pickupDateList = array;
		console.log($scope.pickupDateList);

	}

	$scope.loadMorePickupDates = function(){
		$scope.showAllpickupDateList = true;
	}
	// wizard one closed


	// wizard three  start
	function functionForDropDate() {
		if($scope.optionsData == null)
			return;

		let array = [];	
		let date  = new Date(getLocalStorageData().pickupDate.date);
		let pickupD = new Date(getLocalStorageData().pickupDate.date);
    
		let holidays = $scope.optionsData.holidays.split(',');
		let length = $scope.optionsData.holidays.split(',').length;
		if($scope.optionsData.weekend){
			length += 1;
		}
		for(var i = 0; i < 16 + length ; i++){
			let name = '';
			let price = '';
			let d = new Date(date.setDate(date.getDate()+1));
			if(d.getDate() == new Date().getDate()+1){
				// if day is day after 
				name = 'Tomorrow';
				price = $scope.optionsData.next_day_delivery_price;
			}else
			if(d.getDate() == pickupD.getDate()+1){
				// if  day is tomorrow
				// name = 'day after';
				name = 'next day deliever';
				price = $scope.optionsData.next_day_delivery_price;
			}
			
			array.push({
				date: d,
				name: name,
				price: price,
				shortDate: d.getDate()+'th '+days[d.getDay()]
			});
		}
		for(var i = 0; i < array.length; i++){

			for(let j = 0; j < holidays.length; j++){
				if(array[i]){
					if(array[i].date.toLocaleDateString() == new Date(holidays[j] * 1000).toLocaleDateString()){
						array.splice(i, 1);
					}	
				}
			}
			if(array[i]){
				if($scope.optionsData.weekend){
					if(days.indexOf($scope.optionsData.weekend) > -1){
						if(array[i].date.getDay() == days.indexOf($scope.optionsData.weekend)){
							array.splice(i, 1);
						}
					}
				}	
			}
		}
		array.length = 15;
		$scope.deliveryDateList = array;
	}

	$scope.loadMoreDeliveryDates = function(){
		$scope.showAlldeliveryDateList = true;
	}
	// wizard three closed

	// wizard sixth start
	function functionForPaymentDetail() {
		var doc = document.getElementById("paymentIframe").contentWindow.document;
		doc.open();
		doc.write(
			'Loading... \
			\
						<FORM ACTION="https://payment.architrade.com/paymentweb/start.action" METHOD="POST" CHARSET="UTF -8"> \
							<INPUT TYPE="hidden" NAME="accepturl" VALUE="http://localhost/advanced/backend/web/vault/createvault"> \
							<INPUT TYPE="hidden" NAME="cancelurl" VALUE="http://localhost/advanced/backend/web/vault/createvault"> \
							<INPUT TYPE="hidden" NAME="callbackurl" VALUE=""> \
							<INPUT TYPE="hidden" NAME="amount" VALUE="1"> \
							<INPUT TYPE="hidden" NAME="currency" VALUE="578"> \
							<INPUT TYPE="hidden" NAME="merchant" VALUE="90246240"> \
							<INPUT TYPE="hidden" NAME="orderid" id="orderid" VALUE="' + (!$scope.isUserLoggedIn?$scope.localData.userDetails.id:userId) + '"> \
							<INPUT TYPE="hidden" NAME="lang" VALUE="EN"> \
							<INPUT TYPE="hidden" NAME="preauth" VALUE="1"> \
							<INPUT TYPE="hidden" NAME="test" VALUE="1"> \
							<INPUT TYPE="hidden" NAME="decorator" VALUE="responsive" /> \
							<INPUT type="Submit" id="submit" name="submit" style="visibility:hidden"  value="TICKET DEMO"> \
						</FORM> \
						<script src="js/jquery-3.3.1.slim.min.js"></script> \
						<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> \
						<script>$("#submit").click();</script>'
		);
		doc.close();
	}
	// wizard sixth closed
	

	/* Common Functions */

	function validationByStepTitle(stepTitle) 
	{
		if(stepTitle == $scope.Steps.pickup_date && getObjectLength($scope.localData.pickupDate) == 0)
		{
			return false;
		} 
		else if(stepTitle == $scope.Steps.pickup_time && getObjectLength($scope.localData.pickupTime) == 0) 
		{
			return false;
		} 
		else if(stepTitle == $scope.Steps.drop_date && getObjectLength($scope.localData.deliveryDate) == 0)
		{
			return false;
		} 
		else if(stepTitle == $scope.Steps.drop_time && getObjectLength($scope.localData.deliveryTime) == 0) 
		{
			return false;
		} 
		else if(stepTitle == $scope.Steps.user_detail)
		{
			if(getObjectLength($scope.localData.userDetails) == 0 || ((!$scope.localData.userDetails.full_name || $scope.localData.userDetails.full_name == "") ||
					(!$scope.localData.userDetails.email || $scope.localData.userDetails.email == "") ||
						(!$scope.localData.userDetails.password || $scope.localData.userDetails.password == "") ||
							(!$scope.localData.userDetails.phone || $scope.localData.userDetails.phone == ""))){
				$scope.userErr = true;
				$scope.userErrorMessage = "Please fill all fields";
				return false;
			}
		} 
		else if(stepTitle == $scope.Steps.address_detail) 
		{
			if(getObjectLength($scope.localData.addressDetails) == 0 || ((!$scope.localData.addressDetails.street_name || $scope.localData.addressDetails.street_name == "") ||
					(!$scope.localData.addressDetails.floor || $scope.localData.addressDetails.floor == "") ||
						(!$scope.localData.addressDetails.pobox || $scope.localData.addressDetails.pobox == "") ||
							(!$scope.localData.addressDetails.unit_number || $scope.localData.addressDetails.unit_number == "") ||
								(!$scope.localData.addressDetails.city_id || $scope.localData.addressDetails.city_id == ""))){
				$scope.addressErr = true;
				$scope.addressErrorMessage = "Please fill all fields";
				return false;
			}
		}

		return true;
	}

	function getUserPaymentDetails() {
		let req = {
			method: 'POST',
			url: ajaxUrl,
			data: $httpParamSerializer({action: !$scope.isUserLoggedIn?"ajax_call":"authenticate_ajax_call", sub_action: "vaults", user_id: !$scope.isUserLoggedIn?$scope.localData.userDetails.id: -1}),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		};

		$http(req)
		.then(function(response){
			var res = response.data;
			console.log(res);

			if(res.Success == true) {
				var data = res.data;
				if(data && data.vault && data.vault.length > 0) {
					
					$scope.AllPaymets = data.vault;
					$scope.getPayment = $scope.AllPaymets[0];

					if(!$scope.isUserLoggedIn) {
						$scope.localData.paymentDetails = $scope.getPayment;

						// Save local storage
						let obj = JSON.stringify($scope.localData);
						saveLocalData(obj);
					}
					//getVault($scope.getPayment.vault_id);
				}
			}
		}).catch(function(err){
			console.log(err);
		});
	}

	function getVault(id) {
		$scope.loading = true;

		let req = {
			method: 'POST',
			url: ajaxUrl,
			data: $httpParamSerializer({action: "authenticate_ajax_call", sub_action: "vaultById", vault_id: id}),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		};
		
		$http(req)
		.then(function(response) {
			$scope.loading = false;
			var res = response.data;
			console.log(res.data);
			if(res.Success == true) {
				$scope.getPayment= res.data;
			}
		}).catch(function(err){
			$scope.loading = false;
			console.log(err);
		});
	}
	
	function saveUserDetails(){
		if(!validationByStepTitle($scope.Steps.user_detail))
			return;

		$scope.loading = true;

		var userData = $scope.localData.userDetails;
		let data = {
			id: userData.id,
			full_name: userData.full_name,
			email: userData.email,
			password: userData.password,
			phone: userData.phone,
			sex: userData.sex,
			action: 'ajax_call',
			sub_action: 'register'
		};

		let req = {
			method: 'POST',
			url: ajaxUrl,
			data: $httpParamSerializer(data),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}

		$scope.userErr = '';
		$scope.loading = true;
		$http(req)
			.then(function(response){
				$scope.loading = false;
				
				var res = response.data;
				console.log(res.data);
				
				if(res.Success == true) 
				{
					if(!$scope.isUserLoggedIn) {
						$scope.localData.userDetails.id = res.data.id;
						// Save local storage
						let obj = JSON.stringify($scope.localData);
						saveLocalData(obj);
					}
					$scope.Wizard.next();
				} 
				else
				{
					$scope.userErr = true;
					$scope.userErrorMessage = res.Message;
				}
			}).catch(function(error){
				$scope.loading = false;
				let err = error.data;
				$scope.userErr = false;
				$scope.userErrorMessage = err[0].message;
			});
	} 

	function saveAddressDetails(){
		if(!validationByStepTitle($scope.Steps.address_detail))
			return;

		$scope.loading = true;

		let data = {
			id: $scope.getAddress != null?$scope.getAddress.id: -1,
			customer_id: !$scope.isUserLoggedIn?$scope.localData.userDetails.id: -1,
			street_name: $scope.localData.addressDetails.street_name,
			floor: $scope.localData.addressDetails.floor,
			pobox: $scope.localData.addressDetails.pobox,
			city_id: $scope.localData.addressDetails.city_id,
			unit_number: $scope.localData.addressDetails.unit_number,
			as_default: '0',
			action: !$scope.isUserLoggedIn?'ajax_call': 'authenticate_ajax_call',
			sub_action: 'create_address'
		};

		let req = {
			method: 'POST',
			url: ajaxUrl,
			data: $httpParamSerializer(data),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		};

		$scope.addressErr = false;

		$http(req)
			.then(function(response){
				$scope.loading = false;
				var res = response.data;

				if(res.Success == true) {
					$scope.AllAddresses.push(res.data);
					$scope.getAddress = res.data;
					
					if(!$scope.isUserLoggedIn) {
						// Save local storage
						$scope.localData.addressDetails = res.data;
						let obj = JSON.stringify($scope.localData);
						saveLocalData(obj);
					}
					$scope.Wizard.next();

				} else {
					$scope.addressErr = true;
					$scope.addressErrorMessage = res.Message;
				}
			}).catch(function(error){
				$scope.loading = false;
				let err = error.data;
				$scope.addressErr = true;
				$scope.addressErrorMessage = err[0].message;
				// console.log(error);
			});
	} 

	/* End of Common Functions */

	/* Perform Action contains multiple actions */
	$scope.performAction = function(action, value) {
		switch(action) {
			case "SAVE_PICKUP_DATE":
				$scope.localData.pickupDate = value;
			break;

			case "SELECT_PICKUP_TIME":
				$scope.localData.pickupTime = value;
				return false;
			break;

			case "SELECT_PICKUP_AT_DOOR":
				$scope.localData.pickupTime = {};
				if(value == true) {
					$scope.localData.pickupTime.leaveAtdoor = 'y';
				}
				return false;
			break;

			case "SAVE_DELIVERY_DATE":
				$scope.localData.deliveryDate = value;
			break;

			case "SELECT_DELIVERY_TIME":
				$scope.localData.deliveryTime = value;
				return false;
			break;

			case "SELECT_DELIVERY_AT_DOOR":
				$scope.localData.deliveryTime = {};
				if(value == true) {
					$scope.localData.deliveryTime.leaveAtdoor = 'y';
				}
				return false;
			break;

			case "SAVE_USER_DETAILS":
				debugger;
				saveUserDetails();
				return false;
			break;

			case "SAVE_ADDRESS_DETAILS":
				saveAddressDetails();
				return false;
			break;

			case "GET_PAYMENT_DETAILS":
				getUserPaymentDetails();
				return false;
			break;
		}

		let obj = JSON.stringify($scope.localData);
		saveLocalData(obj);

		// Check Validation
		$scope.checkValidation();
	}
		   
	/* Create Order */
	$scope.createOrder = function(){
		$scope.err = false;

		if(!$scope.getAddress) {
			$scope.err = true;
			$scope.errorMessage = 'Please add address details';
			return;
		}
		if(!$scope.getPayment){
			$scope.err = true;
			$scope.errorMessage = 'Please add payment details';
			return;
		}

		var confuseDatepickup = $scope.localData.pickupDate.date;
		var simpleDatepickup = new Date(confuseDatepickup).toISOString().substr(0,10);
		var confuseDate = $scope.localData.deliveryDate.date;
		var simpleDate = new Date(confuseDate).toISOString().substr(0,10);

		let data = {
			payment_id: $scope.getPayment.id,
			status: '0',
			pickup_date: simpleDatepickup,
			pickup_time_from: $scope.localData.pickupTime.time_from,
			pickup_time_to: $scope.localData.pickupTime.time_to,
			pickup_price: $scope.localData.pickupTime.price,
			pickup_type: $scope.localData.pickupTime.type,
			drop_date: simpleDate,
			drop_time_from: $scope.localData.deliveryTime.time_from,
			drop_time_to: $scope.localData.deliveryTime.time_to,
			drop_price: $scope.localData.deliveryTime.price,
			drop_type: $scope.localData.deliveryTime.type,
			address_id:	$scope.getAddress.id,
			same_day_pickup: $scope.localData.pickupDate.name == 'Today'?'1':'0',
			next_day_drop: $scope.localData.deliveryDate.name == 'next day deliever'?'1':'0',
			comments: null,
			customer_id: !$scope.isUserLoggedIn?$scope.localData.userDetails.id:-1,
			pickup_at_door: $scope.localData.pickupTime.leaveAtdoor == 'y' ? 1 : 0,
			drop_at_door: $scope.localData.deliveryTime.leaveAtdoor == 'y' ? 1 : 0,
			action: !$scope.isUserLoggedIn?'ajax_call':'authenticate_ajax_call',
			sub_action: 'create_order'
		};

		for(let key in data){
			if(!data[key]){
				data[key] = '0';
			}
		}

		let req = {
			method: 'POST',
			url: ajaxUrl,
			data: $httpParamSerializer(data),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		};

		$scope.showLoading = true;
		$http(req)
			.then(function(response){
				$scope.showLoading = false;
				var res = response.data;
				if(res.Success == true) {
					$scope.orderCreationDone = true;
					$timeout(function(){
						removeLoalStorageAndGoToDashboard();
					}, 3000)
				} else {
					$scope.err = true;
					$scope.errorMessage = res.Message;
				}
			}).catch(function(error){
				$scope.showLoading = false;
				let err = error.data;
				console.log(error);
				$scope.err = true;
				$scope.errorMessage = err[0].message;;

			});
	}

	/* Cancel Order */
	$scope.onCancelOrder = function() {
		var confirmation = confirm("Do you want to cancel order ?");
		if(confirmation) {
			removeLoalStorageAndGoToDashboard();
		}
	}
	
	// save onto local storage closed
	function getLocalStorageData() {
		var order = localStorage.getItem(getLocalStorageKeyOfOrder());
		
		let obj = {};
		if(order) {
			obj = JSON.parse(order);
			return obj;
		}
		return null;
	}

	function getObjectLength(obj) {
		if(!obj)
			return 0;
		return Object.keys(obj).length;
	}

	function removeLoalStorageAndGoToDashboard(){
		localStorage.removeItem(getLocalStorageKeyOfOrder());
		window.location.reload();
	}

	function saveLocalData(data) {
		localStorage.setItem(getLocalStorageKeyOfOrder(),  data);
	}

	function getLocalStorageKeyOfOrder() {
		var key = 'Myorder'
		if($scope.isUserLoggedIn) {
			key = 'Myorder_' + userId
		} 

		return key;
	}
});




// Load Controller of PaymentmethodfCtrl

app.controller('PaymentmethodCtrl',function($scope, $http, appInfo){
	$scope.loading = false;
	$scope.paymentId;
	let x = localStorage.getItem('laundryUser');
	$scope.userdata = {};
	$scope.paymentDetails = [];
	getPayment();

	$scope.onDeltePayment = function(data, i){
		let id = $scope.userdata.payments[i].id;
		let req = {
			method: 'DELETE',
			url: appInfo.url+'paymentsapi/delete?id='+id,
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}
		$scope.err = '';
		$scope.loading = true;
		$http(req)
			.then(function(res){
				$scope.loading = false;
				console.log(res.data);
				getPayment();
				console.log("tyahsee");
			}).catch(function(error){
				$scope.loading = false;
				let err = error.data;
				$scope.err = err[0].message;
				// console.log(error);
			})
	}
	

	function getPayment(){
	
		$http.get(appInfo.url+'customersapi/view/?id='+x+'&expand=payments')
		.then(function(res){
			// console.log(res.data.payments[0].id);
			// $scope.paymentId = res.data.payments[0].id;
			
			$scope.userdata.payments = res.data.payments;
			if($scope.userdata.payments.length == 0){
				$scope.paymentDetails = [];
			}
			for(let value of  $scope.userdata.payments){
				getVault(value.vault_id);
			}
			console.log("tahsss");
		}).catch(function(err){
			console.log(err);
		});

		$scope.editPayment = function(e){
			console.log(e);
			
		}	
	
	}
   
   function getVault(id){
		$scope.loading = true;
		$http.get(appInfo.url+'vaultapi/view/?id='+id)
		.then(function(res){
			$scope.loading = false;
			// console.log(res.data);
			$scope.paymentDetails.push(res.data);
		}).catch(function(err){
			$scope.loading = false;
			console.log(err);
		});
   }

});


// Load Controller of FinaldateCtrl

app.controller('FinaldateCtrl',function($scope){
	console.log('FinaldateCtrl');
})



// Load Controller of MyeditCtrl

app.controller('MyeditCtrl',function($scope,$routeParams){
	$scope.message = 'Clicked person name from home page should be dispalyed here';
	$scope.person = $routeParams.person;
	console.log($scope.person);

	$scope.persondata=[];

	$scope.myeditsave =function() {
		console.log($scope.persondata);
	}
})

// edit address
app.controller('EditAddressCtrl', function($scope, appInfo, $routeParams, $http, $httpParamSerializer){
	$scope.loading = false;
	getOneAddress();
	getcity();
	$scope.addressData = {};
	$scope.cityData = {};

	$scope.change = function(){
		console.log('e');
	}

	$scope.onEditSubmit = function(){

		let data = {
			street_name: $scope.addressData.street_name,
			floor: $scope.addressData.floor,
			pobox: $scope.addressData.pobox,
			city_id: $scope.addressData.city_id
		};
		
		let req = {
			method: 'PUT',
			url: appInfo.url+'addressesapi/update?id='+$routeParams.id,
			data: $httpParamSerializer(data),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}
		$scope.loading = true;
		$http(req)
			.then(function(res){
				$scope.loading = false;
				console.log(res.data);
				console.log("0");	
			}).catch(function(err){
				$scope.loading = false;
				   console.log(err);
			})
	}

	function getOneAddress(){
		$scope.loading = true;
		$http.get(appInfo.url+'addressesapi/view?id='+$routeParams.id)
			.then(function(res){
				$scope.loading = false;
				console.log(res.data);
				console.log("0");
				
				$scope.addressData = res.data;
				$scope.addressData.city_id = res.data.city_id.toString();
			}).catch(function(err){
				$scope.loading = false;
				console.log(err);
			})
	}

	function getcity(){
		$http.get(appInfo.url+'citiesapi')
			.then(function(res){
				console.log(res.data);
				$scope.cityData = res.data;
			}).catch(function(err){
				   console.log(err);
			})
	  }

});

app.controller('EditPaymentCtrl', function($scope, $http, appInfo, $routeParams, $httpParamSerializer){
	$scope.paymentDetails = {};
	getVault();

	$scope.onEditSubmit = function(){

		let data = {
			name: $scope.paymentDetails.name,
			number: $scope.paymentDetails.number,
			cvcode: $scope.paymentDetails.cvcode,
			expiry_month: $scope.paymentDetails.expiry_month,
			expiry_year: $scope.paymentDetails.expiry_year
		};
		
		let req = {
			method: 'PUT',
			url: appInfo.url+'vaultapi/update?id='+$routeParams.id,
			data: $httpParamSerializer(data),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}
		$scope.loading = true;
		$http(req)
			.then(function(res){
				$scope.loading = false;
				console.log(res.data);
			}).catch(function(err){
				$scope.loading = false;
				   console.log(err);
			})
	}


	
	function getVault(id){
		$scope.loading = true;
		$http.get(appInfo.url+'vaultapi/view/?id='+$routeParams.id)
		.then(function(res){
			$scope.loading = false;
			// console.log(res.data);
			$scope.paymentDetails = res.data;
		}).catch(function(err){
			$scope.loading = false;
			console.log(err);
		});
   }

});


app.controller('AddAddressCtrl', function($scope, $http, appInfo, $httpParamSerializer){
	let x = localStorage.getItem('laundryUser');
	$scope.loading = false;
	$scope.addressData = {};
	$scope.cityData = [];
	getcity();
	$scope.err;
	$scope.onAddSubmit = function(){
		let data = {
			street_name: $scope.addressData.street_name,
			floor: $scope.addressData.floor,
			pobox: $scope.addressData.pobox,
			city_id: $scope.addressData.city_id,
			customer_id: x,
			unit_number: $scope.addressData.unit_number,
			as_default: '0'
		};
		let req = {
			method: 'POST',
			url: appInfo.url+'addressesapi/create',
			data: $httpParamSerializer(data),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}
		$scope.err = '';
		$scope.loading = true;
		$http(req)
			.then(function(res){
				$scope.loading = false;
				console.log(res.data);
				console.log("add");
				
			}).catch(function(error){
				$scope.loading = false;
				let err = error.data;
				$scope.err = err[0].message;
				// console.log(error);
			})
	}

	function getcity(){
		$http.get(appInfo.url+'citiesapi')
			.then(function(res){
				// console.log(res.data);
				$scope.cityData = res.data;
			}).catch(function(err){
				   console.log(err);
			})
	  }



});


app.controller('AddPaymentCtrl', function($scope, $http, appInfo, $httpParamSerializer){
	let userId = localStorage.getItem('laundryUser');
	$scope.paymentDetails = {};
	

	$scope.onAddPayment = function(){
		
			let data = {
				name: $scope.paymentDetails.name,
				number: $scope.paymentDetails.number,
				cvcode: $scope.paymentDetails.cvcode,
				expiry_month: $scope.paymentDetails.expiry_month,
				expiry_year: $scope.paymentDetails.expiry_year,
			};

			let req = {
				method: 'POST',
				url: appInfo.url+'vaultapi/create',
				data: $httpParamSerializer(data),
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			}
			$scope.err = '';
			$scope.loading = true;
			$http(req)
				.then(function(res){
					$scope.loading = false;
					console.log(res.data);
					addPayment(res.data.id);
					
				}).catch(function(error){
					$scope.loading = false;
					let err = error.data;
					$scope.err = err[0].message;
					// console.log(error);
				})
	}

	function addPayment(id){
		let data = {
			customer_id: userId,
			vault_id: id
		};

		let req = {
			method: 'POST',
			url: appInfo.url+'paymentsapi/create',
			data: $httpParamSerializer(data),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}
		$scope.err = '';
		$scope.loading = true;
		$http(req)
			.then(function(res){
				$scope.loading = false;
				console.log(res.data);
				$scope.paymentDetails = {};
			}).catch(function(error){
				$scope.loading = false;
				let err = error.data;
				$scope.err = err[0].message;
				// console.log(error);
			})
	}

	
	



});
