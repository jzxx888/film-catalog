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
     * @param string $path
     * @param array|callable $callback
     * @param string|array $method
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
     * @param string $path
     * @param array|callable $callback
     */
    public function get(string $path, array|callable $callback): void
    {
        $this->add($path, $callback, 'get');
    }


    /**
     * @param string $path
     * @param array|callable $callback
     */
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
        $path = $this->request->getPath();
        $route = $this->matchRoute($path);
        dump($this->route_params);
        if($route) {
            $callback = $route[0]['callback'];
            $this->callRoutingAction($callback, $this->route_params);
        } else {
            // false url
            echo '404';
        }
    }

    private function matchRoute(string $path): ?array
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
                return [$route, array_slice($matches, 1)];
            }
        }
        return null;
    }

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