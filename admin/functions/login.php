<?php
session_start();

require_once "../../connect.php";
require_once "utilities.php";

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['popup'] = "Veuillez acceder à travers un formulaire à la page.";
    header("Location: index.php"); // Ajouter page d'erreur. 
    exit();
}

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    $_SESSION['popup'] = "Veuillez remplir les données du formulaire";
    header("Location: index.php"); // Page de login.
    exit();
}

if (!validateUsername($_POST['username'], 4, 20) || !validatePassword($_POST['password'], 8, 24)) {
    $_SESSION['popup'] = "Mot de passe ou utilisateur non conforme";
    echo "2";
    header("Location: index.php"); //  Page de login.
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = 'SELECT * FROM users WHERE name = :username';
$statement = $pdo->prepare($sql);
$statement->bindParam("username", $username);

try {
    $statement->execute();
} catch (Exception $e) {
    echo $e->getMessage();
    header("Location: error.php");
    exit();
}

if ($row = $statement->fetch()) {
    $password_hash = $row['password'];
} else {
    $_SESSION['popup'] = 'Utilisateur non trouvée';
    header("Location: index.php");
    exit();
}
$statement->closeCursor();

if (password_verify($password, $password_hash)) {
    $_SESSION['user'] = array(
        'is_logged' => true,
        'username' => $username
    );
    $_SESSION['popup'] = "Identifiants bon";
    header("Location: dashboard.php");
    exit();
} else {
    $_SESSION['popup'] = "Identifiants mauvais";
    header("Location: index.php"); // page login
    exit();
}
