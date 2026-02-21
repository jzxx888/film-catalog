<?php

use Core\Application;

function app() {
    return Application::$app;
}

function database() {
    return app()->database;
}

function request() {
    return app()->request;
}