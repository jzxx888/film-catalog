<?php

namespace Core;

// use Core\Request;
// use Core\Database;
// use Core\Router;
// use Core\Response;

class Application {

    protected string $uri;

    public Database $database;
    public Request $request;
    public Response $response;
    public Router $router;

    public static Application $app;

    public function __construct() {
        self::$app = $this;

        $this->uri = $_SERVER['REQUEST_URI'];

        
        $this->database = new Database();
        $this->request = new Request($this->uri);
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        $this->router->dispatch();
    }
}