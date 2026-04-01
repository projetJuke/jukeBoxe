<?php
session_start();
require_once "utilities.php";
requireAdminSession("../views/index.php");

if ($_SERVER['REQUEST_METHOD'] !== "POST"){
    $_SESSION['error'] = "Veuillez acceder a la page a travers un formulaire";
    header("Location: ../views/index.php");
    exit();
}

if (!isset($_POST['playlist_name']) || empty($_POST['playlist_name'])) {
    $_SESSION['error'] = "Veuillez ajouter un nom à la playlist";
    header("Location: ../views/ajouter_playlist.php");
    exit();
}

require_once "../../connect.php";

$playlist_name = $_POST['playlist_name'];

$sql_verif = "SELECT * FROM playlists 
              WHERE label = :label";
$statement = $pdo->prepare($sql_verif);
$statement->bindParam("label", $playlist_name);

try{
    $statement->execute();
} catch(Exception $e){
    $e->getMessage();
    $_SESSION['error'] = "Erreur de connexion à la base de données";
    header("Location: ../views/index.php");
    exit();
}

$row = $statement->fetch() ?? NULL;

if ($row) {
    $_SESSION['error'] = "Le nom insérer est déjà pris";
    header("Location: ../views/ajouter_playlist.php");
    exit();
}

$sql = "INSERT INTO playlists(label, is_selected)
        VALUES (:label, 0)";
$statement = $pdo->prepare($sql);
$statement->bindParam("label", $playlist_name);

try {
    $statement->execute();
} catch (Exception $e) {
    $e->getMessage();
    $_SESSION['error'] = "Erreur de connexion à la base de données"; 
    header("Location: ../views/ajouter_playlist.php");
    exit();
}

$lastid = $pdo->lastInsertId();

$_SESSION['popup'] = "Successfuly inserted the playlist";
header("Location: ../views/gestion_playlist.php?playlist_id= " . $lastid . "");
exit();
