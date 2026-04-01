<?php
session_start();
require_once "utilities.php";
requireAdminSession("../views/index.php");

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "Access non authorisé";
    header("Location: ../views/index.php");
    exit();
}
require_once "../../connect.php";

if (!validateInteger($_POST['playlist_id'])) {
    $_SESSION['error'] = "Playlist non existante";
    header("Location: ../views/dashboard");
    exit();
}

if (!validateIdentificationCode($_POST['track_code'])) {
    $_SESSION['error'] = "Track non trouvée dans la playlist";
    header("Location: ../views/gestion_playlist?playlist_id=" . $_POST['playlist_id'] . "");
    exit();
}

$track_code = $_POST['track_code'];
$playlist_id = $_POST['playlist_id'];


$sql_verif = "SELECT * FROM belong 
              WHERE playlist_id = :play_id
              AND track_code = :track_code 
              LIMIT 1";
$statement = $pdo->prepare($sql_verif);
$statement->bindParam("play_id", $playlist_id);
$statement->bindParam("track_code", $track_code);

try {
    $statement->execute();
} catch (Exception $e) {
    $e->getMessage();
    $_SESSION['error'] = "Erreur est parvenu lors de la connection à la base de données";
    header("Location: ../views/index.php");
    exit();
}

$row = $statement->fetch() ?? null;
$statement->closeCursor();

if (!$row) {
    echo $_SESSION['error'] = "Morceau pas trouvée dans la playlist.";
    header("Location: ../views/gestion_playlist.php?playlist_id=" . $playlist_id . "");
    exit();
}

$sql = "DELETE FROM belong 
        WHERE playlist_id = :play_id
        AND track_code = :track_code";
$statement = $pdo->prepare($sql);
$statement->bindParam("play_id", $playlist_id);
$statement->bindParam("track_code", $track_code);

try {
    $statement->execute();
    $_SESSION['popup'] = "Morceau supprimer avec succès";
    header("Location: ../views/gestion_playlist.php?playlist_id=" . $playlist_id . "");
    exit();
} catch (Exception $e) {
    echo $e->getMessage();
    $_SESSION['error'] = "Erreur de suppression du morceau";
    header("Location: ../views/gestion_playlist.php?playlist_id=" . $playlist_id . "");
    exit();
}
