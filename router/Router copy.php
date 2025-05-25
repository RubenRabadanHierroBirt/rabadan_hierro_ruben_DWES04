<?php
class Router {
    private $routes = [];

    public function add($route, $action) {
        $this->routes[$route] = $action;
    }

    public function dispatch($uri) {
        $uri = parse_url($uri, PHP_URL_PATH);

        //$uri = substr($uri,)
        //echo $uri;
        if (array_key_exists($uri, $this->routes)) {
            $action = $this->routes[$uri];
            list($controller, $method) = explode('@', $action);

            if (class_exists($controller) && method_exists($controller, $method)) {
                $instance = new $controller();
                $instance->$method();
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Controlador o método no encontrado"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Ruta no encontrada"]);
        }
    }
}
?>