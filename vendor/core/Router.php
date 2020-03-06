<?php

namespace vendor\core;
use app\controllers\MainController;


class Router
{
    protected static $routes = [];  //Массив, где хранятся наши роуты
    protected static $route = []; //массив с текущим роутом

    /**
     * Метод добавления нашего роута, передаем строку из браузера и пути
     * @param $regexp
     * @param array $route
     */
    public static function add($regexp, $route = []) {
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes() {
        return self::$routes;
}

    public static function getRoute() {
        return self::$route;
    }

    /**
     *Мы  получаем массив с роутами, где ключи - это строки controller и action
     * @param $url
     * @return bool
     */

    protected static function routeMatch($url) {

        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $url, $matches)) {

                foreach($matches as $k => $v) { //массив отделяет слова controller и action
                    if (is_string($k)) {
                        $route[$k] = $v; //оставляем в массиве только строки
                    }

                }
                if (!isset($route['action'])) {
                    $route['action'] = 'index'; //по умолчанию присваиваем action index если другого нет
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route; //если найдено совпадение с регуляркой, то присваиваем его массиву и вовзращает true
                return true;
            }
        }
        return false;
    }

    /**
     * если все ок с предыдущим методом, то подключаем класс и создаем объект класса, а так же находим в нем метод
     * @param string $url входящий URL
     * @return void
     */
    public static function dispatch($url) {
        $url = self::removeQueryString($url);
        if(self::routeMatch($url)) {

           $controller = 'app\controllers\\' . self::$route['controller'] . 'Controller'; //подключаем класс с нужным пространстов имен
           if (class_exists($controller)) {
               $cObj = new $controller(self::$route); //создаем объект класса и передаем в конструктор массив с контроллером и экшеном
               $action = self::$route['action'] . 'Action';
               if(method_exists($cObj, $action)) {
                   $cObj->$action();
                   $cObj->getView();
               }
               else {
                   echo "Метод <b> $controller::$action </b> не найден";
               }
           }
           else {
               echo "Контроллер <b>". $controller ."</b> не найден";
           }
        }
        else{
            include "404.html";
        }
    }


    protected static function upperCamelCase($name) {
        $name = str_replace('-', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        return $name;

}

    /**
     * Параметром передает адресную строку и убираем get-параметры
     * @param $url
     * @return string
     */

    protected static function removeQueryString($url) {
        if($url) {
            $params = explode('&', $url); //разбиваем строку по амперсанду и кидаем в массив
            if (false === strpos($params[0], '=')) { // усли нулевой элемент содержит равно, то оставляем
                return rtrim($params[0], '/'); //убираем правый слеш
            }else {
                return ''; //иначе вовзращает пустую строку
            }
        }
        return $url;
    }





}