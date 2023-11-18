<?php

// Check if the request is coming from a POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize input data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING); // Added FILTER_SANITIZE_STRING for name
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING); // Added FILTER_SANITIZE_STRING for subject
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING); // Added FILTER_SANITIZE_STRING for message

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        // Respond with an error message
        http_response_code(400);
        echo "Please fill all the fields.";
        exit;
    }

    // If email validation fails
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email format";
        exit;
    }

    // Process the data
    // For example, sending an email
    $to = 'contact@michuyim.uk'; // Replace with your email address
    $email_subject = "New message from $name: $subject";
    $email_body = "You have received a new message from your website contact form.\n" .
                  "Here are the details:\n Name: $name\n Email: $email\n Subject: $subject\n Message:\n$message";

    // Headers must be separated with a CRLF (\r\n)
    $headers = "From: noreply@colibri.foundation\r\n"; // Replace with your domain
    // Add an MIME version header
    $headers .= "MIME-Version: 1.0\r\n";
    // Define content-type header for HTML email
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    // Append Reply-To header
    $headers .= "Reply-To: $email\r\n";

    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "Message sent successfully.";
    } else {
        http_response_code(500);
        echo "Message could not be sent.";
    }
} else {
    // Not a POST request
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
