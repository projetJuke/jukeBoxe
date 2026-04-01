<?php
require "../../connect.php";

if (!isset($_POST['playlist_id']) || empty($_POST['playlist_id'])) {
    die("Erreur : ID manquant");
}

try {

    $id = (int) $_POST['playlist_id'];

    $sql = "DELETE FROM playlists WHERE playlist_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: ../views/playlist.php");
    exit();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
