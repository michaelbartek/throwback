<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ak používate Composer
// require 'phpmailer/PHPMailer.php'; // Ak ste PHPMailer stiahli manuálne

$mail = new PHPMailer(true);

try {
    // Nastavenie UTF-8 na podporu diakritiky
    $mail->CharSet = "UTF-8";
    $mail->Encoding = "base64";

    // SMTP konfigurácia
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Alebo váš SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'michal.bartek2004@gmail.com'; // Admin e-mail
    $mail->Password = 'bbas lvor qakj yodm'; // Aplikačné heslo
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Získanie dát z formulára
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST["phone"]);
    $message = htmlspecialchars($_POST["message"]);

    // 📩 Admin dostane e-mail od zákazníka
    $mail->setFrom($email, $name); // Správny odosielateľ (zákazník)
    $mail->addAddress("michal.bartek2004@gmail.com"); // Admin e-mail

    // 📩 Zákazník dostane kópiu e-mailu (CC/BCC)
    $mail->addReplyTo($email, $name); // Ak admin odpovie, pôjde to zákazníkovi
    $mail->addCC($email); // Kópia pre zákazníka (môže vidieť)
    // $mail->addBCC($email); // Ak chcete skrytú kópiu (nevidí iných príjemcov)

    // Obsah e-mailu
    $mail->Subject = "Otázka / Požiadavka - tím SPEJS STUDIO s.r.o";
    $mail->Body = "Meno Priezvisko / Meno Firmy: $name\nMail: $email\nTel. číslo: $phone\n\nSpráva:\n$message\n––––––––––––––––––––––––––––––\nĎakujeme za vašu správu. Odpovieme vám čo najskôr.
Spejs Studio s.r.o.";

    $mail->send();
    echo "Správa bola úspešne odoslaná!";
} catch (Exception $e) {
    echo "Chyba pri odosielaní: {$mail->ErrorInfo}";
}
?>

