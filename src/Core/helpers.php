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
if (!function_exists('__')) {
    function __($phrase, ...$params)
    {
        //load translates
        $languages = [];
        $langsFiles = glob(LANGUAGES_PATH . '*.php');
        foreach ((array) $langsFiles as $langFile) {
            $languages = array_merge($languages, (array) include "$langFile");
        }
        $phrase = strtolower($phrase);
        $l = App::getCurrentLanguage();
        if (isset($languages[$l][$phrase])) {
            if (str_contains($languages[$l][$phrase], '%d%')) {
                //$count = substr_count($languages[$l][$phrase], '%d%');
                //if (count((array)$params) == $count) {
                $trans = $languages[$l][$phrase];
                foreach ((array) $params as $param) {
                    $trans = str_replace_first('%d%', $param, $trans);
                }
                return $trans;
                //}
            } else
                return $languages[$l][$phrase];
        } else
            return $phrase;
    }
}


// Summarize via API
function sendSummaryRequest($text, $model, $summaryLength, $file_path = null)
{
    $url = 'https://8000-01j0rxmpy4b3a7fq5db4ntmdme.cloudspaces.litng.ai/';

    if ($file_path) {
        $file_info = pathinfo($file_path);
        $extension = strtolower($file_info['extension']);

        if ($extension === 'txt') {
            $content = file_get_contents($file_path);
            return sendSummaryRequest($content, $model, $summaryLength, $file_path = null);
        }
        if ($extension == 'pdf') {
            $url .= 'summarize-pdf';
        } elseif (in_array($extension, ['mp3', 'wav', 'flac', 'aac', 'ogg', 'm4a'])) {
            $url .= 'summarize-audio';
        } else {
            return ["error" => "Unsupported file type"];
        }

        $cfile = curl_file_create($file_path);
        $postfields = [
            'file' => $cfile,
            'model' => $model,
            'summaryLength' => $summaryLength
        ];
    } else {
        $url .= 'summarize';
        $postfields = json_encode([
            'text' => $text,
            'model' => $model,
            'summaryLength' => $summaryLength
        ]);
    }

    $ch = curl_init($url);

    if ($file_path) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    } else {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postfields)
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    }

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        return ["error" => curl_error($ch)];
    }

    curl_close($ch);

    if ($http_code != 200) {
        return ["error" => "Request failed with status code $http_code"];
    }

    return json_decode($response, true);
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