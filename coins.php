<?php
// Zapnúť zobrazovanie všetkých chýb pre diagnostiku problémov
error_reporting(E_ALL); 
ini_set('display_errors', 1); 

// Začíname session pre prácu so session premennými
session_start();

// Parametre pre pripojenie na databázu
$servername = "localhost";
$username = "root";  // Zmeňte podľa svojich nastavení
$password = "";      // Zmeňte podľa svojich nastavení
$dbname = "projectDB";

// Pripojenie na databázu
$conn = new mysqli($servername, $username, $password, $dbname);

// Skontrolujte pripojenie
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Skontrolujte, či je používateľ prihlásený
if (!isset($_SESSION['user_id'])) {
    die('Nie ste prihlásený!');  // Ak nie je prihlásený, skript sa zastaví
}

// Uložíme ID prihláseného používateľa do premennej
$user_id = $_SESSION['user_id'];

// Získanie bodov používateľa z databázy
$sql = "SELECT points FROM pouzivatelia WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($points);
$stmt->fetch();
$stmt->close();

// Ak ešte nebol kliknutý, pridáme 2 bodov a presmerujeme
if (!isset($_SESSION['clicked'])) {
    // Pridáme 2 bodov k existujúcim bodom
    $new_points = $points + 2;

    // Aktualizujeme hodnotu bodov v databáze
    $update_sql = "UPDATE pouzivatelia SET points = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ii", $new_points, $user_id);
    $update_stmt->execute();
    $update_stmt->close();

    // Nastavíme, že používateľ už klikol, aby sa body nepridávali opakovane
    $_SESSION['clicked'] = true;

    // Presmerovanie na stránku sutaz.php
    header("Location: sutaz.php");
    exit();  // Uistíme sa, že sa skript zastaví po presmerovaní
} else {
    // Ak už klikol, len ho presmerujeme na stránku bez pridaných bodov
    header("Location: sutaz.php");
    exit();  // Uistíme sa, že sa skript zastaví po presmerovaní
}

// Uzavretie pripojenia k databáze
$conn->close();
?>
