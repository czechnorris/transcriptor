<?php $view->extend('AppBundle::layout.html.php'); ?>
<div layout="column">
    <md-input-container>
        <label>Username</label>
        <input ng-model="newuser.username">
    </md-input-container>
    <md-input-container>
        <label>Email</label>
        <input type="email" ng-model="newuser.email">
    </md-input-container>
    <md-input-container>
        <label>Password</label>
        <input type="password" ng-model="newuser.password">
    </md-input-container>
    <md-input-container>
        <label>Repeat password</label>
        <input type="password" ng-model="newuser.repeatPassword">
    </md-input-container>
    <md-button ng-click="registerUser(newuser)">Register</md-button>
</div>