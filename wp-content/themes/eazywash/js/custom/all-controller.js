// App Controller
app.controller("AppController", function(
  $scope,
  $rootScope,
  $translate,
  CommonService
) {
  $scope.changeLanguage = function(lang) {
    $rootScope.SelectedLang = lang;
    CommonService.storeLanguageLocal(lang);
    $translate.use(lang);
  };


  $rootScope.loadAddPaymentMethodForm = function(userId) {
    var formHtml = CommonService.GenerateAddPaymentForm(userId);
  
    jQuery('.paymentIframeContainer').html('<iframe id="paymentIframe" width="100%" height="450px"></iframe>');
    var doc = document.getElementById("paymentIframe").contentWindow.document;
    doc.open();
    doc.write('<h3 class="text-center">Loading...</h3>' + formHtml);
    doc.close();
  }
  

  /** Validation **/
  $rootScope.loginValidationOptions = {
    rules: {
      email: {
        required: true,
        email: true
      },
      password: {
        required: true
      }
    },
    messages: {
      email: {
        required: "Please enter email address",
        email: "Email address is invalid"
      },
      password: {
        required: "Please enter password"
      }
    }
  };

  $rootScope.basicDetailsValidationOptions = {
    rules: {
      fullname: {
        required: true,
        lettersonly: true
      },
      email: {
        required: true,
        email: true
      },
      phone: {
        required: true,
        number: true,
        minlength: 7
      },
      password: {
        required: true,
        minlength: 6
      }
    },
    messages: {
      fullname: {
        required: "Please enter name",
        lettersonly: "Only alphabets and space is allowed"
      },
      email: {
        required: "Please enter email"
      },
      phone: {
        required: "Please enter phone number"
      },
      password: {
        required: "Please enter password"
      }
    }
  };

  $rootScope.addressDetailsValidationOptions = {
    rules: {
      street_name: {
        required: true
      },
      floor: {
        required: true
      },
      pobox: {
        required: true,
        number: true
      },
      unit_number: {
        required: true,
        number: true
      },
      city: {
        required: true
      }
    },
    messages: {
      street_name: {
        required: "Please enter street name"
      },
      floor: {
        required: "Please enter floor"
      },
      pobox: {
        required: "Please enter pobox"
      },
      city: {
        required: "Please select city"
      }
    }
  };

  $rootScope.resetPasswordValidationOptions = {
    rules: {
      oldpassword: {
        required: true
      },
      newpassword: {
        required: true,
        minlength: 6
      },
      confirmpassword: {
        equalTo: "#newpassword"
      }
    },
    messages: {
      oldpassword: {
        required: "Please enter old password"
      },
      newpassword: {
        required: "Please enter new password",
        minimum: "Minimum length should be 6 characters"
      },
      confirmpassword: {
        required: "Password do not match",
        equalTo: "Enter password again"
      }
    }
  };

  $rootScope.forgotPasswordValidationOptions = {
    rules: {
      email: {
        required: true,
        email: true
      }
    }
  };

  $rootScope.displayCardName = function(type) {
    var cardNameText = type;
    if ($rootScope.CardTypes[type]) {
      cardNameText = $rootScope.CardTypes[type];
    }
    return cardNameText;
  };
});

//Login of Controller
app.controller("LoginCtrl", function(
  $scope,
  $location,
  $http,
  $httpParamSerializer
) {
  $scope.loading = false;
  $scope.field = "email";
  $scope.logindata = {
    email: "",
    password: ""
  };
  $scope.err = false;
  $scope.errorMessage = null;
  $scope.checkbox = true;

  $scope.loginsubmit = function(form) {
    if(form.validate()){
      $scope.err = false;

      let email = $scope.logindata.email;
      let password = $scope.logindata.password;

      $scope.loading = true;

      var req = {
        method: "POST",
        url: ajaxUrl,
        data: $httpParamSerializer({
          email: email,
          password: password,
          action: "ajax_call",
          sub_action: "login"
        }),
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        }
      };

      $http(req)
        .then(function(response) {
          console.log(response);
          $scope.loading = false;
          var res = response.data;

          if (res.Success == true && res.data != 0) {
            localStorage.setItem("laundryUser", res.data);
            let date = new Date();
            if ($scope.checkbox == true) {
              localStorage.setItem("rememberMe", "y");
              let date1 = new Date(
                date.setDate(date.getDate() + 10)
              ).toUTCString();
              document.cookie = "laundryCookie=y; expires=" + date1;
            } else {
              localStorage.removeItem("rememberMe");
              let date1 = new Date(
                date.setHours(date.getHours() + 1)
              ).toUTCString();
              document.cookie = "laundryCookie=y; expires=" + date1;
            }
            window.location.reload();
          } else {
            $scope.err = true;
            $scope.errorMessage = "Invalid login credentials";
          }
        })
        .catch(function(err) {
          $scope.loading = false;
          console.log("error");
          console.log(err);
        });
    }
  };
});

//Logout of Controller
app.controller("LogoutCtrl", function($scope, $http, $httpParamSerializer) {
  $scope.loading = false;

  $scope.err = false;
  $scope.errorMessage = null;

  $scope.logout = function() {
    $scope.err = false;

    $scope.loading = true;

    var req = {
      method: "POST",
      url: ajaxUrl,
      data: $httpParamSerializer({
        action: "logout_method"
      }),
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      }
    };

    $http(req)
      .then(function(response) {
        console.log(response);
        $scope.loading = false;
        var res = response.data;

        if (res.Success == true) {
          let date = new Date().toUTCString();
          document.cookie = "laundryCookie=y; expires=" + date;

          localStorage.removeItem("laundryUser");
          localStorage.removeItem("rememberMe");

          window.location.reload();
        } else {
          $scope.err = true;
          $scope.errorMessage = res.Message;
        }
      })
      .catch(function(err) {
        $scope.loading = false;
        console.log("error");
        console.log(err);
      });
  };
});

// Signup of Controller
app.controller("SignupCtrl", function(
  $scope,
  $httpParamSerializer,
  $http
) {
  $scope.loading = false;

  $scope.err = false;
  $scope.errorMessage = null;

  $scope.signupdata = {
    name: null,
    email: null,
    password: null,
    phone: null,
    sex: "1"
  };

  $scope.signupsubmitform = function(form) {
    if (form.validate()) {
      $scope.loading = true;
      let data = {
        full_name: $scope.signupdata.name,
        email: $scope.signupdata.email,
        password: $scope.signupdata.password,
        phone: $scope.signupdata.phone,
        sex: $scope.signupdata.sex,
        action: "ajax_call",
        sub_action: "register",
        allow_login: true
      };

      let req = {
        method: "POST",
        url: ajaxUrl,
        data: $httpParamSerializer(data),
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        }
      };

      $scope.err = false;
      $scope.loading = true;
      $http(req)
        .then(function(response) {
          $scope.loading = false;

          var res = response.data;
          console.log(res.data);

          if (res.Success == true) {
            let date = new Date();
            localStorage.setItem("laundryUser", res.data.id);

            let date1 = new Date(
              date.setHours(date.getHours() + 1)
            ).toUTCString();
            document.cookie = "laundryCookie=y; expires=" + date1;

            window.location.reload();
          } else {
            $scope.err = true;
            if (res.data.length > 0) {
              var fieldErrors = res.data;
              var firstFieldError = fieldErrors[0];

              $scope.errorMessage = firstFieldError.message
                ? firstFieldError.message
                : res.Message;
            } else {
              $scope.errorMessage = res.Message;
            }
          }
        })
        .catch(function(error) {
          $scope.loading = false;
          let err = error.data;
          $scope.err = false;
          $scope.errorMessage = err[0].message;
        });
    }
  };
});

// Forget password of Controller
app.controller("ForgetCtrl", function($scope, CommonService, $timeout) {
  $scope.messageObj = null;
  $scope.loading = false;
  $scope.form = {
    email: null,
    action: "ajax_call",
    sub_action: "forgot_password"
  };

  $scope.forgotpassowrd = function(form) {
    if (form.validate()) {
      CommonService.CallAjaxUsingPostRequest(ajaxUrl, $scope.form)
        .then(
          function(data) {
            $scope.loading = false;
            if (data.Success == true) {
              $scope.form.email = null;

              var result = data.data;
              $scope.messageObj = {
                class: "alert alert-success",
                message: result.Message
              };
            } else {
              $scope.messageObj = {
                class: "alert alert-danger",
                message: data.Message
              };
            }

            $timeout(function() {
              $scope.messageObj = null;
            }, 2000);
          },
          function(error) {}
        )
        .finally(function() {
          $scope.loading = false;
        });
    }
  };
});
// Dashboard of Controller

app.controller("DashboardCtrl", function(
  $scope,
  $rootScope,
  CommonService,
  $location,
  $timeout
) {
  $scope.loading = true;

  $scope.messageObj = null;
  $scope.popupMessageObj = null;

  var tempAddressIndex = -1;

  $scope.userdata = {};
  $scope.addresses = [];
  $scope.vaults = [];
  $scope.cityData = [];

  defaultAddressFields();
  defaultChangePasswordFields();

  function defaultAddressFields() {
    $scope.addressDetails = {
      id: null,
      street_name: null,
      floor: null,
      pobox: null,
      unit_number: null,
      city_id: null
    };
  }

  function defaultChangePasswordFields() {
    $scope.changePassword = {
      old_password: null,
      new_password: null,
      cpassword: null
    };
  }

  CommonService.CallAjaxUsingPostRequest(ajaxUrl, { action: "dashboard_data" })
    .then(
      function(data) {
        $scope.loading = false;
        if (data.Success == true) {
          $scope.userdata = data.user_details;
          $scope.addresses = data.addresses;
          $scope.vaults = data.vaults;
          $scope.cityData = data.cities;
        }
      },
      function(error) {}
    )
    .finally(function() {
      $scope.loading = false;
    });

  $scope.saveUserDetails = function(form) {
    if (form.validate()) {
      $scope.loading = true;

      var data = $scope.userdata;
      data.action = "authenticate_ajax_call";
      data.sub_action = "update_user_details";

      CommonService.CallAjaxUsingPostRequest(ajaxUrl, data)
        .then(
          function(data) {
            $scope.loading = false;
            if (data.Success == true) {
              var result = data.data;
              $scope.messageObj = {
                class: "alert alert-success",
                message: "Basic details updated successfully"
              };
            } else {
              $scope.messageObj = {
                class: "alert alert-danger",
                message: data.Message
              };
            }
          },
          function(error) {}
        )
        .finally(function() {
          $scope.loading = false;

          $timeout(function() {
            $scope.messageObj = null;
          }, 2000);
        });
    }
  };

  $scope.saveAddressDetails = function(form) {
    if (form.validate()) {
      $scope.loading = true;

      let request_data = {
        id: $scope.addressDetails.id,
        street_name: $scope.addressDetails.street_name,
        floor: $scope.addressDetails.floor,
        pobox: $scope.addressDetails.pobox,
        city_id: $scope.addressDetails.city_id,
        unit_number: $scope.addressDetails.unit_number,
        as_default: "0",
        action: "authenticate_ajax_call",
        sub_action: "create_address"
      };

      $scope.popupMessageObj = null;

      CommonService.CallAjaxUsingPostRequest(ajaxUrl, request_data)
        .then(
          function(data) {
            $scope.loading = false;
            var result = data.data;

            if (data.Success == true) {
              var message = "";
              if (request_data.id > 0) {
                $scope.addresses[tempAddressIndex] = result;
                message = "Address updated successfully";
              } else {
                $scope.addresses.push(result);
                defaultAddressFields();

                message = "Address added successfully";

                $timeout(function() {
                  jQuery("#addressModal").modal("hide");
                }, 2000);
              }

              $scope.popupMessageObj = {
                class: "alert alert-success",
                message: message
              };
            } else {
              $scope.popupMessageObj = {
                class: "alert alert-danger",
                message: data.Message
              };
            }
          },
          function(error) {}
        )
        .finally(function() {
          $scope.loading = false;

          $timeout(function() {
            $scope.popupMessageObj = null;
          }, 2000);
        });
    }
  };

  $scope.changePassowrd = function(form) {
    if (form.validate()) {
      var data = $scope.changePassword;
      data.action = "authenticate_ajax_call";
      data.sub_action = "change_password";

      CommonService.CallAjaxUsingPostRequest(ajaxUrl, data)
        .then(
          function(data) {
            $scope.loading = false;
            if (data.Success == true) {
              var result = data.data;
              defaultChangePasswordFields();

              $scope.popupMessageObj = {
                class: "alert alert-success",
                message: result.Message
              };
            } else {
              $scope.popupMessageObj = {
                class: "alert alert-danger",
                message: data.Message
              };
            }
          },
          function(error) {}
        )
        .finally(function() {
          $scope.loading = false;

          $timeout(function() {
            $scope.popupMessageObj = null;
          }, 2000);
        });
    }
  };

  $scope.setDefaultAddress = function(addressDetail) {
    var request_data = {};
    request_data.id = addressDetail.id;
    request_data.action = "authenticate_ajax_call";
    request_data.sub_action = "set_default_address";

    CommonService.CallAjaxUsingPostRequest(ajaxUrl, request_data)
      .then(
        function(data) {
          $scope.loading = false;
          var result = data.data;
          if (data.Success == true) {
            $scope.addresses.map(function(address) {
              if (address.id == request_data.id) {
                return (address.as_default = 1);
              } else {
                return (address.as_default = 0);
              }
            });

            $scope.messageObj = {
              class: "alert alert-success",
              message: result.message
            };
          } else {
            $scope.messageObj = {
              class: "alert alert-danger",
              message: data.Message
            };
          }
        },
        function(error) {}
      )
      .finally(function() {
        $timeout(function() {
          $scope.messageObj = null;
        }, 2000);
        $scope.loading = false;
      });
  };

  $scope.setDefaultVault = function(vaultDetail) {
    var request_data = {};
    request_data.id = vaultDetail.id;
    request_data.action = "authenticate_ajax_call";
    request_data.sub_action = "set_default_vault";

    CommonService.CallAjaxUsingPostRequest(ajaxUrl, request_data)
      .then(
        function(data) {
          $scope.loading = false;

          var result = data.data;

          if (data.Success == true) {
            $scope.vaults.map(function(vault) {
              if (vault.id == request_data.id) {
                return (vault.as_default = 1);
              } else {
                return (vault.as_default = 0);
              }
            });

            $scope.messageObj = {
              class: "alert alert-success",
              message: result.message
            };
          } else {
            $scope.messageObj = {
              class: "alert alert-danger",
              message: data.Message
            };
          }
        },
        function(error) {}
      )
      .finally(function() {
        $timeout(function() {
          $scope.messageObj = null;
        }, 2000);
        $scope.loading = false;
      });
  };

  $scope.loadVaults = function(){
    debugger;
    var data = {};
    data.action = "authenticate_ajax_call";
    data.sub_action = "vaults";

    CommonService.CallAjaxUsingPostRequest(ajaxUrl, data)
      .then(
        function(data) {
          var result = data.data;
          $scope.loading = false;
          if (data.Success == true) {
            $scope.vaults = result.vault;
          } else {
            $scope.messageObj = {
              class: "alert alert-danger",
              message: data.Message
            };
          }
        },
        function(error) {}
      )
      .finally(function() {
        $timeout(function() {
          $scope.messageObj = null;
        }, 2000);
        $scope.loading = false;
      });
  }
  $scope.deleteAddress = function(addressDetail, index) {
    if (addressDetail && addressDetail !== null) {
      var confirmation = confirm("Do you want to delete address details?");
      if (confirmation) {
        var data = {};
        data.id = addressDetail.id;
        data.action = "authenticate_ajax_call";
        data.sub_action = "delete_address";

        CommonService.CallAjaxUsingPostRequest(ajaxUrl, data)
          .then(
            function(data) {
              $scope.loading = false;
              if (data.Success == true) {
                $scope.addresses.splice(index, 1);

                $scope.messageObj = {
                  class: "alert alert-success",
                  message: "Address deleted successfully"
                };
              } else {
                $scope.messageObj = {
                  class: "alert alert-danger",
                  message: data.Message
                };
              }
            },
            function(error) {}
          )
          .finally(function() {
            $timeout(function() {
              $scope.messageObj = null;
            }, 2000);
            $scope.loading = false;
          });
      }
    }
  };

  $scope.deleteVault = function(vaultDetail, index) {
    if (vaultDetail && vaultDetail !== null) {
      var cardName = $rootScope.CardTypes[vaultDetail.payment_type]
        ? $rootScope.CardTypes[vaultDetail.payment_type]
        : vaultDetail.payment_type;
      var confirmation = confirm(
        "Do you want to delete " +
          cardName +
          " end with " +
          vaultDetail.number +
          "?"
      );
      if (confirmation) {
        var data = {};
        data.id = vaultDetail.id;
        data.action = "authenticate_ajax_call";
        data.sub_action = "delete_vault";

        CommonService.CallAjaxUsingPostRequest(ajaxUrl, data)
          .then(
            function(data) {
              $scope.loading = false;
              if (data.Success == true) {
                $scope.vaults.splice(index, 1);

                $scope.messageObj = {
                  class: "alert alert-success",
                  message: "Vault deleted successfully"
                };
              } else {
                $scope.messageObj = {
                  class: "alert alert-danger",
                  message: data.Message
                };
              }
            },
            function(error) {}
          )
          .finally(function() {
            $timeout(function() {
              $scope.messageObj = null;
            }, 2000);
            $scope.loading = false;
          });
      }
    }
  };

  $scope.openVaultModal = function() {
    $rootScope.loadAddPaymentMethodForm(logged_in_user_id);

    jQuery("#vaultModal").modal("show");
  };

  $scope.openAddressModal = function(addressDetail, index) {
    if (addressDetail && addressDetail !== null) {
      tempAddressIndex = index;
      $scope.addressDetails = angular.copy(addressDetail);
    } else {
      defaultAddressFields();
    }

    jQuery("#addressModal").modal("show");
  };

  
  $scope.displayCityName = function(cityId) {
    debugger;
    var cityText = "N/A";
    if (cityId > 0) {
      var cityObj = $scope.cityData.find(function(city) {
        return city.id == cityId;
      });

      if (cityObj !== null) cityText = cityObj.title;
    }
    return cityText;
  };

});

// pricing of Controller

app.controller("PricingCtrl", function($scope) {
  // body...
});

// Aboutus of Controller

app.controller("AboutusCtrl", function($scope) {
  // body...
});

// Frequently asked questions of Controller

app.controller("FaqsCtrl", function($scope) {
  $scope.questions = [
    {
      question: "How do I brighten my dingy white clothes and linens?",
      decription:
        "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English."
    },
    {
      question:
        "How do I remove set-in stains that have been washed and dried?",
      decription:
        "washed and dried? Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for "
    },
    {
      question: "How can I prevent fading of my dark clothes?",
      decription:
        "fading of my dark clothes? There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable."
    },
    {
      question: "How do I remove dye transfer from clothes?",
      decription:
        "dye transfer from clothes? Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for"
    },
    {
      question: "How do I remove yellow armpit stains?",
      decription:
        "yellow armpit stains? Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for"
    },
    {
      question: "How do I remove ink stains from clothes and leather?",
      decription:
        "ink stains from clothes and leather? Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for"
    },
    {
      question: "Why wont my washer/dryer work?",
      decription:
        "washer/dryer work? Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for"
    }
  ];

  $scope.toggleGroup = function(group) {
    if ($scope.isGroupShown(group)) {
      $scope.shownGroup = null;
    } else {
      $scope.shownGroup = group;
    }
  };

  $scope.isGroupShown = function(group) {
    return $scope.shownGroup === group;
  };
});

// Load Controller of OrdersummaryCtrl
app.controller("OrdersummaryCtrl", function(
  $scope,
  $rootScope,
  $http,
  $timeout,
  $httpParamSerializer,
  $location,
  CommonService,
  WizardHandler
) {
  $scope.showLoading = true;
  $scope.loading = false;

  let userId = localStorage.getItem("laundryUser");

  $scope.isUserLoggedIn = is_user_logged_in;
  $scope.orderCreationDone = false;

  $scope.lastStepNumber = $scope.isUserLoggedIn ? 5 : 8;

  $scope.showAddressDetailStep = false;
  $scope.showPaymentDetailStep = false;

  $scope.cityData = [];
  $scope.AllAddresses = [];
  $scope.AllPayments = [];
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

  $scope.paymentErr = false;
  $scope.paymentErrorMessage = null;

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
    pickupDate: {},
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

  var days = [
    "sunday",
    "monday",
    "tuesday",
    "wednesday",
    "thursday",
    "friday",
    "saturday"
  ];
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

  function initializeOrderCreation() {
    let req = {
      method: "POST",
      url: ajaxUrl,
      data: $httpParamSerializer({ action: "order_creation_data" }),
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      }
    };

    $http(req)
      .then(function(response) {
        var res = response.data;
        console.log(res);

        if (res.Success == true) {
          if (res.cities && res.cities.length > 0) $scope.cityData = res.cities;

          if (res.options && res.options.length > 0)
            $scope.optionsData = res.options[0];

          if (res.timeslots && res.timeslots.length > 0)
            $scope.TimeSlots = res.timeslots;

          if ($scope.isUserLoggedIn) {
            if (res.addresses && res.addresses.length > 0) {
              extractDefaultAddress(res.addresses);
            } else {
              $scope.showAddressDetailStep = true;
              $scope.lastStepNumber += 1;
            }

            if (res.vaults && res.vaults.length > 0) {
              extractDefaultVault(res.vaults);
            } else {
              $scope.showPaymentDetailStep = true;
              $scope.lastStepNumber += 1;
            }
          }
        }
        $scope.showLoading = false;
      })
      .catch(function(err) {
        $scope.showLoading = false;
        console.log(err);
      });
  }

  $scope.initializeWizard = function() {
    functionForPickupDate();

    $scope.Wizard = WizardHandler.wizard("requestPickupWizard");

    if (getLocalStorageData()) {
      jQuery("#requestPickupModal").modal("show");

      $scope.localData = getLocalStorageData();

      if (!$scope.isUserLoggedIn) {
        $scope.getAddress = $scope.localData.addressDetails;
        $scope.getPayment = $scope.localData.paymentDetails;
      }

      var goToStep = 0;

      if (
        !$scope.isUserLoggedIn &&
        getObjectLength($scope.localData.paymentDetails) != 0
      ) {
        goToStep = 7;
      } else if (
        !$scope.isUserLoggedIn &&
        $scope.localData.addressDetails.id > 0
      ) {
        goToStep = 6;
      } else if (
        !$scope.isUserLoggedIn &&
        $scope.localData.userDetails.id > 0
      ) {
        goToStep = 5;
      } else if (getObjectLength($scope.localData.deliveryTime) != 0) {
        goToStep = 4;
      } else if (getObjectLength($scope.localData.deliveryDate) != 0) {
        goToStep = 3;
      } else if (getObjectLength($scope.localData.pickupTime) != 0) {
        goToStep = 2;
      } else if (getObjectLength($scope.localData.pickupDate) != 0) {
        goToStep = 1;
      }

      $scope.goToStep(goToStep);
    }
  };

  $scope.validateStep = function() {
    if ($scope.stepValidation == true) {
      var step = $scope.Wizard.currentStep();
      var stepTitle = step.wzHeadingTitle;

      return validationByStepTitle();
    }
    return true;
  };

  $scope.noValidation = function() {
    $scope.stepValidation = false;
  };

  $scope.checkValidation = function() {
    $scope.stepValidation = true;
  };

  $scope.$on("wizard:stepChanged", function(event, args) {
    var stepTitle = args.step.wzHeadingTitle;

    console.log(stepTitle);

    switch (stepTitle) {
      case $scope.Steps.pickup_date:
        $scope.showAllpickupDateList = false;
        break;

      case $scope.Steps.pickup_time:
        console.log("second");
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
  function functionForPickupDate() {
    if ($scope.optionsData == null) return;

    let array = [];
    let date = new Date();

    let holidays = $scope.optionsData.holidays.split(",");
    let length = $scope.optionsData.holidays.split(",").length;
    if ($scope.optionsData.weekend) {
      length += 1;
    }
    for (var i = 0; i < 16 + length; i++) {
      let name = "";
      let price = "";
      date = new Date();
      let d = new Date(date.setDate(date.getDate() + i));
      if (d.getDate() == new Date().getDate()) {
        // if  day is tomorrow
        name = "Today";
        price = $scope.optionsData.same_day_pickup_price;
      } else if (d.getDate() == new Date().getDate() + 1) {
        // if day is day after
        name = "Tomorrow";
      } else {
        name = days[d.getDay()];
      }

      array.push({
        date: d,
        name: name,
        price: price,
        shortDate: d.getDate() + "th " + months[d.getMonth()]
      });
    }

    for (var i = 0; i < array.length; i++) {
      for (let j = 0; j < holidays.length; j++) {
        if (array[i]) {
          if (
            array[i].date.toLocaleDateString() ==
            new Date(holidays[j] * 1000).toLocaleDateString()
          ) {
            array.splice(i, 1);
          }
        }
      }

      if ($scope.optionsData.weekend) {
        if (array[i]) {
          if (days.indexOf($scope.optionsData.weekend) > -1) {
            if (
              array[i].date.getDay() == days.indexOf($scope.optionsData.weekend)
            ) {
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

  $scope.loadMorePickupDates = function() {
    $scope.showAllpickupDateList = true;
  };
  // wizard one closed

  // wizard three  start
  function functionForDropDate() {
    if ($scope.optionsData == null) return;

    let array = [];
    let date = new Date(getLocalStorageData().pickupDate.date);
    let pickupD = new Date(getLocalStorageData().pickupDate.date);

    let holidays = $scope.optionsData.holidays.split(",");
    let length = $scope.optionsData.holidays.split(",").length;
    if ($scope.optionsData.weekend) {
      length += 1;
    }
    for (var i = 0; i < 16 + length; i++) {
      let name = "";
      let price = "";
      let d = new Date(date.setDate(date.getDate() + 1));
      if (d.getDate() == new Date().getDate() + 1) {
        // if day is day after
        name = "Tomorrow";
        price = $scope.optionsData.next_day_delivery_price;
      } else if (d.getDate() == pickupD.getDate() + 1) {
        // if  day is tomorrow
        // name = 'day after';
        name = "next day deliever";
        price = $scope.optionsData.next_day_delivery_price;
      }

      array.push({
        date: d,
        name: name,
        price: price,
        shortDate: d.getDate() + "th " + days[d.getDay()]
      });
    }
    for (var i = 0; i < array.length; i++) {
      for (let j = 0; j < holidays.length; j++) {
        if (array[i]) {
          if (
            array[i].date.toLocaleDateString() ==
            new Date(holidays[j] * 1000).toLocaleDateString()
          ) {
            array.splice(i, 1);
          }
        }
      }
      if (array[i]) {
        if ($scope.optionsData.weekend) {
          if (days.indexOf($scope.optionsData.weekend) > -1) {
            if (
              array[i].date.getDay() == days.indexOf($scope.optionsData.weekend)
            ) {
              array.splice(i, 1);
            }
          }
        }
      }
    }
    array.length = 15;
    $scope.deliveryDateList = array;
  }

  $scope.loadMoreDeliveryDates = function() {
    $scope.showAlldeliveryDateList = true;
  };
  // wizard three closed

  // wizard sixth start
  function functionForPaymentDetail() {
    $rootScope.loadAddPaymentMethodForm(!$scope.isUserLoggedIn ? $scope.localData.userDetails.id : userId);
  }
  // wizard sixth closed

  // Wizard last step
  $scope.goToStep = function(stepNumber){
    if ($scope.Wizard) {
      $scope.Wizard.goTo(stepNumber);
    }
  };

  // End Wizard last step

  /* Common Functions */

  function validationByStepTitle(stepTitle) {
    if (
      stepTitle == $scope.Steps.pickup_date &&
      getObjectLength($scope.localData.pickupDate) == 0
    ) {
      return false;
    } else if (
      stepTitle == $scope.Steps.pickup_time &&
      getObjectLength($scope.localData.pickupTime) == 0
    ) {
      return false;
    } else if (
      stepTitle == $scope.Steps.drop_date &&
      getObjectLength($scope.localData.deliveryDate) == 0
    ) {
      return false;
    } else if (
      stepTitle == $scope.Steps.drop_time &&
      getObjectLength($scope.localData.deliveryTime) == 0
    ) {
      return false;
    } else if (
      stepTitle == $scope.Steps.user_detail &&
      jQuery("#" + stepTitle).valid() == false
    ) {
      return false;
    } else if (
      stepTitle == $scope.Steps.address_detail &&
      jQuery("#" + stepTitle).valid() == false
    ) {
      return false;
    } else if (
      stepTitle == $scope.Steps.payment_detail &&
      getObjectLength($scope.localData.paymentDetails) == 0
    ) {
      return false;
    }

    return true;
  }

  function getUserPaymentDetails() {
    let req = {
      method: "POST",
      url: ajaxUrl,
      data: $httpParamSerializer({
        action: !$scope.isUserLoggedIn ? "ajax_call" : "authenticate_ajax_call",
        sub_action: "vaults",
        user_id: !$scope.isUserLoggedIn ? $scope.localData.userDetails.id : -1
      }),
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      }
    };

    $scope.paymentErr = false;

    $http(req)
      .then(function(response) {
        var res = response.data;
        console.log(res);

        if (res.Success == true) {
          var data = res.data;
          if (data && data.vault && data.vault.length > 0) {

            extractDefaultVault(data.vault);

            if (!$scope.isUserLoggedIn) {
              $scope.localData.paymentDetails = $scope.getPayment;

              // Save local storage
              let obj = JSON.stringify($scope.localData);
              saveLocalData(obj);

              $scope.Wizard.next();
            }
            //getVault($scope.getPayment.vault_id);
          } else {
            $scope.paymentErr = true;
            $scope.paymentErrorMessage = "Please add payment before proceeding";
          }
        }
      })
      .catch(function(err) {
        console.log(err);
      });
  }

  function getVault(id) {
    $scope.loading = true;

    let req = {
      method: "POST",
      url: ajaxUrl,
      data: $httpParamSerializer({
        action: "authenticate_ajax_call",
        sub_action: "vaultById",
        vault_id: id
      }),
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      }
    };

    $http(req)
      .then(function(response) {
        $scope.loading = false;
        var res = response.data;
        console.log(res.data);
        if (res.Success == true) {
          $scope.getPayment = res.data;
        }
      })
      .catch(function(err) {
        $scope.loading = false;
        console.log(err);
      });
  }

  function saveUserDetails() {
    if (!validationByStepTitle($scope.Steps.user_detail)) return;

    $scope.loading = true;

    var userData = $scope.localData.userDetails;
    let data = {
      id: userData.id,
      full_name: userData.full_name,
      email: userData.email,
      password: userData.password,
      phone: userData.phone,
      sex: userData.sex,
      action: "ajax_call",
      sub_action: "register"
    };

    let req = {
      method: "POST",
      url: ajaxUrl,
      data: $httpParamSerializer(data),
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      }
    };

    $scope.userErr = false;
    $scope.loading = true;
    $http(req)
      .then(function(response) {
        $scope.loading = false;

        var res = response.data;
        console.log(res.data);

        if (res.Success == true) {
          if (!$scope.isUserLoggedIn) {
            $scope.localData.userDetails.id = res.data.id;
            // Save local storage
            let obj = JSON.stringify($scope.localData);
            saveLocalData(obj);
          }
          $scope.Wizard.next();
        } else {
          $scope.userErr = true;
          $scope.userErrorMessage = res.Message;
        }
      })
      .catch(function(error) {
        $scope.loading = false;
        let err = error.data;
        $scope.userErr = false;
        $scope.userErrorMessage = err[0].message;
      });
  }

  function saveAddressDetails() {
    if (!validationByStepTitle($scope.Steps.address_detail)) return;

    $scope.loading = true;

    let data = {
      id: $scope.getAddress != null ? $scope.getAddress.id : -1,
      customer_id: !$scope.isUserLoggedIn
        ? $scope.localData.userDetails.id
        : -1,
      street_name: $scope.localData.addressDetails.street_name,
      floor: $scope.localData.addressDetails.floor,
      pobox: $scope.localData.addressDetails.pobox,
      city_id: $scope.localData.addressDetails.city_id,
      unit_number: $scope.localData.addressDetails.unit_number,
      as_default: "0",
      action: !$scope.isUserLoggedIn ? "ajax_call" : "authenticate_ajax_call",
      sub_action: "create_address"
    };

    let req = {
      method: "POST",
      url: ajaxUrl,
      data: $httpParamSerializer(data),
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      }
    };

    $scope.addressErr = false;

    $http(req)
      .then(function(response) {
        $scope.loading = false;
        var res = response.data;

        if (res.Success == true) {
          $scope.AllAddresses.push(res.data);
          $scope.getAddress = res.data;

          if (!$scope.isUserLoggedIn) {
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
      })
      .catch(function(error) {
        $scope.loading = false;
        let err = error.data;
        $scope.addressErr = true;
        $scope.addressErrorMessage = err[0].message;
        // console.log(error);
      });
  }

  function extractDefaultAddress(addresses) {
    $scope.AllAddresses = addresses;

    var address = addresses.find(function(adr){
      return adr.as_default == 1;
    });

    if(address && address !== null) {
      $scope.getAddress = address;
    } else {
      $scope.getAddress = addresses[0];
    }
  }

  function extractDefaultVault(vaults) {
    $scope.AllPayments = vaults;

    var vault = vaults.find(function(vlt){
      return vlt.as_default == 1;
    });

    if(vault && vault !== null) {
      $scope.getPayment = vault;
    } else {
      $scope.getPayment = vaults[0];
    }
  }



  /* End of Common Functions */

  $scope.changeVault = function(vault) {
    $scope.getPayment = vault;
    jQuery("#vaultChangeModal").modal("hide");
  }

  $scope.changeAddress = function(address) {
    $scope.getAddress = address;
    jQuery("#addressChangeModal").modal("hide");
  }

  /* Perform Action contains multiple actions */
  $scope.performAction = function(action, value) {
    switch (action) {
      case "SAVE_PICKUP_DATE":
        $scope.localData.pickupDate = value;
        break;

      case "SELECT_PICKUP_TIME":
        $scope.localData.pickupTime = value;
        break;

      case "SELECT_PICKUP_AT_DOOR":
        $scope.localData.pickupTime = {};
        $scope.localData.pickupTime.leaveAtdoor = "y";
        break;

      case "SAVE_DELIVERY_DATE":
        $scope.localData.deliveryDate = value;
        break;

      case "SELECT_DELIVERY_TIME":
        $scope.localData.deliveryTime = value;
        break;

      case "SELECT_DELIVERY_AT_DOOR":
        $scope.localData.deliveryTime = {};
        $scope.localData.deliveryTime.leaveAtdoor = "y";
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
  };

  /* Create Order */
  $scope.createOrder = function() {
    $scope.err = false;

    if (!$scope.getAddress) {
      $scope.err = true;
      $scope.errorMessage = "Please add address details";
      return;
    }

    if (!$scope.getPayment) {
      $scope.err = true;
      $scope.errorMessage = "Please add payment details";
      return;
    }

    var confuseDatepickup = $scope.localData.pickupDate.date;
    var simpleDatepickup = new Date(confuseDatepickup)
      .toISOString()
      .substr(0, 10);
    var confuseDate = $scope.localData.deliveryDate.date;
    var simpleDate = new Date(confuseDate).toISOString().substr(0, 10);

    let data = {
      payment_id: $scope.getPayment.id,
      status: "0",
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
      address_id: $scope.getAddress.id,
      same_day_pickup: $scope.localData.pickupDate.name == "Today" ? "1" : "0",
      next_day_drop:
        $scope.localData.deliveryDate.name == "next day deliever" ? "1" : "0",
      comments: null,
      customer_id: !$scope.isUserLoggedIn
        ? $scope.localData.userDetails.id
        : -1,
      pickup_at_door: $scope.localData.pickupTime.leaveAtdoor == "y" ? 1 : 0,
      drop_at_door: $scope.localData.deliveryTime.leaveAtdoor == "y" ? 1 : 0,
      action: !$scope.isUserLoggedIn ? "ajax_call" : "authenticate_ajax_call",
      sub_action: "create_order"
    };

    for (let key in data) {
      if (!data[key]) {
        data[key] = "0";
      }
    }

    let req = {
      method: "POST",
      url: ajaxUrl,
      data: $httpParamSerializer(data),
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      }
    };

    $scope.showLoading = true;
    $http(req)
      .then(function(response) {
        $scope.showLoading = false;
        var res = response.data;
        if (res.Success == true) {
          $scope.orderCreationDone = true;
          $timeout(function() {
            removeLoalStorageAndGoToDashboard();
          }, 3000);
        } else {
          $scope.err = true;
          $scope.errorMessage = res.Message;
        }
      })
      .catch(function(error) {
        $scope.showLoading = false;
        let err = error.data;
        console.log(error);
        $scope.err = true;
        $scope.errorMessage = err[0].message;
      });
  };

  /* Cancel Order */
  $scope.onCancelOrder = function() {

    if(getObjectLength($scope.localData.pickupDate) > 0) {
      var confirmation = confirm("Do you want to cancel order ?");

      if (confirmation) {
        removeLoalStorageAndGoToDashboard();
      }
    } else {
      jQuery('#requestPickupModal').modal('hide');
    }
  };

  // save onto local storage closed
  function getLocalStorageData() {
    var order = localStorage.getItem(getLocalStorageKeyOfOrder());

    let obj = {};
    if (order) {
      obj = JSON.parse(order);
      return obj;
    }
    return null;
  }

  function getObjectLength(obj) {
    if (!obj) return 0;
    return Object.keys(obj).length;
  }

  function removeLoalStorageAndGoToDashboard() {
    localStorage.removeItem(getLocalStorageKeyOfOrder());
    window.location.reload();
  }

  function saveLocalData(data) {
    localStorage.setItem(getLocalStorageKeyOfOrder(), data);
  }

  function getLocalStorageKeyOfOrder() {
    var key = "Myorder";
    if ($scope.isUserLoggedIn) {
      key = "Myorder_" + userId;
    }

    return key;
  }
});
