<?php
namespace App\Core;

final class Router
{
    /** @var array<string, array<string, array{handler:mixed, middleware:array}>> */
    private array $routes = [];
    private array $groupStack = [];

    public function get(string $uri, $handler, array $middleware = []): self    { return $this->add('GET', $uri, $handler, $middleware); }
    public function post(string $uri, $handler, array $middleware = []): self   { return $this->add('POST', $uri, $handler, $middleware); }
    public function put(string $uri, $handler, array $middleware = []): self    { return $this->add('PUT', $uri, $handler, $middleware); }
    public function patch(string $uri, $handler, array $middleware = []): self  { return $this->add('PATCH', $uri, $handler, $middleware); }
    public function delete(string $uri, $handler, array $middleware = []): self { return $this->add('DELETE', $uri, $handler, $middleware); }
    public function any(string $uri, $handler, array $middleware = []): self {
        foreach (['GET','POST','PUT','PATCH','DELETE'] as $m) $this->add($m, $uri, $handler, $middleware);
        return $this;
    }

    public function group(array $attrs, callable $cb): void
    {
        $this->groupStack[] = $attrs;
        $cb($this);
        array_pop($this->groupStack);
    }

    private function add(string $method, string $uri, $handler, array $middleware): self
    {
        $prefix = '';
        $stackMw = [];
        foreach ($this->groupStack as $g) {
            $prefix .= $g['prefix'] ?? '';
            $stackMw = array_merge($stackMw, $g['middleware'] ?? []);
        }
        $uri = '/' . trim($prefix . $uri, '/');
        if ($uri === '/') $uri = '/';
        $this->routes[$method][$uri] = [
            'handler'    => $handler,
            'middleware' => array_merge($stackMw, $middleware),
        ];
        return $this;
    }

    public function dispatch(Request $req): void
    {
        $method = $req->method();
        $uri    = $req->uri();

        // exact match
        if (isset($this->routes[$method][$uri])) {
            $this->run($this->routes[$method][$uri], $req, []);
            return;
        }

        // dynamic match  /foo/{id}
        foreach ($this->routes[$method] ?? [] as $pattern => $route) {
            if (!str_contains($pattern, '{')) continue;
            $regex = '#^' . preg_replace_callback('/\{([a-zA-Z_]+)\}/', function ($m) {
                return '(?P<' . $m[1] . '>[^/]+)';
            }, $pattern) . '$#';
            if (preg_match($regex, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->run($route, $req, $params);
                return;
            }
        }

        Response::notFound();
    }

    private function run(array $route, Request $req, array $params): void
    {
        $req->params = $params;

        // middleware chain
        foreach ($route['middleware'] as $mw) {
            $class = is_string($mw) && class_exists("App\\Middleware\\{$mw}") ? "App\\Middleware\\{$mw}" : $mw;
            if (is_string($class) && class_exists($class)) {
                (new $class())->handle($req);
            } elseif (is_callable($mw)) {
                $mw($req);
            }
        }

        $handler = $route['handler'];
        if (is_callable($handler)) {
            $result = call_user_func_array($handler, [$req, ...array_values($params)]);
            if (is_array($result)) Response::json($result);
            return;
        }

        // "Controller@method"
        if (is_string($handler) && str_contains($handler, '@')) {
            [$ctrl, $method] = explode('@', $handler);
            $class = "App\\Controllers\\{$ctrl}";
            if (!class_exists($class)) Response::notFound("Controller {$ctrl} missing");
            $instance = new $class();
            if (!method_exists($instance, $method)) Response::notFound("Method {$method} missing");
            $result = call_user_func_array([$instance, $method], [...array_values($params), $req]);
            if (is_array($result)) Response::json($result);
            return;
        }

        Response::serverError('Invalid route handler');
    }
}
