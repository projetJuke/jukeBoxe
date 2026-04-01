<?php
require "connect.php";
$db = new PDO(DNS, LOGIN, PASSWORD, $options);


if (!isset($_POST['artist_id'], $_POST['name'])) {
    die("Erreur formulaire");
}

$id = (int) $_POST['artist_id'];
$nom = $_POST['name'];


$sql = "UPDATE artists 
        SET name = :name
        WHERE artist_id = :id";

$stmt = $db->prepare($sql);

$stmt->execute([
    'name' => $nom,
    'id' => $id
]);

header("Location: artist.php");
exit();
