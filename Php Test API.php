<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $data = $_POST;
    
    // Extract attachments if any
    $attachments = [];
    $attachmentCount = isset($data['attachment-count']) ? intval($data['attachment-count']) : 0;
    for ($i = 1; $i <= $attachmentCount; $i++) {
        $attachments[] = [
            'filename' => $data["attachment-{$i}-filename"],
            'content-type' => $data["attachment-{$i}-content-type"],
            'size' => $data["attachment-{$i}-size"],
            'url' => $data["attachment-{$i}-url"]
        ];
    }
    
    // Prepare the email data
    $emailData = [
        'from' => $data['sender'],
        'to' => $data['recipient'],
        'subject' => $data['subject'],
        'body' => $data['stripped-text'],
        'attachments' => $attachments
    ];
    
    // Convert the email data to JSON
    $emailDataJson = json_encode($emailData);
    
    // Print the email data for debugging
    header('Content-Type: application/json');
    echo $emailDataJson;
    
    // Further processing of email data can be done here (e.g., storing in a database, forwarding to another API, etc.)
    
    // Return a success response
    http_response_code(200);
    echo json_encode(['status' => 'success']);
} else {
    // Return a 405 Method Not Allowed response for non-POST requests
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
}
?>
