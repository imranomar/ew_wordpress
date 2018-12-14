// App Controller
app.controller("AppController", function(
  $scope,
  $rootScope,
  $translate,
  $filter,
  CommonService,
  LocalDataService,
  $timeout
) {
  $scope.changeLanguage = function(lang) {
    $rootScope.SelectedLang = lang;
    LocalDataService.storeLanguageLocal(lang);
    $translate.use(lang);
  };

  $rootScope.loadAddPaymentMethodForm = function(userId) {
    var formHtml = CommonService.GenerateAddPaymentForm(userId);

    jQuery(".paymentIframeContainer").html("");
    jQuery(".paymentIframeContainer:visible").html(
      '<iframe id="paymentIframe" name="paymentIframe" width="100%" height="450px"></iframe>'
    );
    var doc = document.getElementById("paymentIframe").contentWindow.document;
    doc.open();
    doc.write('<h3 class="text-center">Loading...</h3>' + formHtml);
    doc.close();
  };

  $rootScope.showModal = function(modalId) {
    jQuery(modalId).modal("show");
  };

  $rootScope.closeModal = function(modalId) {
    jQuery(modalId).modal("hide");

    $timeout(function() {
      if (jQuery(".modal:visible").length > 0) {
        jQuery("body").addClass("modal-open");
      }
    }, 500);
  };

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
        required: function() {
          return $filter("translate")("validation_message_email_required");
        },
        email: function() {
          return $filter("translate")("validation_message_email_invalid");
        }
      },
      password: {
        required: function() {
          return $filter("translate")("validation_message_password_required");
        }
      }
    }
  };

  $rootScope.userDetailsValidationOptions = {
    rules: {
      fullname: {
        required: true,
        lettersonly: true
      },
      phone: {
        required: true,
        phonenumber: true,
        minlength: 7
      },
      city: {
        required: true
      }
    },
    messages: {
      fullname: {
        required: function() {
          return $filter("translate")("validation_message_fullname_required");
        },
        lettersonly: function() {
          return $filter("translate")("validation_message_lettersonly");
        }
      },
      phone: {
        required: function() {
          return $filter("translate")("validation_message_phone_required");
        }
      },
      city: {
        required: function() {
          return $filter("translate")("validation_message_city_required");
        }
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
        phonenumber: true,
        minlength: 7
      },
      password: {
        required: true,
        minlength: 6
      }
    },
    messages: {
      fullname: {
        required: function() {
          return $filter("translate")("validation_message_fullname_required");
        },
        lettersonly: function() {
          return $filter("translate")("validation_message_lettersonly");
        }
      },
      email: {
        required: function() {
          return $filter("translate")("validation_message_email_required");
        }
      },
      phone: {
        required: function() {
          return $filter("translate")("validation_message_phone_required");
        }
      },
      password: {
        required: function() {
          return $filter("translate")("validation_message_password_required");
        }
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
      // pobox: {
      //   required: true,
      //   number: true
      // },
      unit_number: {
        required: true
      },
      city: {
        required: true
      }
    },
    messages: {
      street_name: {
        required: function() {
          return $filter("translate")("validation_message_street_required");
        }
      },
      floor: {
        required: function() {
          return $filter("translate")("validation_message_floor_required");
        }
      },
      // pobox: {
      //   required: function() {
      //     return $filter("translate")("validation_message_pobox_required");
      //   }
      // },
      city: {
        required: function() {
          return $filter("translate")("validation_message_city_required");
        }
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
        required: function() {
          return $filter("translate")(
            "validation_message_old_password_required"
          );
        }
      },
      newpassword: {
        required: function() {
          return $filter("translate")(
            "validation_message_new_password_required"
          );
        },
        minimum: function() {
          return $filter("translate")("validation_message_minimum_six");
        }
      },
      confirmpassword: {
        required: function() {
          return $filter("translate")("validation_message_password_mismatch");
        },
        equalTo: function() {
          return $filter("translate")("validation_message_equalTo");
        }
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
  $filter,
  $translate,
  CommonService,
  LocalDataService
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
    if (form.validate()) {
      $scope.err = false;
      $scope.loading = true;

      var request_data = {
        email: $scope.logindata.email,
        password: $scope.logindata.password,
        action: "ajax_call",
        sub_action: "login"
      };

      CommonService.CallAjaxUsingPostRequest(ajaxUrl, request_data)
        .then(
          function(data) {
            if (data.Success == true && data.data != 0) {
              window.location.reload();
            } else {
              $scope.err = true;
              $scope.errorMessage = $filter("translate")(
                "validation_message_login_failed"
              );
            }
          },
          function(error) {}
        )
        .finally(function() {
          $scope.loading = false;
        });
    }
  };
});

//Logout of Controller
app.controller("LogoutCtrl", function($scope, CommonService, LocalDataService) {
  $scope.loading = false;

  $scope.err = false;
  $scope.errorMessage = null;

  $scope.logout = function() {
    $scope.err = false;
    $scope.loading = true;

    CommonService.CallAjaxUsingPostRequest(ajaxUrl, { action: "logout_method" })
      .then(
        function(data) {
          if (data.Success == true) {
            LocalDataService.removeUserData();
            window.location.reload();
          } else {
            $scope.err = true;
            $scope.errorMessage = data.Message;
          }
        },
        function(error) {}
      )
      .finally(function() {
        $scope.loading = false;
      });
  };
});

// Signup of Controller
app.controller("SignupCtrl", function($scope, $httpParamSerializer, $http) {
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
            // let date = new Date();
            // localStorage.setItem("laundryUser", res.data.id);

            // let date1 = new Date(
            //   date.setHours(date.getHours() + 1)
            // ).toUTCString();
            // document.cookie = "laundryCookie=y; expires=" + date1;

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
  $filter,
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
                  $rootScope.closeModal("#addressModal");
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

  $scope.loadVaults = function() {
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
  };
  $scope.deleteAddress = function(addressDetail, index) {
    if (addressDetail && addressDetail !== null) {
      var confirmation = confirm(
        $filter("translate")("address_deletion_confirmation")
      );
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
        $filter("translate")("deletion_confirmation") +
          cardName +
          " " +
          $filter("translate")("vault_details.ends_with") +
          " " +
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
    $rootScope.showModal("#vaultModal");
    $timeout(function() {
      $rootScope.loadAddPaymentMethodForm(logged_in_user_id);
    }, 1000);
  };

  $scope.openAddressModal = function(addressDetail, index) {
    if (addressDetail && addressDetail !== null) {
      tempAddressIndex = index;
      $scope.addressDetails = angular.copy(addressDetail);
    } else {
      defaultAddressFields();
    }
    $rootScope.showModal("#addressModal");
  };

  $scope.displayCityName = function(cityId) {
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

app.controller("PricingCtrl", function($scope, $rootScope, CommonService) {
  var request_data = {
    action: !$scope.isUserLoggedIn ? "ajax_call" : "authenticate_ajax_call",
    sub_action: "pricing"
  };

  $scope.prices = [];
  CommonService.CallAjaxUsingPostRequest(ajaxUrl, request_data)
      .then(
        function(data) {
          if (data.Success == true) {
            var result  = data.data;
            if(result && result.length > 0) {
              $scope.prices = result;
            }
          }
        },
        function(error) {}
      )
      .finally(function() {
        $scope.loading = false;
      });
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
  $timeout,
  CommonService,
  LocalDataService,
  WizardHandler,
  $filter
) {
  $scope.showLoading = true;
  $scope.loading = false;

  let userId = logged_in_user_id;
  $scope.isUserLoggedIn = is_user_logged_in;

  $scope.set_order_system = "FULL"; // 'full' or 'quick'

  $scope.orderCreationDone = false;
  $scope.orderSummary = null;

  $scope.lastStepNumber = $scope.isUserLoggedIn ? 5 : 8;

  $scope.showAddressDetailStep = false;
  $scope.showPaymentDetailStep = false;

  $scope.cityData = [];
  $scope.AllAddresses = [];
  $scope.AllPayments = [];
  $scope.optionsData = null;

  $scope.TimeSlots = [];
  $scope.pickupDateList = [];
  $scope.deliveryDateList = [];

  $scope.getAddress = null;
  $scope.getPayment = null;

  $scope.orderSummary = null;
  $scope.orderCreationDone = false;

  $scope.Wizard = null;
  $scope.stepValidation = true;

  var defaultCityId = -1;
  
  $scope.Steps = {
    partial_user_detail: "PartialUserDetail",
    pickup_date: "PickupDate",
    pickup_time: "PickupTime",
    drop_date: "DropDate",
    drop_time: "DropTime",
    user_detail: "UserDetail",
    address_detail: "AddressDetail",
    payment_detail: "PaymentDetail",
    order_summary: "OrderSummary"
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

  loadDefaults();

  function loadDefaults() {
    $scope.err = false;
    $scope.errorMessage = null;
  
    $scope.userErr = false;
    $scope.userErrorMessage = null;
  
    $scope.addressErr = false;
    $scope.addressErrorMessage = null;
  
    $scope.paymentErr = false;
    $scope.paymentErrorMessage = null;

    $scope.showAlldeliveryDateList = false;  
    $scope.showAllpickupDateList = false;

    //  localstorage keys
    $scope.localData = {
      pickupDate: {},
      pickupTime: {},
      deliveryDate: {},
      deliveryTime: {},
      userDetails: {},
      addressDetails: {},
      paymentDetails: {}
    };

    $scope.userDetails =  {
      id: null,
      full_name: null,
      email: null,
      password: null,
      phone: null
    };

    $scope.addressDetails = {
      id: null,
      street_name: null,
      floor: null,
      pobox: null,
      unit_number: null,
      city_id: defaultCityId != -1? String(defaultCityId): null,
      as_default: null
    };
  }

  initializeOrderCreation();

  function initializeOrderCreation() {
    if (getLocalStorageData()) {
      $scope.localData = getLocalStorageData();
    }

    var request_data = {
      action: "order_creation_data",
      customer_id: getObjectLength($scope.localData) > 0 ? $scope.localData.userDetails.id : -1
    };

    CommonService.CallAjaxUsingPostRequest(ajaxUrl, request_data)
      .then(
        function(response) {
          if (response.Success == true) {
            if (response.cities && response.cities.length > 0) {
              $scope.cityData = response.cities;

              var cityDetails = $scope.cityData.find(x => x.title == $rootScope.serviceOfferedToCity);

              if(cityDetails && cityDetails.id > 0) {
                defaultCityId = cityDetails.id;
                $scope.addressDetails.city_id = String(defaultCityId);
              }
            }

            if (response.options && response.options.length > 0) 
              $scope.optionsData = response.options[0];

            if (response.timeslots && response.timeslots.length > 0)
              $scope.TimeSlots = response.timeslots;

            if ($scope.isUserLoggedIn == true) {
              if (response.addresses && response.addresses.length > 0) {
                extractDefaultAddress(response.addresses);
              } else {
                $scope.showAddressDetailStep = true;
                $scope.lastStepNumber += 1;
              }

              if (response.vaults && response.vaults.length > 0) {
                extractDefaultVault(response.vaults);
              } else {
                $scope.showPaymentDetailStep = true;
                $scope.lastStepNumber += 1;
              }
            } else {
              if (response.addresses && response.addresses.length > 0) {
                $scope.AllAddresses = response.addresses;
              }

              if (response.vaults && response.vaults.length > 0) {
                $scope.AllPayments = response.vaults;
              }
            }
          }
        },
        function(error) {}
      )
      .finally(function() {
        $scope.showLoading = false;
      });
  }

  $scope.initializeWizard = function() {
    functionForPickupDate();

    $scope.Wizard = WizardHandler.wizard("requestPickupWizard");

    if (getLocalStorageData()) {
      $rootScope.showModal("#requestPickupModal");

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
        $scope.localData.addressDetails.street_name != null
      ) {
        goToStep = 6;
      } else if (
        !$scope.isUserLoggedIn &&
        $scope.localData.userDetails.email != null
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
      } else if(getObjectLength($scope.localData.userDetails) != 0 &&
                $scope.localData.userDetails.id > 0){
        goToStep = 0;
      }

      if(!$scope.isUserLoggedIn)
        goToStep += 1;

      $scope.goToStep(goToStep);
    }
  };

  $scope.validateStep = function() {
    if ($scope.stepValidation == true) {
      var step = $scope.Wizard.currentStep();
      var stepTitle = step.wzHeadingTitle;

      return validationByStepTitle(stepTitle);
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
        //$scope.showAllpickupDateList = false;
        
      break;

      case $scope.Steps.pickup_time:
        console.log("second");
      break;

      case $scope.Steps.drop_date:
        //$scope.showAlldeliveryDateList = false;
        functionForDropDate();
      break;

      case $scope.Steps.partial_user_detail:
        if(getObjectLength($scope.localData.userDetails) != 0) {
          $scope.userDetails = angular.copy($scope.localData.userDetails);
        }
        

        if(getObjectLength($scope.localData.addressDetails) != 0) {
          $scope.addressDetails = angular.copy($scope.localData.addressDetails);
        }
      break;

      case $scope.Steps.user_detail:
        $scope.userDetails = angular.copy($scope.localData.userDetails);
      break;

      case $scope.Steps.address_detail:
        $scope.addressDetails = angular.copy($scope.localData.addressDetails);
      break;

      case $scope.Steps.payment_detail:
        $timeout(function() {
          functionForPaymentDetail();
        }, 1000);
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

    let name = "";
    let price = "";
    let label = "";

    for (var i = 0; i < 16 + length; i++) {
      name = "";
      price = "";
      label = "";

      date = new Date();
      let d = new Date(date.setDate(date.getDate() + i));
      if (d.getDate() == new Date().getDate()) {
        // if  day is tomorrow
        name = "Today";
        price = $scope.optionsData.same_day_pickup_price;
      } else if (d.getDate() == new Date().getDate() + 1) {
        // if day is day after
        name = "Tomorrow";
      } else if (d.getDate() == new Date().getDate() + 2) {
        // if day is day after
        name = "Day After Tomorrow";
      } else {
        name = days[d.getDay()];
      }

      label = ordinal_suffix_of(d.getDate()) + " " + months[d.getMonth()];

      array.push({
        date: d,
        name: name,
        price: price,
        shortDate: label
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

    let name = "";
    let price = "";
    let label = "";

    for (var i = 0; i < 16 + length; i++) {
      name = "";
      price = "";
      label = "";

      let d = new Date(date.setDate(date.getDate() + 1));
      if (d.getDate() == new Date().getDate() + 1) {
        // if day is day after
        name = "Tomorrow";
        price = $scope.optionsData.next_day_delivery_price;
      } else if (d.getDate() == pickupD.getDate() + 1) {
        // if  day is tomorrow
        // name = 'day after';
        name = "Next day delievery";
        price = $scope.optionsData.next_day_delivery_price;
      } else {
        name = days[d.getDay()];
      }

      label = ordinal_suffix_of(d.getDate()) + " " + months[d.getMonth()];

      array.push({
        date: d,
        name: name,
        price: price,
        shortDate: label
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
    $rootScope.loadAddPaymentMethodForm(
      !$scope.isUserLoggedIn ? $scope.localData.userDetails.id : userId
    );
  }
  // wizard sixth closed

  // Wizard last step
  $scope.goToStep = function(stepNumber) {
    if ($scope.Wizard) {
      $scope.Wizard.goTo(stepNumber);
    }
  };

  // End Wizard last step

  /* Common Functions */

  function ordinal_suffix_of(i) {
    var j = i % 10,
      k = i % 100;
    if (j == 1 && k != 11) {
      return i + "st";
    }
    if (j == 2 && k != 12) {
      return i + "nd";
    }
    if (j == 3 && k != 13) {
      return i + "rd";
    }
    return i + "th";
  }

  function checkNoServiceCity(city_id) {
    var city = $scope.cityData.find(x => x.id == city_id);
    if(city && $filter('lowercase')(city.title) != 'copenhagen') {
      $rootScope.showModal("#noServiceModal");
      return true;
    }
    return false;
  }

  function validationByStepTitle(stepTitle) {
    if (
      stepTitle == $scope.Steps.partial_user_detail &&
      jQuery("#" + stepTitle).valid() == false
    ) {
      return false;
    } else if (
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
    var request_data = {
      action: !$scope.isUserLoggedIn ? "ajax_call" : "authenticate_ajax_call",
      sub_action: "vaults",
      user_id: !$scope.isUserLoggedIn ? $scope.localData.userDetails.id : -1
    };

    $scope.paymentErr = false;

    CommonService.CallAjaxUsingPostRequest(ajaxUrl, request_data)
      .then(
        function(response) {
          if (response.Success == true) {
            var data = response.data;

            if (data && data.vault && data.vault.length > 0) {
              extractDefaultVault(data.vault);

              if (!$scope.isUserLoggedIn) {
                $scope.localData.paymentDetails = $scope.getPayment;

                // Save local storage
                saveLocalData($scope.localData);

                if (jQuery("#vaultAddModal").is(":visible"))
                  $rootScope.closeModal("#vaultAddModal");
                else $scope.Wizard.next();
              }
            } else {
              $scope.paymentErr = true;
              $scope.paymentErrorMessage =
                "Please add payment before proceeding";
            }
          }
        },
        function(error) {}
      )
      .finally(function() {
        $scope.loading = false;
      });
  }

  function saveUserDetails(partialInfo) {
    debugger;
    if (partialInfo && !validationByStepTitle($scope.Steps.partial_user_detail))
      return;
    else if (!validationByStepTitle($scope.Steps.user_detail)) return;

    $scope.loading = true;
    
    var userData = $scope.userDetails;
    var addressData = $scope.addressDetails;

    var request_data = {};
    if (partialInfo) {
      request_data = {
        id: userData.id,
        full_name: userData.full_name,
        phone: userData.phone,
        sex: "1",
        address_id: addressData.id,
        city_id: addressData.city_id,
        action: "ajax_call",
        sub_action: "save_user_info"
      };
    } else {
      request_data = {
        id: userData.id,
        full_name: userData.full_name,
        email: userData.email,
        password: userData.password,
        phone: userData.phone,
        sex: "1",
        action: "ajax_call",
        sub_action: "register"
      };
    }

    $scope.userErr = false;
    $scope.loading = true;

    CommonService.CallAjaxUsingPostRequest(ajaxUrl, request_data)
      .then(
        function(data) {
          if (data.Success == true) {
            var result = data.data;

            if (!$scope.isUserLoggedIn) {
              if (partialInfo) {
                $scope.userDetails.id = result.id;
                $scope.addressDetails.id = result.address_id;

                var check = checkNoServiceCity(request_data.city_id);
                if(check == true) {
                  return false;
                }

                if($scope.set_order_system == "QUICK") {
                  $scope.localData.userDetails.id = angular.copy($scope.userDetails.id);
                } else {
                  $scope.localData.userDetails = angular.copy($scope.userDetails);
                }

                $scope.localData.addressDetails = angular.copy($scope.addressDetails);
                $scope.getAddress = angular.copy($scope.localData.addressDetails);
              } else {
                $scope.localData.userDetails = angular.copy($scope.userDetails);
              }

              // Save local storage
              saveLocalData($scope.localData);
            }
            $scope.Wizard.next();
          } else {
            $scope.userErr = true;
            $scope.userErrorMessage = data.Message;
          }
        },
        function(error) {}
      )
      .finally(function() {
        $scope.loading = false;
      });
  }

  function saveAddressDetails(nextAllowed) {
    if (nextAllowed && !validationByStepTitle($scope.Steps.address_detail))
      return;
    else if (
      !nextAllowed &&
      !jQuery("#partial_" + $scope.Steps.address_detail).valid()
    )
      return;

    var addressData = $scope.addressDetails;

    var check = checkNoServiceCity(addressData.city_id);
    if(check == true) {
      return false;
    }

    var request_data = {
      id: addressData.id,
      customer_id: !$scope.isUserLoggedIn
        ? $scope.localData.userDetails.id
        : -1,
      street_name: addressData.street_name,
      floor: addressData.floor,
      pobox: addressData.pobox,
      city_id: addressData.city_id,
      unit_number: addressData.unit_number,
      as_default: "1",
      action: !$scope.isUserLoggedIn ? "ajax_call" : "authenticate_ajax_call",
      sub_action: "create_address"
    };

    $scope.loading = true;
    $scope.addressErr = false;

    CommonService.CallAjaxUsingPostRequest(ajaxUrl, request_data)
      .then(
        function(data) {
          if (data.Success == true) {
            var result = data.data;

            $scope.addressDetails = result;

            if(addressData.id > 0) {
              var addressIndex = $scope.AllAddresses.findIndex(x=>x.id == addressData.id);
              if(addressIndex > -1) {
                $scope.AllAddresses[addressIndex] = result;
              } else {
                $scope.AllAddresses.push(result);
              }
            } else {
              $scope.AllAddresses.push(result);
            }

            $scope.getAddress = result;

            if (!$scope.isUserLoggedIn) {
              // Save local storage
              $scope.localData.addressDetails = result;
              saveLocalData($scope.localData);
            }

            if (nextAllowed) $scope.Wizard.next();
            else $scope.changeAddress(result);
          } else {
            $scope.addressErr = true;
            $scope.addressErrorMessage = res.Message;
          }
        },
        function(error) {}
      )
      .finally(function() {
        $scope.loading = false;
      });
  }

  function extractDefaultAddress(addresses) {
    $scope.AllAddresses = addresses;

    var address = addresses.find(function(adr) {
      return adr.as_default == 1;
    });

    if (address && address !== null) {
      $scope.getAddress = address;
    } else {
      $scope.getAddress = addresses[0];
    }
  }

  function extractDefaultVault(vaults) {
    $scope.AllPayments = vaults;

    var vault = vaults.find(function(vlt) {
      return vlt.as_default == 1;
    });

    if (vault && vault !== null) {
      $scope.getPayment = vault;
    } else {
      $scope.getPayment = vaults[0];
    }
  }

  /* End of Common Functions */

  $scope.changeVault = function(vaultDetail) {
    if (vaultDetail.as_default == 1) {
      $scope.getPayment = vaultDetail;

      if (!$scope.isUserLoggedIn) {
        $scope.localData.paymentDetails = vaultDetail;

        saveLocalData($scope.localData);
      }

      $rootScope.closeModal("#vaultChangeModal");
    } else {
      $scope.loading = true;

      var request_data = {};
      request_data.id = vaultDetail.id;
      request_data.action = $scope.isUserLoggedIn
        ? "authenticate_ajax_call"
        : "ajax_call";
      request_data.sub_action = "set_default_vault";
      if (!$scope.isUserLoggedIn)
        request_data.customer_id = $scope.localData.userDetails.id;

      CommonService.CallAjaxUsingPostRequest(ajaxUrl, request_data)
        .then(
          function(data) {
            if (data.Success == true) {
              $scope.AllPayments.map(function(vault) {
                if (vault.id == request_data.id) {
                  return (vault.as_default = 1);
                } else {
                  return (vault.as_default = 0);
                }
              });

              vaultDetail.as_default = "1";
              $scope.getPayment = vaultDetail;

              if (!$scope.isUserLoggedIn) {
                $scope.localData.paymentDetails = vaultDetail;
                saveLocalData($scope.localData);
              }

              $rootScope.closeModal("#vaultAddModal");
              $rootScope.closeModal("#vaultChangeModal");
            }
          },
          function(error) {}
        )
        .finally(function() {
          $scope.loading = false;
        });
    }
  };

  $scope.changeAddress = function(address) {
    $scope.loading = true;

    var request_data = {};
    request_data.id = address.id;
    request_data.action = $scope.isUserLoggedIn
      ? "authenticate_ajax_call"
      : "ajax_call";
    request_data.sub_action = "set_default_address";
    if (!$scope.isUserLoggedIn)
      request_data.customer_id = $scope.localData.userDetails.id;

    CommonService.CallAjaxUsingPostRequest(ajaxUrl, request_data)
      .then(
        function(data) {
          if (data.Success == true) {
            $scope.AllAddresses.map(function(address) {
              if (address.id == request_data.id) {
                return (address.as_default = 1);
              } else {
                return (address.as_default = 0);
              }
            });

            address.as_default = "1";
            $scope.getAddress = address;

            if (!$scope.isUserLoggedIn) {
              $scope.localData.addressDetails = address;
              saveLocalData($scope.localData);
            }

            $rootScope.closeModal("#addressAddModal");
            $rootScope.closeModal("#addressChangeModal");
          }
        },
        function(error) {}
      )
      .finally(function() {
        $scope.loading = false;
      });
  };

  $scope.openAddAddressModal = function() {
    $scope.addressDetails = {
      id: null,
      street_name: null,
      floor: null,
      pobox: null,
      unit_number: null,
      city_id: String(defaultCityId)
    };
    $rootScope.closeModal("#addressChangeModal");

    $rootScope.showModal("#addressAddModal");
  };

  $scope.openAddVaultModal = function() {
    debugger;
    $scope.localData.paymentDetails = {};
    $rootScope.closeModal("#vaultChangeModal");
    $rootScope.showModal("#vaultAddModal");
    $timeout(function() {
      functionForPaymentDetail();
    }, 1000);
  };

  /* Perform Action contains multiple actions */
  $scope.performAction = function(action, value) {
    switch (action) {
      case "SAVE_USER_PARTIAL_INFORMATION":
        saveUserDetails(true);
        return false;
      break;

      case "SAVE_PICKUP_DATE":
          $scope.localData.pickupDate = value;
          $scope.Wizard.next();
        break;

      case "SELECT_PICKUP_TIME":
        $scope.localData.pickupTime = value;
        if(!$scope.isUserLoggedIn && $scope.set_order_system == 'QUICK') {
          $scope.createOrder();
          return false;
        }
        break;

      case "SELECT_PICKUP_AT_DOOR":
        $scope.localData.pickupTime = {};
        $scope.localData.pickupTime.leaveAtdoor = "y";
        if(!$scope.isUserLoggedIn && $scope.set_order_system == 'QUICK') {
          $scope.createOrder();
          return false;
        }
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
        saveUserDetails(false);
        return false;
        break;

      case "SAVE_ADDRESS_DETAILS":
        saveAddressDetails(value);
        return false;
        break;

      case "GET_PAYMENT_DETAILS":
        getUserPaymentDetails();
        return false;
        break;
    }

    saveLocalData($scope.localData);

    // Check Validation
    $scope.checkValidation();
  };

  /* Create Order */
  $scope.createOrder = function() {
    $scope.err = false;

    var request_data = {};
    if ($scope.isUserLoggedIn == true || $scope.set_order_system == "FULL") {
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

      var confuseDate = $scope.localData.deliveryDate.date;
      var simpleDate = new Date(confuseDate).toISOString().substr(0, 10);

      request_data = {
        payment_id: $scope.getPayment.id,
        drop_date: simpleDate,
        drop_time_from: $scope.localData.deliveryTime.time_from,
        drop_time_to: $scope.localData.deliveryTime.time_to,
        drop_price: $scope.localData.deliveryTime.price,
        drop_type: $scope.localData.deliveryTime.type,
        next_day_drop:
          $scope.localData.deliveryDate.name == "next day deliever" ? 1 : 0,
        drop_at_door: $scope.localData.deliveryTime.leaveAtdoor == "y" ? 1 : 0
      };
    }

    var confuseDatepickup = $scope.localData.pickupDate.date;
    var simpleDatepickup = new Date(confuseDatepickup)
      .toISOString()
      .substr(0, 10);


    request_data["pickup_date"] = simpleDatepickup;
    request_data["status"] = "0";
    request_data["pickup_time_from"] = $scope.localData.pickupTime.time_from;
    request_data["pickup_time_to"] = $scope.localData.pickupTime.time_to;
    request_data["pickup_price"] = $scope.localData.pickupTime.price;
    request_data["pickup_type"] = $scope.localData.pickupTime.type;
    request_data["address_id"] = $scope.getAddress.id;
    
    request_data["same_day_pickup"] =
      $scope.localData.pickupDate.name == "Today" ? "1" : "0";
    request_data["comments"] = null;
    request_data["customer_id"] = !$scope.isUserLoggedIn
      ? $scope.localData.userDetails.id
      : -1;
    request_data["pickup_at_door"] =
      $scope.localData.pickupTime.leaveAtdoor == "y" ? 1 : 0;
    request_data["action"] = !$scope.isUserLoggedIn
      ? "ajax_call"
      : "authenticate_ajax_call";
    request_data["sub_action"] = "create_order";

    for (let key in request_data) {
      if (!request_data[key]) {
        request_data[key] = "0";
      }
    }

    $scope.showLoading = true;

    CommonService.CallAjaxUsingPostRequest(ajaxUrl, request_data)
      .then(
        function(data) {
          if (data.Success == true) {
            $scope.orderCreationDone = true;
            $scope.orderSummary = $scope.localData;

            //$timeout(function() {
              removeLoalStorageAndGoToDashboard();
            //}, 3000);
          } else {
            $scope.err = true;
            $scope.errorMessage = data.Message;
          }
        },
        function(error) {
          console.log("error");
          console.log(err);
        }
      )
      .finally(function() {
        $scope.showLoading = false;
      });
  };

  /* Cancel Order */
  $scope.onCancelOrder = function() {
    if (getObjectLength($scope.localData.pickupDate) > 0) {
      var confirmation = confirm(
        $filter("translate")("request_pickup_order_cancel_confirmation")
      );

      if (confirmation) {
        removeLoalStorageAndGoToDashboard();
      } else {
        return false;
      }
    } 
    $rootScope.closeModal("#requestPickupModal");
  };


  $scope.closeOrder = function() {
    $scope.orderCreationDone = false;
    $scope.orderSummary = null;
    $rootScope.closeModal('#requestPickupModal');
  }

  // save onto local storage closed
  function getLocalStorageData() {
    debugger;
    var order = LocalDataService.getOrderData(); //localStorage.getItem(getLocalStorageKeyOfOrder());

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
    LocalDataService.removeOrderData();
    $scope.noValidation();
    loadDefaults();
    //window.location.reload();
  }

  function saveLocalData(data) {
    let obj = JSON.stringify(data);
    LocalDataService.saveOrderData(obj);
  }

  $scope.displayCityName = function(cityId) {
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
