<?php
require "../connect.php";

if (!isset($_POST['artist_id']) || empty($_POST['artist_id'])) {
    die("Erreur : ID manquant");
}

try {
    $db = new PDO(DNS, LOGIN, PASSWORD, $options);

    $id = (int) $_POST['artist_id'];

    $sql = "DELETE FROM artists WHERE artist_id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: artist.php");
    exit();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
