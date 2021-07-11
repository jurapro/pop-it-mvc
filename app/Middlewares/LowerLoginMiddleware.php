<?php

namespace Middlewares;

use Src\Request;

class LowerLoginMiddleware
{
    public function handle(Request $request)
    {
        if ($request->get('login')) {
            $request->set('login', strtolower($request->get('login')));
        }
    }
}