<?php




class Route
{
    public string $route_regexp;
    public $controller;

    public function __construct($route_regexp, $controller)
    {
        $this->route_regexp = $route_regexp;
        $this->controller = $controller;
    }
}



class Router
{
    protected $routes = [];
    protected $twig;
    protected $pdo;

    public function __construct($twig, $pdo)
    {
        $this->twig = $twig;
        $this->pdo  = $pdo;
    }

    public function Add($route_regexp, $controller)
    {
        array_push($this->routes, new Route("#^$route_regexp$#", $controller));
    }

    public function GetOrDefault($default_controller)
    {
        $url = $_SERVER["REQUEST_URI"];
        $controller = $default_controller;
        $matches = []; 

        foreach ($this->routes as $route)
        {
            if (preg_match($route->route_regexp, $url, $matches))
            {
                $controller = $route->controller;
                break;
            }
        }

        $controllerInstance = new $controller();
        $controllerInstance->SetPDO($this->pdo);

        if (method_exists($controllerInstance, 'SetParams')) 
            $controllerInstance->SetParams($matches);

        if ($controllerInstance instanceof TwigBaseController) 
            $controllerInstance->SetTwig($this->twig);
        
        return $controllerInstance->Get();
    }
}

