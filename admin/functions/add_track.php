<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "Veuillez acceder a la page a travers un formulaire";
    header("Location: ../views/index.php");
    exit();
}

if (!isset($_POST['playlist_id']) || !isset($_POST['id_morceau']) || (!isset($_POST['identifier']) && !empty($_POST['identifier']))) {
    $_SESSION['error'] = "Playlist ou morceau non trouvée";
    header("Location: ../views/index.php");
    exit();
}

require_once "utilities.php";
require_once "../../connect.php";

if (!validateInteger($_POST['playlist_id'])) {
    exit();
}

if (!validateInteger($_POST['id_morceau'])) {
    exit();
}

if (!validateIdentificationCode($_POST['identifier'])) {
    exit();
}

$id_morceau = $_POST['id_morceau'];
$playlist_id = $_POST['playlist_id'];
$track_code = $_POST['identifier'];

$sql_verify = "SELECT * FROM belong 
               WHERE playlist_id = :playlist_id
               AND track_id = :track_id
               LIMIT 1";
$statement = $pdo->prepare($sql_verify);
$statement->bindParam("playlist_id", $playlist_id);
$statement->bindParam("track_id", $id_morceau);
try {
    $statement->execute();
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

$row = $statement->fetch() ?? null;
$statement->closeCursor();
if ($row) {
    $_SESSION['error'] = "Le morceau existe déja dans la playlist";
    header("Location: ../views/gestion_playlist.php?playlist_id=" . $playlist_id . "");
    exit();
}

$sql = "INSERT INTO belong (playlist_id, track_id, track_code)
        VALUES (:playlist_id, :track_id, :track_code)";

$statement = $pdo->prepare($sql);
$statement->bindParam("playlist_id", $playlist_id);
$statement->bindParam("track_id", $id_morceau);
$statement->bindParam("track_code", $track_code);

try {
    $statement->execute();
    $_SESSION['popup'] = "Insértion du morceau effectuée avec succès";
    header("Location: ../views/gestion_playlist.php?playlist_id=" . $playlist_id . "");
    exit();
} catch (Exception $e) {
    echo $e->getMessage();
    $_SESSION['error'] = "Erreur d'insertion du morceau";
    header("Location: ../views/gestion_playlist.php?playlist_id=" . $playlist_id . "");
    exit();
}
