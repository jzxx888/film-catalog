<?php 

namespace Core;

// use App\Controllers;

class Router {

    protected Request $request;
    protected Response $response;
    
    protected array $routes = [];

    private $slugPattern = '([a-z0-9-]+)';

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function add(string $path, array|callable $callback, string|array $method): void
    {
        $path = trim($path, "/");
        if(is_array($method)) {
            $method = array_map('strtoupper', $method);
        } else {
            $method = [strtoupper($method)];
        }

        $this->routes[] = [
            "path" => "/$path",
            "callback" => $callback,
            "method" => $method
        ];
    }

    public function get(string $path, array|callable $callback): void
    {
        $this->add($path, $callback, 'get');
    }

    public function post(string $path, array|callable $callback): void
    {
        $this->add($path, $callback, 'post');
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function dispatch(): void
    {
        $path = "/" . $this->request->getPath();
        $route = $this->matchRoute($path);

        if($route) {
            $callback = $route[0]['callback'];
            $this->callRoutingAction($callback, $route[1] ?? null);
        } else {
            echo '404';
        }


        // $routes = $this->getRoutes();
        // $isRouteFound = false;

        // foreach($routes as $route) {
        //     $callback = $route['callback'];
        //     $pathRegex = $this->translatePathToRegex($route['path']);
        //     $match = preg_match($pathRegex, $path, $matches);
            
        //     if($match === 1) {
        //         $this->callRoutingAction($callback, $matches[1] ?? null);
        //         $isRouteFound = true;
        //     }
        // }

        // if(!$isRouteFound) {
        //     echo '404';
        // }
    }

    private function matchRoute(string $path): ?array
    {
        foreach($this->routes as $route) {
            $pathRegex = $this->translatePathToRegex($route['path']);
            if(preg_match($pathRegex, $path, $matches) > 0) {
                return [$route, array_slice($matches, 1)];
            }
        }
        return null;
    }

    private function callRoutingAction(array|callable $callback, $param = null) 
    {
        if(is_array($callback)) {
            $controller = $callback[0];
            $func = $callback[1];

            $obj = new $controller();
            $obj->$func(...$param);
        } elseif(is_callable($callback)) {
            call_user_func($callback);
        }
    }

    private function translatePathToRegex(string $path): string
    {
        $pattern = '@' . '\{[a-z0-9-]+\}' . '@';
        $path = str_replace('/', '\/', $path);

        return '@^' . preg_replace($pattern, $this->slugPattern, $path) . '$@';
    }
}