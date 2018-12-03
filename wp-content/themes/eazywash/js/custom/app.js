var app = angular.module("laundryApp", ["ngStorage", "ngRoute", "ngValidate", "mgo-angular-wizard", "pascalprecht.translate"]);

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

app.run(function($rootScope, $translate, CommonService) {

  $rootScope.Languages = {
    'en': 'English',
    'dm': 'Denmark'
  };

  $rootScope.SelectedLang = 'en';

  var langauage = CommonService.getLanguageFromLocal();

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
});


app.factory("CommonService", function ($http, $q, $httpParamSerializer, $localStorage) {
    var LOCALSTORAGE_LANGUAGE = "locale";

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

