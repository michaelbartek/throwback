<!DOCTYPE html>
<html lang="en">
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
  <link rel="icon" href="images/favicon.ico" type="images/favicon.ico" sizes="16x16">
  <title>PhotoMaster</title>
  <link rel="stylesheet" href="styles.css">
  <meta name="description" content="Fotograf - Michael Bartek. Ponuka Fotenia, dizajnu a video tvorby.">
<meta name="keywords" content="ThrowBack, Throwback, TBG, Throwback Graphics, Michael Bartek, trowback graphic, Grafika, Gaficky dizajn, fotografia, atelier, video, kinematografia, animacia, nádych kreativity, tvorba, Umenie, Art, photography, Žilina, Rajecká Lesná, filmova tvorba, reklama, reklamna agentura, dizajn, design, štúdio">
<meta name="author" content="Michael Bartek,">

<?php
session_start();  // Začneme reláciu (session)

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectDB"; // Tu používame názov databázy "projectDB"

// Vytvorenie pripojenia k databáze
$conn = new mysqli($servername, $username, $password, $dbname);

// Skontroluj pripojenie
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ak bol odoslaný prihlasovací formulár
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['mail'];  // Premenná pre email
    $password = $_POST['password'];  // Premenná pre heslo

    // SQL dotaz na získanie používateľa podľa mailu
    $stmt = $conn->prepare("SELECT id, name, mail, password FROM pouzivatelia WHERE mail = ?");

    // Skontrolujeme, či sa dotaz pripravil správne
    if ($stmt === false) {
        // Ak sa nepodarilo pripraviť dotaz, vypíšeme chybu
        die("Error preparing the query: " . $conn->error);
    }

    // Pripojíme premennú do dotazu
    $stmt->bind_param("s", $email);

    // Vykonáme dotaz
    $stmt->execute();
    $result = $stmt->get_result();

    // Ak používateľ existuje
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Overenie hesla
        if (password_verify($password, $user['password'])) {
            // Ak je heslo správne, nastavíme session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['mail']; 

            // Presmerovanie na chránenu stránku
            header("Location: sutaz.php");  // Alebo inú stránku pre prihlásených
            exit();
        } else {
            // Ak je heslo nesprávne
            echo "<p class='popup-bar'>Nesprávne heslo!</p>";
        }
    } else {
        // Ak používateľ s daným mailom neexistuje
        echo "<p class='popup-bar'>Používateľ s týmto mailom neexistuje!</p>";
    }

    $stmt->close();
}

$conn->close();
?>



</head>
<body>
  <p style="color: #d7be08; padding:  1%; background-color: #333; margin-bottom: 0%; font-size: 30pt;">[ PhotoMaster ]</p>
  <!-- Navbar -->
<nav>
  
  <nav>
    <div class="navbarsutaz" id="top">
      <a href="index.php">ÚVOD</a>
    </div>
  </nav>

  <section id="domovv">
    <h2>Prihlásenie</h2>
    <form style="margin: 40px;" action="login.php" method="post">
      <label class="input1" for="mail">E-mail:</label>
      <input type="text" id="mail" name="mail" required>
    </br >
      <label class="input1" style="margin-top: 20px;" for="password">Heslo:</label>
      <input style="margin-top: 20px;" type="password" id="password" name="password" required>
    </br >
      <button class="loginbutton" style="margin-top: 20px;" type="submit">Prihlásiť sa</button>
  </form>
  <h2 style="margin-top: 50px;">Registrácia</h2>
  <form  style="margin: 40px;" action="register.php" method="POST">
    
      <label class="input1" for="name">Použivateľské meno:</label>
      <input type="text" id="name" name="name" required><br><br>
      
      <label class="input1" for="mail">Mail:</label>
      <input type="mail" id="mail" name="mail" required><br><br>
      
      <label class="input1" for="password">Heslo:</label>
      <input type="password" id="password" name="password" required><br><br>
      
      <button class="loginbutton" type="submit">Registrovať</button>
    </br >
    <p style="margin-top: 40px; font-family: monospace; font-size: 15px;">Vaše osobné údaje sú chránené v súlade s platnými predpismi o ochrane osobných údajov a neprihlasujete sa prostredníctvom tretích strán.</br> Pre problémy s účtom, použite kontakt uvedený nižšie.</p>
  </form>
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

</body>
</html>
