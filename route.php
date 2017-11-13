<?php
/**
 * @method  route created by myself
 * @Created by PhpStorm.
 * @User: ysl
 * @Date: 2017/11/13
 * @Time: 10:37
 */
class Route
{
    static public $routes = array();

    static public $methods = array();

    static public $callbacks =array();

    public function __construct()
    {

    }

    /**
     * add a get route rule
     * @param $route 路由
     * @param $callback 回调函数
     */
    static public function get($route , $callback)
    {
        $route = trim($route,'/');
        $route = '/'.$route;
        $method = 'GET';
        array_push(self::$routes , $route);
        array_push(self::$methods , $method);
        array_push(self::$callbacks , $callback);
    }

    /**
     * @param $route
     * @param $callback
     */
    static public function post($route , $callback)
    {
        $route = trim($route,'/');
        $route = '/'.$route;
        $method = 'POST';
        array_push(self::$routes , $route);
        array_push(self::$methods , $method);
        array_push(self::$callbacks , $callback);
    }

    /**
     *
     */
    static public function run ()
    {

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);  //请求参数
        $method = $_SERVER['REQUEST_METHOD'];    //请求方法

        $found_route = false;    //先设定输入的路由为false

        self::$routes = preg_replace('/\/+/', '/', self::$routes);

        if(in_array($uri ,self::$routes))
        {
            //当前的路由在已经定义的路由规则里，根据$callback获取回调函数.
            $postion = array_keys(self::$routes ,$uri);  //返回键名数组
            foreach ($postion as $pos)
            {
                if(self::$methods[$pos] == $method)   //请求方法一致
                {
                    $found_route = true;
                    if(!is_object(self::$callbacks[$pos]))
                    {
                        $params = explode('@',self::$callbacks[$pos]);

//                        $controller = new GoodsController();
                        $controller = new $params[0]();
//                        var_dump($params[1]);die;
                        $controller->{$params[1]}();
                    }
                }
            }


        }else{
            echo 2;
        }


    }
}