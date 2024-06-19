<?php

namespace App\Middleware;

use Core\App;
use Core\Bases\BaseMiddleware;
use Core\Utility\Session;

class PreventLoggedMiddleware extends BaseMiddleware
{
    public function execute()
    {
        if (!App::isGuest()) {
            if (in_array(App::$singleton->controller->action, $this->actions)) {
                throw new \Exception("You are Already Logged in!", 403);
            }
        }
    }
}