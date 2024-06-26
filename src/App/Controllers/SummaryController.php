<?php

namespace App\Controllers;

use App\Models\Summary;
use Core\App;
use Core\Bases\BaseController;
use Core\Http\Response;


class SummaryController extends BaseController
{

    public function __construct()
    {

    }
    public function index()
    {
        return view('summarize', [
            'text' => '',
            'summary' => '',
            'model' => '',
            'id' => '',
            'summaryLength' => ''
        ]);
    }

    public function summarize()
    {
        $errors = [];
        $text = filter_input(INPUT_POST, 'text');
        $model = match ($_POST['model']) {
            'textRank' => 'textRank',
            'mbartExtractive' => 'mbartExtractive',
            'mbartAbstractive' => 'mbartAbstractive',
            'transformer' => 'transformer',
            default => 'textRank'
        };
        $summaryLength = match ($_POST['summaryLength']) {
            'small' => 'small',
            'medium' => 'medium',
            'large' => 'large',
            default => 'small'
        };
        $filePath = null;
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['file']['tmp_name'];
            $fileName = date('YmdHis') . '_' . $_FILES['file']['name'];
            $filePath = UPLOADS_PATH . $fileName;
            $filePath = str_replace('\\', '/', $filePath);
            // Move uploaded file to desired location
            if (!move_uploaded_file($file, $filePath)) {
                //$errors['file'] = "Failed to move uploaded file";
            }
        }

        $text = trim($text);

        if ((is_null($filePath) && empty($text)) || (is_null($filePath) && strlen($text) < 100))
            $errors['text'] = "text length must be more than 100 char";

        // pre($errors);
        if (!empty($errors))
            return view('summarize', [
                'text' => $_POST['text'],
                'model' => $_POST['model'],
                'summary' => '<div class="alert alert-danger">' . implode('<br>', array_map('htmlspecialchars', $errors)) . '</div>',
                'id' => '',
                'errors' => $errors
            ]);

        if (is_null($filePath))
            $output = sendSummaryRequest($text, $model, $summaryLength);
        else
            $output = sendSummaryRequest($text, $model, $summaryLength, $filePath);

        $output = $output['summary'];
        $output['model'] = $model;
        if ($model == 'textRank')
            $output['length'] = $summaryLength;

        if (isset($fileName))
            $output['file'] = $fileName;

        if (App::isGuest())
            $output['user_id'] = 0;
        else {
            app('session')->start();
            $output['user_id'] = $_SESSION['user']->id;
        }
        $out = Summary::create($output)->save();
        return view(
            'summarize',
            [
                'text' => $out->text,
                'summary' => $out->summary,
                'model' => $out->model,
                'id' => $out->id,
                'summaryLength' => $out->length
            ]
        );

    }

    public function feedback()
    {
        $feedbackType = match ($_POST['feedbackType']) {
            'like' => 1,
            'dislike' => 0,
            default => null
        };
        $summaryId = filter_input(INPUT_POST, 'summaryId', FILTER_SANITIZE_NUMBER_INT);
        if (is_null($feedbackType) || empty($summaryId))
            Response::redirect('/summarize');
        $userId = App::isGuest() ? 0 : $_SESSION['user']->id;
        $summary = Summary::one(['id' => $summaryId, 'user_id' => $userId]);
        if ($summary) {
            $summary->feedback = $feedbackType;
            $summary->save();
        }
        return view('feedback');
    }
}