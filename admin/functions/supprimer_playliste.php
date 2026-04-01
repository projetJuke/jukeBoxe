<?php
session_start();
require_once "utilities.php";
requireAdminSession("../views/index.php");

require "../../connect.php";

if (!isset($_POST['playlist_id']) || empty($_POST['playlist_id']) || !validateInteger($_POST['playlist_id'])) {
    $_SESSION['error'] = "Playlist invalide.";
    header("Location: ../views/playlist.php");
    exit();
}

try {
    $id = (int) $_POST['playlist_id'];
    $pdo->beginTransaction();

    $sql = "SELECT playlist_id FROM playlists WHERE playlist_id = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if (!$stmt->fetch()) {
        $pdo->rollBack();
        $_SESSION['error'] = "La playlist demandée est introuvable.";
        header("Location: ../views/playlist.php");
        exit();
    }

    $sql = "DELETE FROM belong WHERE playlist_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $sql = "DELETE FROM playlists WHERE playlist_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $pdo->commit();

    $_SESSION['popup'] = "Playlist supprimée avec succès.";
    header("Location: ../views/playlist.php");
    exit();
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    $_SESSION['error'] = "Impossible de supprimer cette playlist.";
    header("Location: ../views/playlist.php");
    exit();
}
