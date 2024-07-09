<?php
namespace Framework;

use App\Controllers\ErrorController;


class Router {
    protected $routes = [];

    public function registerRoute($method,$uri,$action){

        list($controller,$controllerMethod) = explode("@",$action);

        
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
        ] ;
    }

    /**
     * ADD A GET ROUTE
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function get($uri,$controller){
        $this->registerRoute('GET',$uri,$controller);

    }
    
    /**
     * ADD A POST ROUTE
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function post($uri,$controller){
        $this->registerRoute('POST',$uri,$controller);
    }

    /**
     * ADD A PUT ROUTE
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function put($uri,$controller){
        $this->registerRoute('PUT',$uri,$controller);
    }

    /**
     * ADD A DELETE ROUTE
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function delete($uri,$controller){
        $this->registerRoute('DELETE',$uri,$controller);
    }

    /**
     * ROUTE THE REQUEST
     * @param string $uri
     * @param string $method
     * @return void
     */
    public function route($uri){

        $request_method = $_SERVER["REQUEST_METHOD"];

        foreach($this->routes as  $route ){
            // split the current uri in segments
            $uriSegments =explode('/',trim($uri,'/'));

            // split the route URI into segments
            $routeSegments =explode('/',trim($route['uri'],'/'));

            $match =true;

            // check if the number of segments matches
            if(count($uriSegments) === count($routeSegments) && strtoupper($route['method'] === $request_method)){
                $params =[];
                $match =true;

                for($i=0; $i< count($uriSegments); $i++){
                    if($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/',$routeSegments[$i])){
                        $match = false;
                        break;
                    }
                    if(preg_match('/\{(.+?)\}/',$routeSegments[$i],$matches)){
                        $params[$matches[$i]] = $uriSegments[$i];
                    }
                }
                
                if($match){
                $controller= 'App\\Controllers\\' . $route['controller'];
                $controllerMethod =  $route['controllerMethod'];

                    // instatiate the controller and call the method
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }


            }


            // if($route['uri'] === $uri && $route['method'] === $method){

            //         // require  basePath('App/' . $route['controller']);
            //         $controller= 'App\\Controllers\\' . $route['controller'];
            //         $controllerMethod =  $route['controllerMethod'];

            //         // instatiate the controller and call the method
            //         $controllerInstance = new $controller();
            //         $controllerInstance->$controllerMethod();
            //         return;

            // }
        }

       ErrorController::notFound();


    }



}