<?php

namespace Middlewares;

use Exception;
use Src\Auth\Auth;

class CanMiddleware
{

    public function handle(string $roles)
    {
        //Если роли текущего авторизированного пользователя нет в параметрах, то ошибка
        if (!Auth::user()->hasRole(explode('|', $roles))) {
            throw new Exception('Forbidden for you');
        }
    }
}