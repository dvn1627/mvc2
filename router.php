<?php
$route = [
    '/'             =>  'MainController@index',
    '/news/create'  =>  'NewsController@create',
    '/news/store'   =>  'NewsController@store',
    '/news/delete'  =>  'NewsController@delete',
    '/news/edit'    =>  'NewsController@edit',
    '/news/update'  =>  'NewsController@update',
    '/main/test'    =>  'MainController@test1',
    '/login'        =>  'AuthController@login',
    '/logout'       =>  'AuthController@logout',
];