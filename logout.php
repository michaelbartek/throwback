<?php
session_start();
session_unset();  // Odstráni všetky session premenné
session_destroy(); // Zničí session
header("Location: index.php");  // Presmeruje späť na login stránku
exit();
