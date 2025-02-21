<?php

// Pripojíme sa k databáze
$host = "localhost";
$username = "root"; // Vaše používateľské meno pre databázu
$password = ""; // Vaše heslo pre databázu
$dbname = "projectDB"; // Názov databázy

try {
    // Pripojenie k databáze
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Nastavenie PDO na hodzenie výnimiek pri chybe
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Chyba pripojenia: ' . $e->getMessage();
}
// Vytvorenie pripojenia k databáze
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrola pripojenia
if ($conn->connect_error) {
    die("Pripojenie zlyhalo: " . $conn->connect_error);
}
?>