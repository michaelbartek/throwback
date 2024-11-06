<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Handle file upload if any files are attached
    if (!empty($_FILES['fileInput']['name'][0])) {
        $uploadedFiles = $_FILES['fileInput'];
        $uploadDir = 'uploads/';

        // Ensure upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($uploadedFiles['tmp_name'] as $key => $tmpName) {
            $fileName = basename($uploadedFiles['name'][$key]);
            move_uploaded_file($tmpName, $uploadDir . $fileName);
        }
    }

    $to = 'm.bartek@throwback.sk';
    $subject = 'New Contact Form Submission';
    $body = "Name: $name\nEmail: $email\nMessage:\n$message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo "Message sent successfully!";
    } else {
        echo "Failed to send the message.";
    }
}
?>
