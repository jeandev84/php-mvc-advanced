<?php

/**
http://localhost:8999/api
https://www.getpostman.com/ (program for working with api json format parsing)
*/

try {


    /**
     * Includes helpers functions
    */
    require_once __DIR__.'/../helpers/functions.php';

    /* debug($_SERVER, true); */

    /**
     * Autoloader Composer
     */
    require_once __DIR__ . '/../vendor/autoload.php';


    /**
     * Requesting
     * $route = $request->getPath();
     * $route = $request->server('REQUEST_URI');
     */
    $request = new \Framework\Http\Request();
    $route = $request->getPath();


    /**
     * Load (api) routes collection
     * dump($routes)
    */
    $routes = require __DIR__ . '/../config/api/routes.php';


    /**
     * Matching route
     */
    $isRouteFound = false;

    foreach($routes as $path => $controllerAndAction)
    {
        $pattern = '~^'. trim($path, '/') . '$~';
        preg_match($pattern, $route, $matches);
        if(!empty($matches))
        {
            $isRouteFound = true;
            break;
        }
    }

    if(!$isRouteFound)
    {
        throw new \Framework\Exceptions\NotFoundException('Route not found');
    }

    /*
    dump($controllerAndAction);
    dump($matches);
    */

    /**
     * Call Action
     */

    unset($matches[0]);

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    $controller = new $controllerName();
    $controller->$actionName(...$matches);

} catch (\Framework\Exceptions\Database\DbException $e) {

    $view = new \Framework\Templating\View(__DIR__.'/../templates/errors');
    $view->renderHtml('500.php', ['error' => $e->getMessage()], 500);

} catch (\Framework\Exceptions\NotFoundException $e) {

    $view = new \Framework\Templating\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('404.php', ['error' => $e->getMessage()], 404);

} catch (\Framework\Exceptions\UnauthorizedException $e) {
    $view = new \Framework\Templating\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('401.php', ['error' => $e->getMessage()], 401);
}

