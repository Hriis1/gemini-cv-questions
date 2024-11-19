<?php
require_once "generateQuestionsGemini.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['job_title'])) {
        $geminiAPIkey = $_ENV['GEMINI_FLASH_API_KEY'];
        echo json_encode(genQuestions($_POST['job_title'], $geminiAPIkey), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}