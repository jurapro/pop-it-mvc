<?php

namespace Middlewares;

use Exception;
use Src\Auth\Auth;
use Src\Request;

class CanMiddleware
{
    public function handle(Request $request, string $roles)
    {
        //Если роли текущего авторизированного пользователя нет в параметрах, то ошибка
        if (!Auth::user()->hasRole(explode('|', $roles))) {
            throw new Exception('Forbidden for you');
        }
    }
}