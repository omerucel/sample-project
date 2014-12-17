<?php

namespace Application\Router;

use Application\Di\Di;
use Symfony\Component\HttpFoundation\Response;

class Dispatcher
{
    /**
     * @var \Application\Di\Di
     */
    protected $dependencyInjection;

    /**
     * @param Di $dependencyInjection
     */
    public function __construct(Di $dependencyInjection)
    {
        $this->dependencyInjection = $dependencyInjection;
    }

    /**
     * @param $defaultController
     * @param array $routes
     * @param array $tokens
     */
    public function dispatch($defaultController, array $routes = [], array $tokens = [])
    {
        $router = new Router($routes, $tokens);
        $route = $router->getCurrentRoute();
        if ($route == null) {
            $this->showDefaultController($defaultController);
        } else {
            $this->showRoute($route);
        }
    }

    /**
     * @param $defaultController
     */
    public function showDefaultController($defaultController)
    {
        $this->sendControllerResponse(new $defaultController($this->dependencyInjection), 'GET', []);
    }

    /**
     * @param Route $route
     */
    public function showRoute(Route $route)
    {
        $className = $route->getControllerClass();
        $actionName = $route->getRequestMethod();
        $params = $route->getParams();
        $this->sendControllerResponse(new $className($this->dependencyInjection), $actionName, $params);
    }

    /**
     * @param Controller $controller
     * @param $actionName
     * @param array $params
     */
    public function sendControllerResponse(Controller $controller, $actionName, array $params = [])
    {
        $actionName = strtolower($actionName);
        $response = $controller->preDispatch($params);
        if (!$response instanceof Response) {
            $response = $controller->$actionName($params);
            $postResponse = $controller->postDispatch($params);
            if ($postResponse instanceof Response) {
                $response = $postResponse;
            }

            if (!$response instanceof Response) {
                $response = $this->dependencyInjection->get('http_response');
            }
        }

        $response->send();
    }
}
