<?php

namespace App\Middleware;

use Core\App;
use Core\Bases\BaseMiddleware;

class PreventGuestMiddleware extends BaseMiddleware
{
    public function execute()
    {
        if (App::isGuest()) {
            if (in_array(App::$singleton->controller->action, $this->actions)) {
                throw new \Exception("You Should Logged in!", 403);
            }
        }
    }
}