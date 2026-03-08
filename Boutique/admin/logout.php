<?php
session_start();
session_unset(); // Libère toutes les variables de session
session_destroy(); // Détruit la session
header('Location: login.php'); // Retour au login
exit();
?>