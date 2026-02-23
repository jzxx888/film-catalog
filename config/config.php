<?php

define ( 'ROOT', dirname(__DIR__) );

define ( 'HOST', $_SERVER['HTTP_HOST']);

define ( 'ENV', parse_ini_file(ROOT . '/.env') );

const HELPERS = ROOT . '/helpers';
const APP = ROOT . '/app';
const CORE = ROOT . '/core';
const VIEWS = APP . '/views';
const LAYOUT = 'default';