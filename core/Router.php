<?php 

namespace Core;

// use App\Controllers;

class Router {

    protected Request $request;
    protected Response $response;
    
    protected array $routes = [];
    protected array $route_params = [];

    private $slugPattern = '([a-z0-9-]+)';

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * add new route
     * @param string $path : uri
     * @param array|callable $callback : Class, Method | Closure
     * @param string|array $method : method | array of methodes
     */
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

    /**
     * add new route with GET method
     * @param string $path : uri
     * @param array|callable $callback : Class, Method | Closure
     */
    public function get(string $path, array|callable $callback): void
    {
        $this->add($path, $callback, 'get');
    }


    /**
     * add new route with POST method
     * @param string $path : uri
     * @param array|callable $callback : Class, Method | Closure
     */
    public function post(string $path, array|callable $callback): void
    {
        $this->add($path, $callback, 'post');
    }


    /**
     * Get routes
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }


    /**
     * loops all routes through
     * sends route if it had been found or sends 404 error if not
     */
    public function dispatch(): void
    {
        $path = $this->request->getPath();
        $route = $this->matchRoute($path);
        
        if($route) {
            $callback = $route['callback'];
            $this->response->send($this->callRoutingAction($callback, $this->route_params));
        } else {
            $this->response->abort("Page not found: {$this->request->uri}");
        }
    }


    /**
     * matches path to regex and sets route params
     * @return false|array 
     * false if no route matches or array with route if matches
     */
    private function matchRoute(string $path): false|array
    {
        foreach($this->getRoutes() as $route) {
            $pathRegex = $this->translatePathToRegex($route['path']);
            if(
                preg_match($pathRegex, "/$path", $matches) > 0
                &&
                in_array($this->request->getMethod(), $route['method'])
                // if not - access denied
            ) {
                $this->setRouteParams($matches, $route);
                return $route;
            }
        }
        return false;
    }


    /**
     * sets params on route
     * @param array $params GET params
     * @param array $route route that has been added
     */
    private function setRouteParams(array $params, array $route): void
    {

        $pattern = '@' . '\{[a-z0-9-]+\}' . '@';
        preg_match_all($pattern, $route['path'], $matches);

        foreach($params as $k => $v) {
            if(!isset($this->route_params[$k])) {
                if($k !== 0) {
                    $this->route_params[str_replace(['{', '}'], '', $matches[0][$k-1])] = $v;
                }
            }
        }
    }


    /**
     * calls routing action : Closure or method of Class
     * @param array|callable $callback : 
     * array => Class, Method
     * callable => Closure
     * @param $param : GET params
     */
    private function callRoutingAction(array|callable $callback, $param = null): string
    {
        // if callback is a class with method -> use classname as new class instance
        if(is_array($callback)) {
            $callback[0] = new $callback[0];
        }
        return call_user_func($callback, ...$param);
    }


    /**
     * translates $path to regex
     * @param string $path path to translate to regex
     */
    private function translatePathToRegex(string $path): string
    {
        $pattern = '@' . '\{[a-z0-9-]+\}' . '@';
        $path = str_replace('/', '\/', $path);

        return '@^' . preg_replace($pattern, $this->slugPattern, $path) . '$@';
    }
}