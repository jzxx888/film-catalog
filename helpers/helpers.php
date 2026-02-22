<?php

/**
 * returns Core\Application as instance
 */
function app(): Core\Application
{
    return Core\Application::$app;
}


/**
 * returns Core\Database as instance
 */
function database(): Core\Database
{
    return app()->database;
}


/**
 * returns Core\Database as instance
 */
function request(): Core\Request
{
    return app()->request;
}


/**
 * returns Core\Response as instance
 */
function response(): Core\Response
{
    return app()->response;
}


/**
 * @param $view : view to use
 * @param $data : data for template
 * @param $layout : False for no layout or layout name for layout to use
 */
function view($view = '', $data = [], $layout = ''): string|\Core\View
{
    if($view) {
        return app()->view->render($view, $data, $layout);
    }
    return app()->view;
}