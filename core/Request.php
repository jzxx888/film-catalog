<?php 

namespace Core;

class Request {

    public string $uri;

    public function __construct($uri)
    {
        $this->uri = trim(urldecode($uri), '/');
    }

    public function getMethod(): string 
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function isGet(): bool
    {
        return $this->getMethod() == 'GET';
    }

    public function isPost(): bool
    {
        return $this->getMethod() == 'POST';
    }

    public function get($key, $default = null): ?string
    {
        return $_GET[$key] ?? $default;
    }

    public function post($key, $default = null): ?string
    {
        return $_POST[$key] ?? $default;
    }

    public function getPath(): string
    {
        return $this->removeParams();
    }

    protected function removeParams(): string
    {
        if($this->uri) {
            $params = explode('?', $this->uri);
            return trim($params[0], '/');
        } else {
            return $this->uri;
        }
    }
}