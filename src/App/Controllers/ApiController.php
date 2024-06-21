<?php

namespace App\Controllers;

use App\Middleware\PreventGuestMiddleware;
use App\Middleware\PreventLoggedMiddleware;
use App\Models\Api;
use App\Models\ApiSummary;
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
        $this->registerMiddleware(new PreventGuestMiddleware(['index', 'create', 'edit', 'delete']));

    }
    public function index()
    {
        app('session')->start();

        $result = Api::paginate(6, ['user_id' => $_SESSION['user']->id]);
        return view('apis', $result);
    }
    public function create()
    {
        app('session')->start();
        $apiName = preg_replace('/[^a-zA-Zأ-ي0-9\s]/u', '', $_POST['apiName'] ?? '');
        if (!empty($apiName)) {
            Api::create(['name' => $apiName, 'token' => uniqid(), 'user_id' => $_SESSION['user']->id])->save();
        }
        return Response::redirect('/apis');
    }

    public function edit()
    {
        $token = $_GET['token'] ?? '';
        $name = preg_replace('/[^a-zA-Zأ-ي0-9\s]/u', '', $_GET['name'] ?? '');
        if (isset($_GET['status']))
            $status = (bool) $_GET['status'];
        if (empty($token))
            return Response::redirect('/apis');
        $api = Api::one(['token' => $token, 'user_id' => $_SESSION['user']->id]);
        if ($api) {
            if (empty($name))
                $name = $api->name;
            if (!isset($_GET['status']))
                $status = $api->status;
            $api->edit(['name' => $name, 'status' => $status])->save();
        }
        return Response::redirect('/apis');
    }

    public function delete($token)
    {
        app('session')->start();
        $token = $token[0];
        $api = Api::one(['token' => $token, 'user_id' => $_SESSION['user']->id]);
        if ($api)
            $api->delete();
        return Response::redirect('/apis');
    }

    public function summarize($token)
    {
        $token = $token[0];
        $api = Api::one(['token' => $token]);
        // pre($api);
        if (!$api || !$api->status)
            return json_encode(['success' => false, 'errors' => ['API is suspend']]);

        $errors = [];
        $text = filter_input(INPUT_POST, 'text') ?? '';
        $model = match ($_POST['model'] ?? '') {
            'textRank' => 'textRank',
            'mbartExtractive' => 'mbartExtractive',
            'mbartAbstractive' => 'mbartAbstractive',
            'transformer' => 'transformer',
            default => 'textRank'
        };
        $summaryLength = match ($_POST['summaryLength'] ?? '') {
            'small' => 'small',
            'medium' => 'medium',
            'large' => 'large',
            default => 'small'
        };
        $text = trim($text);

        if ((empty($text)) || strlen($text) < 100)
            $errors[] = "text length must be more than 100 char";

        // pre($errors);
        if (!empty($errors))
            return json_encode(['success' => false, 'errors' => $errors]);

        $output = sendSummaryRequest($text, $model, $summaryLength);


        $output = $output['summary'];
        $output['model'] = $model;
        if ($model == 'textRank')
            $output['length'] = $summaryLength;
        $result = $output;
        $result['success'] = true;
        $result['errors'] = [];




        $output['api_id'] = $api->id;

        ApiSummary::create($output)->save();
        header('Content-Type: application/json');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        return json_encode($result);
    }

    public function history()
    {
        $token = $_GET['token'] ?? '';
        $api = Api::one(['token' => $token]);
        if (!$api)
            return Response::redirect('/apis');
        $result = ApiSummary::paginate(3, ['api_id' => $api->id]);
        $result['name'] = $api->name;
        return view('api-history', $result);
    }
}