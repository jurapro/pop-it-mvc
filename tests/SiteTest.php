<?php

use Model\User;
use PHPUnit\Framework\TestCase;

class SiteTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     * @runInSeparateProcess
     */
    public function testSignup(string $httpMethod, array $userData, string $message): void
    {
        //Выбираем занятый логин из базы данных
        if ($userData['login'] === 'login is busy') {
            $userData['login'] = User::get()->first()->login;
        }

        // Создаем заглушку для класса Request.
        $request = $this->createMock(\Src\Request::class);
        // Переопределяем метод all() и свойство method
        $request->expects($this->any())
            ->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;

        //Сохраняем результат работы метода в переменную
        $result = (new \Controller\Site())->signup($request);

        if (!empty($result)) {
            //Проверяем варианты с ошибками валидации
            $message = '/' . preg_quote($message, '/') . '/';
            $this->expectOutputRegex($message);
            return;
        }

        //Проверяем добавился ли пользователь в базу данных
        $this->assertTrue((bool)User::where('login', $userData['login'])->count());
        //Удаляем созданного пользователя из базы данных
        User::where('login', $userData['login'])->delete();

        //Проверяем редирект при успешной регистрации
        $this->assertContains($message, xdebug_get_headers());
    }

    //Метод, возвращающий набор тестовых данных
    public function additionProvider(): array
    {
        return [
            ['GET', ['name' => '', 'login' => '', 'password' => ''],
                '<pre></pre>'
            ],
            ['POST', ['name' => '', 'login' => '', 'password' => ''],
                '<pre>{"name":["Поле name пусто"],"login":["Поле login пусто"],"password":["Поле password пусто"]}</pre>',
            ],
            ['POST', ['name' => 'admin', 'login' => 'login is busy', 'password' => 'admin'],
                '<pre>{"login":["Поле login должно быть уникально"]}</pre>',
            ],
            ['POST', ['name' => 'admin', 'login' => md5(time()), 'password' => 'admin'],
                'Location: /go/',
            ],
        ];
    }

    //Настройка конфигурации окружения
    protected function setUp(): void
    {
        //Установка переменых среды
        $_SERVER['DOCUMENT_ROOT'] = '/var/www/pop-it-mvc';
        $_SERVER['REQUEST_URI'] = '';

        //Создаем экземпляр приложения
        $GLOBALS['app'] = new Src\Application(include $_SERVER['DOCUMENT_ROOT'] . '/config/app.php');

        //Глобальная функция для доступа к объекту приложения
        if (!function_exists('app')) {
            function app()
            {
                return $GLOBALS['app'];
            }
        }
    }

}