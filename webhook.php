<?php

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the POST data
    $postData = file_get_contents('php://input');

    // If there is POST data
    if (!empty($postData)) {
        // GitHub requires a User-Agent header
        $userAgent = "GitHub-Hookshot/1.0"; // Example user agent, adjust as needed

        // GitHub also requires a Content-Type header for JSON payloads
        $contentType = "application/json"; // Assuming JSON payload, adjust as needed

        // Check if the request comes from GitHub by validating the secret
        $secret = "your_webhook_secret"; // Replace with your webhook secret
        $headers = getallheaders();
        $signature = $headers['X-Hub-Signature'] ?? '';
        $expectedSignature = 'sha1=' . hash_hmac('sha1', $postData, $secret);

        if ($signature === $expectedSignature) {
            // Process the data as needed
            // For demonstration purposes, let's just log it
            file_put_contents('webhook.log', $postData . PHP_EOL, FILE_APPEND);

            // Respond with a success message
            http_response_code(200);
            echo "Webhook received successfully.";
        } else {
            // Respond with an error message if signature verification fails
            http_response_code(403);
            echo "Forbidden - Signature verification failed.";
        }
    } else {
        // Respond with an error message if no POST data received
        http_response_code(400);
        echo "Bad Request - No POST data received.";
    }
} else {
    // Respond with an error message if request method is not POST
    http_response_code(405);
    echo "Method Not Allowed - Only POST requests are allowed.";
}
?>
