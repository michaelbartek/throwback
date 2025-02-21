<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectDB"; // Tvoja databáza

// Vytvorenie pripojenia k databáze
$conn = new mysqli($servername, $username, $password, $dbname);

// Skontroluj pripojenie
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ak bol odoslaný registračný formulár
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];  // Názov používateľa
    $mail = $_POST['mail'];  // E-mail používateľa (teraz "mail" namiesto "email")
    $password = $_POST['password'];  // Heslo používateľa

    // Skontroluj, či už používateľ s týmto emailom neexistuje
    $stmt = $conn->prepare("SELECT id FROM pouzivatelia WHERE mail = ?");
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<p class='popup-bar'>Používateľ s týmto mailom už existuje!</p>";
        $stmt->close();
    } else {
        // Zašifruj heslo
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Vloženie používateľa do databázy vrátane 10 bodov
        $stmt = $conn->prepare("INSERT INTO pouzivatelia (name, mail, password, points) VALUES (?, ?, ?, ?)");
        $points = 10;  // Pridáme 10 bodov
        $stmt->bind_param("sssi", $name, $mail, $hashed_password, $points);

        if ($stmt->execute()) {
            echo "<a style='margin-bottom: 50%; text-decoration:none;' class='popup-bar' href='login.php'>Registrácia bola úspešná! Obdržali ste 10c. Prihláste sa tu</a>";
        } else {
            echo "<a class='popup-bar'>Chyba pri registrácii!</p>";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<link rel="stylesheet" href="styles.css">
