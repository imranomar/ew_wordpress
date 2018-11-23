var app = angular.module("laundryApp", ["ngStorage", "ngRoute", "mgo-angular-wizard", "pascalprecht.translate"]);

app.config(function($translateProvider) {
  $translateProvider.preferredLanguage('en');
  $translateProvider.registerAvailableLanguageKeys(['en', 'dm'], {
      'en': 'en',
      'dm': 'dm'
  });

  $translateProvider.useStaticFilesLoader({
      prefix: 'http://localhost/eazywash/wp-content/themes/eazywash/translations/',
      suffix: '.json'
  });

  $translateProvider.useSanitizeValueStrategy(null);
});

app.run(function($rootScope, $translate, updateFCMToken, CommonService) {

  $rootScope.Languages = {
    'en': 'English',
    'dm': 'Denmark'
  };

  $rootScope.SelectedLang = 'en';

  var langauage = CommonService.getLanguageFromLocal();

  if (langauage) {
      $rootScope.SelectedLang = langauage;
      $translate.use(langauage);
  }

  if(localStorage.getItem('laundryUser')){
    updateFCMToken.test();
  }
});

// http://thisisbig.ae/advanced/backend/web/
app.factory('appInfo', function () {
  return {
      url: 'http://localhost/advanced/backend/web/'
  }
});

app.factory("CommonService", function ($localStorage) {
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
      }
    };
});

app.factory('updateFCMToken', function (appInfo, $httpParamSerializer,$http) {
  return {
    test: function(){
      if(!window.cordova){
         return;
      }
      FCMPlugin.getToken(function(token){
        let x = localStorage.getItem('laundryUser');
        let data = {
          token: token,     
        };
        let req = {
            method: 'PUT',
            url: appInfo.url+'customersapi/update/?id='+x,
            data: $httpParamSerializer(data),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }
        $http(req)
          .then(function(res){
            console.log(res);
          }).catch(function(error){
              console.log(error);      
        })
      });
    }
  }
  
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

