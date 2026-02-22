<?php 

namespace Core;

class View {
    // unchanging contant layout
    public string $layout;

    // content
    public string $content = '';

    /**
     * @param string $layout : layout, pattern for page
     */
    public function __construct(string $layout)
    {
        $this->layout = $layout;
    }


    /**
     * returns html markup
     * @param $view : view to use
     * @param $data : data for template
     * @param $layout : False for no layout or layout name for layout to use
     * @return string html markup
     */
    public function render($view, $data = [], $layout = ''): string
    {
        extract($data);
        $view_file = VIEWS . "/{$view}.php";
        if(is_file($view_file)) {
            ob_start();
            require $view_file;
            $this->content = ob_get_clean();
        } else {
            response()->abort("Not found view: {$view_file}", 500);
        }

        if(false === $layout) {
            return $this->content;
        }

        $layout_file_name = $layout ?: $this->layout;
        $layout_file = VIEWS . "/layouts/{$layout_file_name}.php";
        if(is_file($layout_file)) {
            ob_start();
            require_once $layout_file;
            return ob_get_clean();
        } else {
            response()->abort("Not found layout: {$layout_file}", 500);
        }

        return '';
    }
}