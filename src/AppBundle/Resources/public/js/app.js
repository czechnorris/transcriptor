var app = angular.module('TranscriptorApp', ['ngMaterial']);

app.controller('TranscriptionCtrl', function($scope, $http) {
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
    }
});