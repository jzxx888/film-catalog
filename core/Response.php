<?php 

namespace Core;

class Response {
    private string $status;
    public string $data;

    public function __construct()
    {
        
    }


    /**
     * sends html on page
     * @param string $html : html markup
     */
    public function send(string $html): void
    {
        echo $html;
    }

    /**
     * sets response code
     * @param int $code : response code to send
     */

    public function setResponseCode(int $code): void
    {
        http_response_code($code);
    }


    /**
     * aborts page and shows error page
     * @param string $message : message to show on page
     * @param int $error_code : error code (response code)
     */
    public function abort(string $message = '', int $error_code = 404)
    {
        $this->send(view("errors/{$error_code}", ['message' => $message], false));
        http_response_code($error_code);
        die();
    }


    /**
     * redirects to page
     */
    public function redirect()
    {

    }
}