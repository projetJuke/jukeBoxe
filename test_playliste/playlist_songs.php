<?php
require "connect.php";
$db = new PDO(DNS, LOGIN, PASSWORD, $options);

if (!isset($_GET['id'])) {
    die("Playlist introuvable");
}

$id = $_GET['id'];

$sql = "SELECT s.title, s.artist_id 
        FROM belong b
        JOIN songs s ON b.song_id = s.song_id
        WHERE b.playlist_id = :id";

$stmt = $db->prepare($sql);
$stmt->execute(['id' => $id]);

echo "<h2>Liste des musiques</h2>";

while ($row = $stmt->fetch()) {
    echo $row['title'] . ' 
        <a href="modifier.php?id=' . urlencode($row['artist_id']) . '">
            Modifier
        </a><br>';
}
