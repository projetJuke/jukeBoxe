<?php
session_start();

require_once __DIR__ . "/../../connect.php";
require_once __DIR__ . "/utilities.php";

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['popup'] = "Veuillez acceder à travers un formulaire à la page.";
    header("Location: ../views/index.php"); // Ajouter page d'erreur. 
    exit();
}

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    $_SESSION['popup'] = "Veuillez remplir les données du formulaire";
    header("Location: ../views/index.php"); // Page de login.
    exit();
}

if (!validateUsername($_POST['username'], 4, 20) || !validatePassword($_POST['password'], 8, 24)) {
    $_SESSION['popup'] = "Mot de passe ou utilisateur non conforme";
    header("Location: ../views/index.php"); //  Page de login.
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = 'SELECT * FROM users WHERE name = :username';
$statement = $db->prepare($sql);
$statement->bindParam("username", $username);

try {
    $statement->execute();
} catch (Exception $e) {
    $_SESSION['popup'] = "Erreur de connexion a la base ou requete invalide";
    header("Location: ../views/index.php");
    exit();
}

if ($row = $statement->fetch()) {
    $password_hash = $row['password'];
} else {
    $_SESSION['popup'] = 'Utilisateur non trouvée';
    header("Location: ../views/index.php");
    exit();
}
$statement->closeCursor();

if (password_verify($password, $password_hash)) {
    $_SESSION['user'] = array(
        'is_logged' => true,
        'username' => $username
    );
    $_SESSION['popup'] = "Identifiants bon";
    header("Location: ../views/dashboard.php");
    exit();
} else {
    $_SESSION['popup'] = "Identifiants mauvais";
    header("Location: ../views/index.php");
    exit();
}
