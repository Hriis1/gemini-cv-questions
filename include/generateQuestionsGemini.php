<?php
function genQuestions($jobTitle, $apiKey)
{
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=' . $apiKey;

    // Prepare the data as a JSON string
    $data = [
        'contents' => [
            [
                'role' => 'user',
                'parts' => [
                    [
                        'text' => 'I will give you a job title. I want you to generate 10 possible short questions that the candidate could be asked.
                        I want the questions to be indexed and always in bulgarian, no matter what language is the title.
                        Send nothing else but the questions!',
                    ]
                ]
            ],
            [
                'role' => 'user',
                'parts' => [
                    [
                        'text' => $jobTitle,
                    ]
                ]
            ]
        ],
    ];
    $jsonData = json_encode($data);

    // Initialize cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request and capture the response
    $response = curl_exec($ch);
    $error = curl_error($ch);

    // Close the cURL session
    curl_close($ch);

    // Check for errors
    if ($error) {
        return [false, 'Curl error: ' . $error];
    } else {
        $decodedResponse = json_decode($response, true);

        // Extract and print the text content
        if (isset($decodedResponse['candidates'][0]['content']['parts'][0]['text'])) {
            $questions = explode("\n", $decodedResponse['candidates'][0]['content']['parts'][0]['text']);
            
            // Remove empty elements
            $questions = array_filter($questions, function ($value) {
                return trim($value) !== '';
            });

            return [true, $questions];
        } else {
            //if the text field was not set
            return [false, 'Error with gemini response layout'];
        }
    }
}

