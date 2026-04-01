<?php
session_start();
require_once "utilities.php";
requireAdminSession("../views/index.php");

require "../../connect.php";

if (!isset($_POST['artist_id']) || empty($_POST['artist_id'])) {
    die("Erreur : ID manquant");
}

try {

    $id = (int) $_POST['artist_id'];
    $sql = "DELETE FROM artists WHERE artist_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: ../views/artist.php");
    exit();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
