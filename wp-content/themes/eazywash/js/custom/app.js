var app = angular.module("laundryApp", [
  "ngStorage",
  "ngCookies",
  "ngRoute",
  "ngValidate",
  "mgo-angular-wizard",
  "pascalprecht.translate",
  "ui.mask"
]);

app.config(function($translateProvider, $validatorProvider) {
  $translateProvider.preferredLanguage("en");
  $translateProvider.registerAvailableLanguageKeys(["en", "dm"], {
    en: "en",
    dm: "dm"
  });

  $translateProvider.useStaticFilesLoader({
    prefix: translationFolderPath,
    suffix: ".json"
  });

  $translateProvider.useSanitizeValueStrategy(null);

  $validatorProvider.addMethod(
    "lettersonly",
    function(value, element) {
      return this.optional(element) || /^[a-z. ]+$/i.test(value);
    },
    "Letters only please"
  );

  $validatorProvider.addMethod(
    "phonenumber",
    function(value, element) {
      var phoneNumber = value.replace(/-/g, '');
      return this.optional(element) || /^[0-9]+$/i.test(value) || phoneNumber.length == 8;
    },
    "Phone number is invalid"
  );
});

app.run(function(
  $rootScope,
  $translate,
  $filter,
  CommonService,
  LocalDataService
) {
  $rootScope.serviceOfferedToCity = "copenhagen";

  $rootScope.Languages = {
    en: "English",
    dm: "Denmark"
  };

  $rootScope.SelectedLang = "en";

  var langauage = LocalDataService.getLanguageFromLocal();

  if (langauage) {
    $rootScope.SelectedLang = langauage;
  }

  $translate.use($rootScope.SelectedLang);

  $rootScope.CardTypes = {
    MC: "Master Card",
    VISA: "VISA Card",
    DK: "Dankort Card",
    "V-DK": "VISA/Dankort Card",
    ELEC: "VISA Electron Card"
  };

  var date = new Date();
  $rootScope.currentYear = date.getFullYear();
});

app.factory("CommonService", function($http, $q, $httpParamSerializer) {
  var LOCALSTORAGE_LANGUAGE = "locale";

  return {
    CallAjaxUsingPostRequest: function(url, dataObject) {
      var defer = $q.defer();
      $http({
        method: "POST",
        url: url,
        data: $httpParamSerializer(dataObject),
        headers: { "Content-Type": "application/x-www-form-urlencoded" }
      })
        .success(function(data, status, header, config) {
          defer.resolve(data);
        })
        .error(function(data, status, header, config) {
          defer.reject(status);
        });
      return defer.promise;
    },
    CallAjaxUsingGetRequest: function(url) {
      var defer = $q.defer();
      $http({
        method: "GET",
        url: url
      })
        .success(function(data, status, header, config) {
          defer.resolve(data);
        })
        .error(function(data, status, header, config) {
          defer.reject(status);
        });
      return defer.promise;
    },
    GenerateAddPaymentForm: function(userId) {
      return (
        '<FORM ACTION="https://payment.architrade.com/paymentweb/start.action" METHOD="POST" CHARSET="UTF -8"> \
                    <INPUT TYPE="hidden" NAME="accepturl" VALUE="' +
        baseUrl +
        'vault/createvaultweb"> \
                    <INPUT TYPE="hidden" NAME="callbackurl" VALUE=""> \
                    <INPUT TYPE="hidden" NAME="amount" VALUE="1"> \
                    <INPUT TYPE="hidden" NAME="currency" VALUE="578"> \
                    <INPUT TYPE="hidden" NAME="merchant" VALUE="90246240"> \
                    <INPUT TYPE="hidden" NAME="orderid" id="orderid" VALUE="' +
        userId +
        '"> \
                    <INPUT TYPE="hidden" NAME="lang" VALUE="EN"> \
                    <INPUT TYPE="hidden" NAME="preauth" VALUE="1"> \
                    <INPUT TYPE="hidden" NAME="test" VALUE="1"> \
                    <INPUT TYPE="hidden" NAME="decorator" VALUE="responsive" /> \
                    <INPUT type="Submit" id="submit" name="submit" style="visibility:hidden"> \
                </FORM> \
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> \
                <script>$("#submit").click();</script>'
      );
    }
  };
});

app.factory("LocalDataService", function($cookies, $localStorage) {
  var LOCALSTORAGE_LANGUAGE = "locale";
  var LOCAL_PREFIX_MYORDER = "myorder";
  var LOCAL_PREFIX_INCOMPLETE_ORDER_ID = "incomplete_order_id";

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
      if (is_user_logged_in) {
        $localStorage[LOCAL_PREFIX_MYORDER + "_" + logged_in_user_id] = data;
      } else {
        var date = new Date();
        var expireDate = new Date(
          date.setHours(date.getHours() + 1)
        ).toUTCString();

        $cookies.put(LOCAL_PREFIX_MYORDER, JSON.stringify(data), {
          expires: expireDate
        });
      }
    },
    saveOrderDataForUser: function(user_id, data) {
      $localStorage[LOCAL_PREFIX_MYORDER + "_" + user_id] = data;
    },
    getOrderData: function(data) {
      var orderDetails;

      if (is_user_logged_in) {
        orderDetails =
          $localStorage[LOCAL_PREFIX_MYORDER + "_" + logged_in_user_id];
      } else {
        orderDetails = $cookies.get(LOCAL_PREFIX_MYORDER);
      }

      if (!orderDetails) {
        return null;
      }

      if (is_user_logged_in) {
        return orderDetails;
      } else {
        return JSON.parse(orderDetails);
      }
    },
    removeOrderData: function() {
      debugger;
      if (is_user_logged_in) {
        delete $localStorage[LOCAL_PREFIX_MYORDER + "_" + logged_in_user_id];
      } else {
        $cookies.remove(LOCAL_PREFIX_MYORDER);
      }
    },
    removeGuestUserOrderData: function() {
      $cookies.remove(LOCAL_PREFIX_MYORDER);
    },
    removeUserData: function() {
      delete $localStorage[LOCAL_PREFIX_MYORDER + "_" + logged_in_user_id];
    },
    getIncompleteOrderId: function() {
      var orderId = $localStorage[LOCAL_PREFIX_INCOMPLETE_ORDER_ID];

      if (!orderId) {
        return false;
      }
      return orderId;
    },
    getIncompleteOrderId: function() {
      var orderId
      if (is_user_logged_in) {
        orderId =
          $localStorage[LOCAL_PREFIX_INCOMPLETE_ORDER_ID + "_" + logged_in_user_id];
      } else {
        orderId = $cookies.get(LOCAL_PREFIX_INCOMPLETE_ORDER_ID);
      }

      if (!orderId) {
        return false;
      }
      return orderId;
    },
    saveIncompleteOrderId: function(order_id) {
      if (is_user_logged_in) {
        $localStorage[LOCAL_PREFIX_INCOMPLETE_ORDER_ID + "_" + logged_in_user_id] = order_id;
      } else {
        var date = new Date();
        var expireDate = new Date(
          date.setHours(date.getHours() + 1)
        ).toUTCString();

        $cookies.put(LOCAL_PREFIX_INCOMPLETE_ORDER_ID, order_id, {
          expires: expireDate
        });
      }
    },
  };
});

app.directive('phoneInput', function($filter, $browser) {
  return {
      require: 'ngModel',
      link: function($scope, $element, $attrs, ngModelCtrl) {
          var listener = function() {
              var value = $element.val().replace(/[^0-9]/g, '');
              $element.val($filter('tel')(value, false));
          };

          // This runs when we update the text field
          ngModelCtrl.$parsers.push(function(viewValue) {
              return viewValue.replace(/[^0-9]/g, '').slice(0,10);
          });

          // This runs when the model gets updated on the scope directly and keeps our view in sync
          ngModelCtrl.$render = function() {
              $element.val($filter('tel')(ngModelCtrl.$viewValue, false));
          };

          $element.bind('change', listener);
          $element.bind('keydown', function(event) {
              var key = event.keyCode;
              // If the keys include the CTRL, SHIFT, ALT, or META keys, or the arrow keys, do nothing.
              // This lets us support copy and paste too
              if (key == 91 || (15 < key && key < 19) || (37 <= key && key <= 40)){
                  return;
              }
              $browser.defer(listener); // Have to do this or changes don't get picked up properly
          });

          $element.bind('paste cut', function() {
              $browser.defer(listener);
          });
      }

  };
});