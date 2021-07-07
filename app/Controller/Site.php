<?php

namespace Controller;

use Model\Post;
use Src\View;

class Site
{
    public function index(): string
    {
        $posts = Post::query()->orderBy('text')->get();
        return (new View())->render('site.post', ['posts' => $posts]);
    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }
}
