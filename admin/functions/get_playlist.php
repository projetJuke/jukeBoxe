<?php 

include_once "../../connect.php";
include_once "utilities.php";


$sql = "SELECT * FROM playlists 
        where playlist_id = :id";
$statement = $pdo->prepare($sql);
$statement->bindParam("id", $_GET['playlist_id']);

try{ 
    $statement->execute();
} catch(Exception $e) {
    $e->getMessage();
    $_SESSION['error'] = "Erreur de connexion a la base de données";
    header("Location: ../views/index.php");
    exit();
}

$playlist = $statement->fetch();


