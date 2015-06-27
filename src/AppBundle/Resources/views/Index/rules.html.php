<?php $view->extend('AppBundle::layout.html.php'); ?>
<div layout="row" flex="10">
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
<div layout="column">
    <md-list>
        <md-list-item ng-repeat="rule in rules" layout="row">
            <div layout="row" flex ng-if="!rule.editMode">
                <div flex>{{rule.pattern}}</div>
                <div flex>{{rule.replacement}}</div>
                <div flex="10"><md-button ng-click="toggleEditRule(rule)">Edit</md-button></div>
            </div>
            <div layout="row" flex ng-if="rule.editMode">
                <div flex>
                    <md-input-container>
                        <label>Pattern</label>
                        <input ng-model="rule.pattern">
                    </md-input-container>
                </div>
                <div flex>
                    <md-input-container>
                        <label>Replacement</label>
                        <input ng-model="rule.replacement">
                    </md-input-container>
                </div>
                <div flex="10"><md-button ng-click="editRule(rule)">Save</md-button></div>
            </div>
        </md-list-item>
    </md-list>
</div>