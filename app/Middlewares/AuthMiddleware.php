<?php

namespace Middlewares;

use Src\Auth\Auth;

class AuthMiddleware
{
    public function handle(): void
    {
        //Если пользователь не авторизован, то редирект на страницу входа
        if (!Auth::check()) {
            app()->route->redirect('/go/login');
        }
    }
}