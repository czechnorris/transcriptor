var app = angular.module('TranscriptorApp', ['ngMaterial']);

app.controller('TranscriptionCtrl', function($scope, $http, $window) {

    $scope.user = $window.sessionStorage.getItem('user');

    $http.get('api/v1/languages.json').success(function (data) {
        $scope.languages = [];
        data.languages.forEach(function(language) {
           $scope.languages.push({'value': language.code, 'label': language.name});
        });
        $scope.languages.sort(function(a, b) {
            if (a.label > b.label) {
                return 1;
            }
            if (a.label < b.label) {
                return -1;
            }
            return 0;
        });
    });

    $scope.transcribe = function() {
        if (!$scope.sourceText || !$scope.sourceLanguage || !$scope.targetLanguage) {
            return;
        }
        $http.get('api/v1/transcription.json', {
            'params': {
                'method': 'tree',
                'sourceLanguage': $scope.sourceLanguage,
                'targetLanguage': $scope.targetLanguage,
                'text': $scope.sourceText
            }
        }).success(function(data) {
            $scope.targetText = data.transcriptions[0];
        });
    };

    $scope.getRules = function() {
        if (!$scope.sourceLanguage || !$scope.targetLanguage) {
            return;
        }
        $http.get('api/v1/rules.json', {
            'params': {
                'sourceLanguage': $scope.sourceLanguage,
                'targetLanguage': $scope.targetLanguage
            }
        }).success(function(data) {
            $scope.rules = data.rules;
        });
    };

    $scope.toggleEditRule = function(rule) {
        if (rule.hasOwnProperty('editMode') && rule.editMode) {
            rule.editMode = false;
        } else {
            rule.editMode = true;
        }
    };

    $scope.editRule = function(rule) {
        delete rule.editMode;
        $http.put('api/v1/rules/' + rule.id + '.json', {
            'rule': rule
        }).success(function() {
            $http.get('api/v1/rules/' + rule.id + '.json').success(function(data) {
                rule = data.rule;
            });
        });
    };

    $scope.login = function() {
        $http.get('api/v1/users/me.json')
            .success(function(data) {
                $window.sessionStorage.setItem('user', data.user);
                $scope.user = data.user;
                return true;
            });
    };

});
