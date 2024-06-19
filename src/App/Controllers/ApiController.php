<?php

namespace App\Controllers;

use App\Middleware\PreventGuestMiddleware;
use App\Middleware\PreventLoggedMiddleware;
use App\Models\Summary;
use App\Models\User;
use Core\App;
use Core\Bases\BaseController;
use Core\Http\Request;
use Core\Http\Response;


class ApiController extends BaseController
{

    public function __construct()
    {

    }
    public function index()
    {
        return view('apis');
    }



}