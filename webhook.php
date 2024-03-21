<?php

// Get the POST data
$postData = file_get_contents('php://input');

// If there is POST data
if (!empty($postData)) {
    // Decode JSON data if it's JSON
    $data = json_decode($postData, true);

    // Process the data as needed
    // For demonstration purposes, let's just log it
    file_put_contents('webhook.log', print_r($data, true), FILE_APPEND);

    // Respond with a success message
    echo "Webhook received successfully.";
} else {
    // Respond with an error message if no POST data received
    echo "No POST data received.";
}
?>