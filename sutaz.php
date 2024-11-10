<?php
session_start(); // Začneme session

// Ak nie je užívateľ prihlásený, presmerujeme ho na login stránku
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Pripojíme sa k databáze
$servername = "localhost";
$username = "root"; // Vaše používateľské meno pre databázu
$password = ""; // Vaše heslo pre databázu
$dbname = "projectDB"; // Názov databázy

// Vytvoríme pripojenie
$conn = new mysqli($servername, $username, $password, $dbname);

// Skontrolujeme pripojenie
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Získame user_id zo session
$user_id = $_SESSION['user_id'];

// Načítame body používateľa z databázy
$sql = "SELECT points FROM pouzivatelia WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($points);
$stmt->fetch();
$stmt->close();

// Skontrolujeme, či sa bodové údaje načítali správne
if (!$points) {
    $points = 0; // Ak nie sú body nastavené, nastavíme na 0
}

// Skontrolujeme, či sú nastavené premenné v session
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Neznámy';
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Neznámy';

?>

<!DOCTYPE html>
<html lang="sk">
<head>
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-X9RH3Q5WBL"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-X9RH3Q5WBL');
</script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="icon" href="images/favicon.ico" type="images/favicon.ico" sizes="16x16">
  <title>PhotoMaster</title>
  <link rel="stylesheet" href="styles.css">
  <meta name="description" content="Fotograf - Michael Bartek. Ponuka Fotenia, dizajnu a video tvorby.">
<meta name="keywords" content="ThrowBack, Throwback, TBG, Throwback Graphics, Michael Bartek, trowback graphic, Grafika, Gaficky dizajn, fotografia, atelier, video, kinematografia, animacia, nádych kreativity, tvorba, Umenie, Art, photography, Žilina, Rajecká Lesná, filmova tvorba, reklama, reklamna agentura, dizajn, design, štúdio">
<meta name="author" content="Michael Bartek,">

</head>

<body>
<div class="container2">
    <div class="left-column2">
    <p style="color: #d7be08; padding:  1%;  margin-bottom: 0%; font-size: 30pt;">[ PhotoMaster : <?php echo htmlspecialchars($user_name); ?> ]</p>
    <!-- Navbar -->
    </div>
    <div class="right-column2">
    <p style="color: #d7be08; padding:  1%;  margin-bottom: 0%; font-size: 30pt;"><?php echo htmlspecialchars($points); ?> C</p>
    <!-- Zobrazenie bodov -->
    </div>
</div>

<nav>
  
  <div class="navbarsutaz" id="top">
    <div class="dropdownsutaz">
      <a href="#">Menu</a>
      <div class="dropdown-contentsutaz">
        <a href="index.php">Úvod</a>
        <a href="#home2">Súťaž</a>
        <a href="#subory">Pravidlá súťaže</a>
        <a href="logout.php">Odhlásiť sa</a>

      </div>
    </div>
  </div>

<!-- Home Section -->
<section id="domovv">
  <h1>Aktuálne témy súťaže</h1>
  <div id="countdown"></div>
   
  <div class="container">
    <div class="rectangle">
        <h3 class="textik">Autá</h3>
        <img src="images/image1.jpg" alt="Image 1">
        <p class="textik2"> Zapoj sa! <a style="text-decoration:none; color: #f2f2f2;" href="#subory">Viac info TU.</a></p>
        <a style="text-decoration:none;" href="https://forms.gle/ofYEFr16zfVxgkFi6"><p class="textik3">JOIN</p></a>
    </div>
    
    <div class="rectangle">
      <h3 class="textik">Architektúra</h3>
      <img src="images/image2.jpg" alt="Image 1">
      <p class="textik2"> Zapoj sa! <a style="text-decoration:none; color: #f2f2f2;" href="#subory">Viac info TU.</a></p>
      <a style="text-decoration:none;" href="https://forms.gle/ofYEFr16zfVxgkFi6"><p class="textik3">JOIN</p></a>
  </div>

</div>
</section>
<h3 style='font-size: 20px; text-align: center; font-family: monospace;'>Je možné si zovliť iba jednu tému. Formulár je obmedzený na jedno vyplnenie.</h3>"
  <section id="subory">
    <h1><a style="text-decoration:none; color: #f2f2f2;" href="download/pravidla_sutaze.pdf"  target="_blank">Pravidlá súťaže: TU</a></h1>

    <?php
// Načítanie konfigurácie
include('config.php');

// SQL dotaz na získanie používateľov zoradených podľa bodov zostupne
$query = "SELECT name, mail, points FROM pouzivatelia ORDER BY points DESC LIMIT 10";

// Príprava a vykonanie dotazu
$stmt = $pdo->prepare($query);
$stmt->execute();

// Získanie výsledkov
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obalíme tabuľku do divu s triedou 'leaderboard-container'
echo "<div class='leaderboard-container'>";
echo "<h3 style='font-size: 35px;'>FotoMasters Leaderboard</h3>"; // Pridáme nadpis "Leaderboard"

echo "<table class='leaderboard-table'>"; // Pridáme class na tabuľku
echo "<tr><th>#</th><th>Name</th><th>Coins</th></tr>"; // Pridáme stĺpec na číslo poradia

// Prechádzame cez používateľov a pridávame riadky do tabuľky
$rank = 1; // Počiatočné číslo pre číslovanie
foreach ($users as $user) {
    echo "<tr>";
    echo "<td>" . $rank++ . "</td>"; // Zobrazíme číslo poradia
    echo "<td>" . htmlspecialchars($user['name']) . "</td>";
    echo "<td>" . htmlspecialchars($user['points']) . "</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>"; 
?>
 <a class="textik4" href="logout.php"><i class="fas fa-arrow-left"></i> Odhlásiť sa</a>
 
   </section>
  
<section id="contactsutaz">
  <h2>Kontakt</h2>
  <div class="contact-table">
    <table>
      <tr><th>Telefónný kontakt</th><td>+421 908 600 632</td></tr><tr>
      </tr><tr><th>Mail</th><td>m.bartek@throwback.sk</td></tr>
      <tr><th>Instagram</th><td><a style="text-decoration: none; color: #000000;" href="https://www.instagram.com/mb_.michael/">@mb_.michael</a></td></tr>
      <tr><th>Youtube</th><td><a style="text-decoration: none; color: #000000;" href="https://www.youtube.com/@mb_.michael">@mb_.michael</a></td></tr>
      <tr><th>Unsplash</th><td><a style="text-decoration: none; color: #000000;" href="https://unsplash.com/@throwback_sk">ThrowBack</a></td></tr>
    </table>
</div>

</section>

<footer>
  <div class="navfooter">
    <div class="dropdown">
        <p style="color: #f4f4f4; font-size: 90%;">© <?php echo date("Y"); ?> Michael Bartek</p>
    </div>
  </div>
</footer>
<script>
        // Nastav cílový čas (formát: RRRR-MM-DDTHH:MM:SS)
        const targetDate = new Date("2024-11-24T23:59:59").getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance > 0) {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

                document.getElementById("countdown").innerHTML =
                    days + " d " + hours + " h " + minutes + " m";
            } else {
                document.getElementById("countdown").innerHTML = "Súťaž skončila!";
            }
        }

        // Aktualizuj každou minutu
        setInterval(updateCountdown, 1000);

        // Spusť odpočet hned při načtení stránky
        updateCountdown();
    </script>

</body>
</html>