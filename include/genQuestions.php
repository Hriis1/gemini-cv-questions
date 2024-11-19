<?php
require_once '../vendor/autoload.php';
require_once "generateQuestionsGemini.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['job_title'])) {
        $geminiAPIkey = $_ENV['GEMINI_FLASH_API_KEY'];
        $numAttempts = 5;
        for ($i = 0; $i < $numAttempts; $i++) {
            $response = genQuestions($_POST['job_title'], $geminiAPIkey);
            if ($response[0]) {
                echo json_encode($response[1], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                exit();
            }
        }

        echo "Error generating questions!";
    }
}