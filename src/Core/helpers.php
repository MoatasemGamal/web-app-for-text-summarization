<?php
use Core\App;
use Core\Database;
use Core\Utility\Session;
use Core\Utility\View;

// use setasign\Fpdi\Fpdi;

if (!function_exists("pre")) {
    /**
     * var_dump or print_r with <pre></pre>
     * @param mixed $variable
     * @param bool $print_r
     * @return void
     */
    function pre(mixed ...$variable): void
    {
        echo "<pre dir='ltr'>";
        foreach ($variable as $v)
            var_dump($v);
        echo "</pre>";
    }
}

if (!function_exists("view")) {
    function view(string $path, $data = []): string
    {
        $view = new View($path, $data);
        return $view->render();
    }
}

if (!function_exists("app")) {

    /**
     * get App::$singleton or any of its attributes like App::$singleton->db
     * @param string $attr
     * @return Database|Session
     */
    function app(string $attr = 'self'): mixed
    {
        if ($attr === 'self')
            return App::$singleton;
        elseif (isset(App::$singleton->$attr))
            return App::$singleton->$attr;
        else
            return null;
    }

}


if (!function_exists("transcribeAudio")) {

    function transcribeAudio($audioFilePath)
    {
        $command = 'python ' . SRC_PATH . "transcribe.py $audioFilePath";
        $output = shell_exec($command);
        return $output;
    }
}
if (!function_exists("isAudioFile")) {

    function isAudioFile($extension)
    {
        $audioExtensions = array('mp3', 'wav', 'ogg', 'flac', 'mp4', 'mkv');
        return in_array(strtolower($extension), $audioExtensions);
    }
}
if (!function_exists("processFile")) {

    function processFile($filePath)
    {
        $content = "Unsupported file type";
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        if ($fileExtension === 'txt') {
            $content = file_get_contents($filePath);
        } elseif (isAudioFile($fileExtension)) {
            $content = transcribeAudio($filePath);
        } elseif ($fileExtension === 'pdf') {
            $content = extractTextFromPDF($filePath);
        }

        return $content;
    }
}
if (!function_exists("extractTextFromPDF")) {


    function extractTextFromPDF($filePath)
    {
        $command = "python '" . SRC_PATH . "extractTextFromPDF.py' '$filePath' 2>&1";
        $command = str_replace('\\', '/', $command);
        $output = shell_exec($command);
        return $output;
    }
}


// Summarize via API
if (!function_exists("summarize")) {

    function summarize($text, $model, $summaryLength)
    {
        /*
        // API endpoint URL
        $url = 'http://example.com/summarize';

        // Data to be sent in the POST request
        $postData = [
            'text' => $text,
            'model' => $model,
            'summaryLength' => $summaryLength
        ];

        // Initialize cURL session
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
        curl_setopt($ch, CURLOPT_POST, true); // Set the request method to POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData)); // Set the POST data
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);

        // Execute cURL session
        $response = curl_exec($ch);

        // Check for cURL errors
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            return ['error' => 'Curl error: ' . $error];
        }

        // Close cURL session
        curl_close($ch);

        // Decode JSON response
        $responseData = json_decode($response, true);

        // Check if JSON decoding was successful
        if ($responseData === null && json_last_error() !== JSON_ERROR_NONE) {
            return ['error' => 'Error decoding JSON response'];
        }
*/
        $responseData = [
            'text' => $text,
            'summary' => 'الملخص',
            'model' => $model,
        ]
        ;
        // Return associative array
        return $responseData;
    }
}


function checkLangDirection($text)
{
    $arabicCount = 0;
    $englishCount = 0;

    // Loop through each character in the text
    $length = mb_strlen($text, 'UTF-8');
    for ($i = 0; $i < $length; $i++) {
        $char = mb_substr($text, $i, 1, 'UTF-8');

        // Check if the character is Arabic script
        if (preg_match('/\p{Arabic}/u', $char)) {
            $arabicCount++;
        }
        // Check if the character is Latin script (English)
        elseif (preg_match('/\p{Latin}/u', $char)) {
            $englishCount++;
        }
    }

    // Determine language direction based on script count
    if ($arabicCount > $englishCount) {
        return 'rtl'; // Arabic text
    } else {
        return 'ltr'; // English text (and other languages assumed to be LTR)
    }
}