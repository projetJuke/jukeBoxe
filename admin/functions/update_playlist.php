<?php 

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "Veuillez acceder a la page a travers un formulaire";
    header("Location: ../views/playlists.php");
    exit();
} 

if (!isset($_POST['playlist_id']) || empty($_POST['playlist_id']) && !isset($_POST['playlist_name']) || empty($_POST['playlist_name'])) {
    $_SESSION['error'] = "Veuillez saisir les informations neccessaires";
    header("Location: ../views/playlists.php");
    exit();
}

require "utilities.php";
require "../../connect.php";

if (!validateInteger($_POST['playlist_id'])) {
    $_SESSION['error'] = "Une erreur est parvenu";
    header("Location: ../views/index.php");
    exit();
}

$playlist_id = $_POST['playlist_id'];
$playlist_name = $_POST['playlist_name'];

$sql_verify = "SELECT * FROM playlists
               WHERE playlist_id = :id";
$statement = $pdo->prepare($sql);
$statement->bindParam("id", $playlist_id);

try{
    $statement->execute();
} catch(Exception $e) {
    $e->getMessage();
    $_SESSION['error'] = "Erreur de connexion à la base de données";
    header("Location: playlists.php");
    exit();
}

$row = $statement->fetch() ?? NULL;
$statement->closeCursor();

if (!$row){
    $_SESSION['error'] = "La playlist n'existe pas";
    header("Location: ../views/playlists.php");
    exit();
}

$sql = "UPDATE playlists 
        SET label = :label 
        WHERE playlist_id = :id";
$statement = $pdo->prepare($sql);
$statement->bindParam("label", $playlist_name);
$statement->bindParam("id", $playlist_id);

try {
    $statement->execute();
} catch(Exception $e){ 
    $e->getMessage();
    $_SESSION['error'] = "Une erreur est parvenu";
    header("Location: ../views/playlists.php"); 
    exit();
}

$_SESSION['popup'] = "Modifications effetuées avec succès";
header("Location: ../views/playlists.php");
exit();