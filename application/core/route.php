<?php

/*
Класс-маршрутизатор для определения запрашиваемой страницы.
> цепляет классы контроллеров и моделей;
> создает экземпляры контролеров страниц и вызывает действия этих контроллеров.
*/

class Route
{

    static function start()
    {
        // контроллер и действие по умолчанию
        $controller_name = 'Insync';
        $action_name = 'index';
        $routes = explode('/', str_replace("?" . $_SERVER["QUERY_STRING"], "", $_SERVER['REQUEST_URI']));

        // получаем имя контроллера
        if (!empty($routes[1])) {
            $controller_name = $routes[1];
        }

        // получаем имя экшена
        if (!empty($routes[2])) {
            $action_name = $routes[2];
        }

        // добавляем префиксы
        $model_name = 'Model_' . $controller_name;
        $controller_name = 'Controller_' . $controller_name;
        $action_name = 'action_' . $action_name;


        $model_path = $_SERVER["DOCUMENT_ROOT"] . "/application/models/" . strtolower($model_name) . '.php';
        if (file_exists($model_path)) {
            include $model_path;
        }

        // подцепляем файл с классом контроллера
        $controller_path = $_SERVER["DOCUMENT_ROOT"] . "/application/controllers/" . strtolower($controller_name) . '.php';

        if (file_exists($controller_path)) {
            include $controller_path;
        } else {
            Route::ErrorPage404();
        }


        // создаем контроллер
        $controller = new $controller_name;
        $action = $action_name;

        if (method_exists($controller, $action)) {
            // вызываем действие контроллера
            $controller->$action();
        } else {
            // здесь также разумнее было бы кинуть исключение
            Route::ErrorPage404();
        }

    }

    static function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 302 Found');
        header("Status: 302 Found");
        header('Location:' . $host . '404');
    }

}
