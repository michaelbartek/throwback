<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $recipient = "m.bartek@throwback.sk";  // Cieľová emailová adresa
    $subject = "Nový kontakt z formulára";
    
    // Kompletizácia správy
    $email_body = "Meno: $name\nEmail: $email\nSpráva:\n$message\n";

    // Kontrola a nahrávanie súborov
    $attachments = [];
    if (!empty($_FILES['file']['name'][0])) {
        $upload_dir = "uploads/";
        foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['file']['name'][$key];
            $file_tmp = $_FILES['file']['tmp_name'][$key];
            $file_path = $upload_dir . basename($file_name);
            if (move_uploaded_file($file_tmp, $file_path)) {
                $attachments[] = $file_path;
            }
        }
    }

    // Nastavenie hlavičiek pre email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"boundary123\"" . "\r\n";
    $headers .= "From: $email" . "\r\n";
    
    // Skladanie emailu s prílohami
    $message_with_attachments = "--boundary123\r\n";
    $message_with_attachments .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
    $message_with_attachments .= $email_body . "\r\n";

    foreach ($attachments as $file_path) {
        $file_data = file_get_contents($file_path);
        $encoded_file = base64_encode($file_data);
        $file_name = basename($file_path);
        $message_with_attachments .= "--boundary123\r\n";
        $message_with_attachments .= "Content-Type: application/octet-stream; name=\"$file_name\"\r\n";
        $message_with_attachments .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n";
        $message_with_attachments .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $message_with_attachments .= $encoded_file . "\r\n";
    }

    $message_with_attachments .= "--boundary123--";

    // Poslanie emailu
    if (mail($recipient, $subject, $message_with_attachments, $headers)) {
        echo "Email bol úspešne odoslaný!";
    } else {
        echo "Chyba pri odosielaní emailu!";
    }
}
?>
