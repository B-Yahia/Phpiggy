<?php

declare(strict_types=1);

namespace Framework;

class App
{
    private Router $router;
    private Container $container;

    public function __construct(string $containersDefinitionPath = null)
    {
        $this->router = new Router();
        $this->container = new Container();

        if ($containersDefinitionPath) {
            $containerDefinitions = include $containersDefinitionPath;
            $this->container->addDefinitions($containerDefinitions);
        }
    }
    public function run()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $this->router->dispatch($path, $method, $this->container);
    }
    public function get(string $path, array $conttroller): App
    {
        $this->router->add("GET", $path, $conttroller);
        return $this;
    }
    public function post(string $path, array $conttroller): App
    {
        $this->router->add("POST", $path, $conttroller);
        return $this;
    }
    public function delete(string $path, array $conttroller): App
    {
        $this->router->add('DELETE', $path, $conttroller);
        return $this;
    }

    public function addMiddleWare(string $middleware)
    {
        $this->router->addMiddleWare($middleware);
    }
    public function add(string $middleware)
    {
        $this->router->addRouteMiddleware($middleware);
    }
}
