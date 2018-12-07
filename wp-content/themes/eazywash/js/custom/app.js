var app = angular.module("laundryApp", ["ngStorage", "ngCookies", "ngRoute", "ngValidate", "mgo-angular-wizard", "pascalprecht.translate"]);

app.config(function($translateProvider, $validatorProvider) {
  $translateProvider.preferredLanguage('en');
  $translateProvider.registerAvailableLanguageKeys(['en', 'dm'], {
      'en': 'en',
      'dm': 'dm'
  });

  $translateProvider.useStaticFilesLoader({
      prefix: translationFolderPath,
      suffix: '.json'
  });

  $translateProvider.useSanitizeValueStrategy(null);

  $validatorProvider.addMethod("lettersonly", function (value, element) {
      return this.optional(element) || /^[a-z. ]+$/i.test(value);
  }, "Letters only please");
});

app.run(function($rootScope, $translate, $filter, CommonService, LocalDataService) {
  $rootScope.Languages = {
    'en': 'English',
    'dm': 'Denmark'
  };

  $rootScope.SelectedLang = 'en';

  var langauage = LocalDataService.getLanguageFromLocal();

  if (langauage) {
    $rootScope.SelectedLang = langauage;
  }
  
  $translate.use($rootScope.SelectedLang);
 
  $rootScope.CardTypes = {
    "MC": "Master Card",
    "VISA": "VISA Card",
    "DK": "Dankort Card",
    "V-DK": "VISA/Dankort Card",
    "ELEC": "VISA Electron Card"
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
        required: $filter('translate')('validation_message_email_required'),
        email: $filter('translate')('validation_message_email_invalid')
      },
      password: {
        required: $filter('translate')('validation_message_password_required')
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
        required: $filter('translate')('validation_message_fullname_required'),
        lettersonly: $filter('translate')('validation_message_lettersonly')
      },
      email: {
        required: $filter('translate')('validation_message_email_required')
      },
      phone: {
        required: $filter('translate')('validation_message_phone_required')
      },
      password: {
        required: $filter('translate')('validation_message_password_required')
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
        required: $filter('translate')('validation_message_street_required')
      },
      floor: {
        required: $filter('translate')('validation_message_floor_required')
      },
      pobox: {
        required: $filter('translate')('validation_message_pobox_required')
      },
      city: {
        required: $filter('translate')('validation_message_city_required')
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
        required: $filter('translate')('validation_message_old_password_required')
      },
      newpassword: {
        required: $filter('translate')('validation_message_new_password_required'),
        minimum: $filter('translate')('validation_message_minimum_six')
      },
      confirmpassword: {
        required: $filter('translate')('validation_message_password_mismatch'),
        equalTo: $filter('translate')('validation_message_equalTo')
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
});


app.factory("CommonService", function ($http, $q, $httpParamSerializer) {
    var LOCALSTORAGE_LANGUAGE = "locale";

    return {
      CallAjaxUsingPostRequest: function (url, dataObject) {
          var defer = $q.defer();
          $http({
              method: 'POST',
              url: url,
              data: $httpParamSerializer(dataObject),
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
          }).success(function (data, status, header, config) {
              defer.resolve(data);
          }).error(function (data, status, header, config) {
              defer.reject(status);
          });
          return defer.promise;
      },
      CallAjaxUsingGetRequest: function (url) {
          var defer = $q.defer();
          $http({
              method: 'GET',
              url: url
          }).success(function (data, status, header, config) {
              defer.resolve(data);
          }).error(function (data, status, header, config) {
              defer.reject(status);
          });
          return defer.promise;
      },
      GenerateAddPaymentForm: function(userId) {
        return '<FORM ACTION="https://payment.architrade.com/paymentweb/start.action" METHOD="POST" CHARSET="UTF -8"> \
                    <INPUT TYPE="hidden" NAME="accepturl" VALUE="'+ baseUrl +'vault/createvaultweb"> \
                    <INPUT TYPE="hidden" NAME="callbackurl" VALUE=""> \
                    <INPUT TYPE="hidden" NAME="amount" VALUE="1"> \
                    <INPUT TYPE="hidden" NAME="currency" VALUE="578"> \
                    <INPUT TYPE="hidden" NAME="merchant" VALUE="90246240"> \
                    <INPUT TYPE="hidden" NAME="orderid" id="orderid" VALUE="' + userId +'"> \
                    <INPUT TYPE="hidden" NAME="lang" VALUE="EN"> \
                    <INPUT TYPE="hidden" NAME="preauth" VALUE="1"> \
                    <INPUT TYPE="hidden" NAME="test" VALUE="1"> \
                    <INPUT TYPE="hidden" NAME="decorator" VALUE="responsive" /> \
                    <INPUT type="Submit" id="submit" name="submit" style="visibility:hidden"> \
                </FORM> \
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> \
                <script>$("#submit").click();</script>';
      }
    };
});



app.factory("LocalDataService", function ($cookies, $localStorage) {
    var LOCALSTORAGE_LANGUAGE = "locale";
    var LOCAL_PREFIX_MYORDER = "myorder";

    return {
      storeLanguageLocal(language) {
          $localStorage[LOCALSTORAGE_LANGUAGE] = language;
      },
      getLanguageFromLocal() {
          var language = $localStorage[LOCALSTORAGE_LANGUAGE];

          if (!language) {
              return false;
          }
          return language;
      },
      saveOrderData: function(data) {
        if(is_user_logged_in) {
            $localStorage[LOCAL_PREFIX_MYORDER + "_"+ logged_in_user_id] = data;
        } else {
            var date = new Date();
            var expireDate = new Date(date.setHours(date.getHours()+1)).toUTCString();

            $cookies.put(LOCAL_PREFIX_MYORDER, data ,{
                expires: expireDate
            });
        }
      },
      getOrderData: function(data) {
        var orderDetails;

        if(is_user_logged_in) {
            orderDetails = $localStorage[LOCAL_PREFIX_MYORDER + "_"+ logged_in_user_id];
        } else {
            orderDetails = $cookies.get(LOCAL_PREFIX_MYORDER);
        }

        if(!orderDetails) {
            return false;
        }
        return orderDetails;
      },
      removeOrderData: function() {
        if(is_user_logged_in) {
            delete $localStorage[LOCAL_PREFIX_MYORDER + "_"+ logged_in_user_id];
        } else {
            $cookies.remove(LOCAL_PREFIX_MYORDER);
        }
      },
      removeUserData: function() {
        delete $localStorage[LOCAL_PREFIX_MYORDER + "_"+ logged_in_user_id];
      }
    };
});


app.directive('itemFloatingLabel', function() {
  return {
    restrict: 'C',
    link: function(scope, element) {
      var el = element[0];
      var input = el.querySelector('input, textarea');
      var inputLabel = el.querySelector('.input-label');

      if (!input || !inputLabel) return;

      var onInput = function() {
        if (input.value) {
          inputLabel.classList.add('has-input');
        } else {
          inputLabel.classList.remove('has-input');
        }
      };

      input.addEventListener('input', onInput);

      

      scope.$on('$destroy', function() {
        input.removeEventListener('input', onInput);
      });
    }
  };
});

