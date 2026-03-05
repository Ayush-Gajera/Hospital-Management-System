<?php

namespace app\Http;
class Router
{
    public array $routes = [];
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }
    public function resolve(Request $request)
    {
        $path = $request->getPath();
        $method = $request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            http_response_code(404);
            return "<h2 style='font-family:sans-serif;color:#c0392b;padding:40px'>404 — Page not found.</h2>";
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }

    $response = call_user_func($callback, $request);
    if (is_array($response) && isset($response['view'])) {
        return $this->renderView($response['view'], $response['params'] ?? []);
    }

    return $response;
    }
    public function renderView($view, $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        // Render the inner view first
        ob_start();
        include BASE_PATH."\app\Views\\".$view.".php";
        $content = ob_get_clean();

        // Wrap inside layout
        ob_start();
        include BASE_PATH."\app\Views\layout.php";
        return ob_get_clean();
    }
}
