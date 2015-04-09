<!DOCTYPE html>
<html ng-app="TranscriptorApp">
    <head>
        <meta charset="utf-8">
        <title>Transcriptor</title>
        <link rel="stylesheet" href="/vendor/angular-material/angular-material.min.css">
        <script src="/vendor/angular/angular.min.js"></script>
        <script src="/vendor/angular-animate/angular-animate.min.js"></script>
        <script src="/vendor/angular-aria/angular-aria.min.js"></script>
        <script src="/vendor/angular-material/angular-material.min.js"></script>
        <script src="/bundles/app/js/app.js"></script>
    </head>
    <body layout="column">
        <md-toolbar layout="row">
            <button ng-click="toggleSidenav('left')" hide-gt-sm class="menuBtn">
                <span class="visually-hidden">Menu</span>
            </button>
            <h1 class="md-toolbar-tools" layout-align-gt-sm="center">Hello World</h1>
        </md-toolbar>
        <div layout="row" flex>
            <md-sidenav layout="column" class="md-sidenav-left md-whiteframe-z2" md-component-id="left" md-is-locked-open="$mdMedia('gt-sm')"></md-sidenav>
            <div layout="column" flex id="content">
                <md-content layout="column" flex class="md-padding">
                    Content hýr
                </md-content>
            </div>
        </div>
    </body>
</html>