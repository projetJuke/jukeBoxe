<?php
session_start();
require_once "utilities.php";
requireAdminSession("../views/index.php");
require_once "../../connect.php";

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "Veuillez accéder à la page via le formulaire prévu.";
    header("Location: ../views/playlist.php");
    exit();
}

if (!isset($_POST['playlist_id']) || empty($_POST['playlist_id']) || !validateInteger($_POST['playlist_id'])) {
    $_SESSION['error'] = "Playlist invalide.";
    header("Location: ../views/playlist.php");
    exit();
}

$playlist_id = (int) $_POST['playlist_id'];

try {
    $pdo->beginTransaction();

    $statement = $pdo->prepare("SELECT playlist_id FROM playlists WHERE playlist_id = :id LIMIT 1");
    $statement->bindParam("id", $playlist_id);
    $statement->execute();

    if (!$statement->fetch()) {
        $pdo->rollBack();
        $_SESSION['error'] = "La playlist demandée est introuvable.";
        header("Location: ../views/playlist.php");
        exit();
    }

    $pdo->exec("UPDATE playlists SET is_selected = 0");

    $statement = $pdo->prepare("UPDATE playlists SET is_selected = 1 WHERE playlist_id = :id");
    $statement->bindParam("id", $playlist_id);
    $statement->execute();

    $pdo->commit();

    $_SESSION['popup'] = "Playlist sélectionnée avec succès.";
    header("Location: ../views/playlist.php");
    exit();
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    $_SESSION['error'] = "Impossible de sélectionner cette playlist.";
    header("Location: ../views/playlist.php");
    exit();
}
