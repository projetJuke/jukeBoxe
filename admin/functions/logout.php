<?php
session_start();
unset($_SESSION['user']);
$_SESSION['popup'] = "Vous êtes déconnecté.";
header("Location: ../views/index.php");
exit();
