<!DOCTYPE html>
<html ng-app="TranscriptorApp">
    <head>
        <meta charset="utf-8">
        <title>Transcriptor</title>
        <link rel="stylesheet" href="/vendor/angular-material/angular-material.min.css">
        <link rel="stylesheet" href="/bundles/app/css/app.css">
        <link rel="icon" type="image/png" href="/bundles/app/img/logo32.png">
        <script src="/vendor/angular/angular.min.js"></script>
        <script src="/vendor/angular-animate/angular-animate.min.js"></script>
        <script src="/vendor/angular-aria/angular-aria.min.js"></script>
        <script src="/vendor/angular-material/angular-material.min.js"></script>
        <script src="/bundles/app/js/app.js"></script>
    </head>
    <body layout="column" ng-controller="TranscriptionCtrl">
        <md-toolbar layout="row">
            <button ng-click="toggleSidenav('left')" hide-gt-sm class="menuBtn">
                <span class="visually-hidden">Menu</span>
            </button>
            <h1 class="md-toolbar-tools" layout-align-gt-sm="center">
                <md-icon md-svg-src="/bundles/app/img/logo2.svg" class="s36" alt="logo"></md-icon>
                <span>Transcriptor</span>
            </h1>
        </md-toolbar>
        <div layout="row" flex>
            <md-sidenav layout="column" class="md-sidenav-left md-whiteframe-z2" md-component-id="left" md-is-locked-open="$mdMedia('gt-sm')"></md-sidenav>
            <div layout-gt-sm="row" layout="column" flex id="content">
                <md-content layout="column" flex id="sourceBox">
                    <md-select placeholder="Pick" ng-model="sourceLanguage" ng-change="transcribe()">
                        <md-option ng-repeat="language in languages" value="{{language.value}}">{{language.label}}</md-option>
                    </md-select>
                    <textarea ng-model="sourceText" ng-change="transcribe()"></textarea>
                </md-content>
                <md-content layout="column" flex id="targetBox">
                    <md-select placeholder="Pick" ng-model="targetLanguage" ng-change="transcribe()">
                        <md-option ng-repeat="language in languages" value="{{language.value}}">{{language.label}}</md-option>
                    </md-select>
                    <textarea ng-model="targetText"></textarea>
                </md-content>
            </div>
        </div>
    </body>
</html>