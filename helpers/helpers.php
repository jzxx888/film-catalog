<?php

/**
 * @return Core\Application as instance
 */
function app(): Core\Application
{
    return Core\Application::$app;
}


/**
 * @return Core\Database as instance
 */
function database(): Core\Database
{
    return app()->database;
}


/**
 * @return Core\Database as instance
 */
function request(): Core\Request
{
    return app()->request;
}


/**
 * @return Core\Response as instance
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


/**
 * @param string|string[] $cssFiles
 * @return string with all css files in html <link>-tag
 */
function loadCss(string|array $cssFiles): string
{
    if(!is_array($cssFiles)) {
        $cssFiles = [$cssFiles];
    }
    return implode('', array_map(function($cssFile) {
        $standard = '<link rel="stylesheet" type="text/css" href="%file_css%"/>';
        $cssLink = '/assets/styles/' . $cssFile.'.css';
        return str_replace("%file_css%", $cssLink, $standard);
    }, $cssFiles) );
}