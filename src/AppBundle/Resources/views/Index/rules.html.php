<?php $view->extend('AppBundle::layout.html.php'); ?>
<div layout="row">
    <md-content layout="column" flex id="sourceBox">
        <md-select flex placeholder="Pick" ng-model="sourceLanguage" ng-change="getRules()">
            <md-option ng-repeat="language in languages" value="{{language.value}}">{{language.label}}</md-option>
        </md-select>
    </md-content>
    <md-content layout="column" flex id="targetBox">
        <md-select flex placeholder="Pick" ng-model="targetLanguage" ng-change="getRules()">
            <md-option ng-repeat="language in languages" value="{{language.value}}">{{language.label}}</md-option>
        </md-select>
    </md-content>
</div>
<md-content layout="column" flex>
    <md-list>
        <md-list-item ng-repeat="rule in rules" layout="row">
            <div flex>{{rule.pattern}}</div>
            <div flex>{{rule.replacement}}</div>
        </md-list-item>
    </md-list>
</md-content>