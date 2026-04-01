<?php
require "../connect.php";

if (!isset($_POST['playlist_id']) || empty($_POST['playlist_id'])) {
    die("Erreur : ID manquant");
}

try {
    $db = new PDO(DNS, LOGIN, PASSWORD, $options);

    $id = (int) $_POST['playlist_id'];

    $sql = "DELETE FROM playlists WHERE playlist_id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: playliste.php");
    exit();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
