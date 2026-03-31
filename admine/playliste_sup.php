<?php
require "connect.php";

if (!isset($_POST['track_id']) || empty($_POST['track_id'])) {
    die("Erreur : ID manquant");
}

try {
    $db = new PDO(DNS, LOGIN, PASSWORD, $options);

    $id = (int) $_POST['track_id'];

    $sql = "DELETE FROM tracks WHERE track_id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: playliste.php");
    exit();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
