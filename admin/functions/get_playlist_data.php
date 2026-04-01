<?php
require_once "../../connect.php";
include_once "utilities.php";

$playlist_id = $_GET['playlist_id'];

if (!validateInteger($playlist_id)) {
    die();
}

$sql = "SELECT p.playlist_id, p.label, t.album, t.length, t.track_id, a.name, b.track_code FROM playlists p
        INNER JOIN belong b ON p.playlist_id = b.playlist_id 
        INNER JOIN tracks t ON b.track_id = t.track_id
        INNER JOIN produce pr ON pr.track_id = t.track_id
        INNER JOIN artists a ON pr.artist_id = a.artist_id
        WHERE p.playlist_id = :id
        ORDER BY track_code ASC";

$statement = $pdo->prepare($sql);
$statement->bindParam("id", $playlist_id);
try {
    $statement->execute();
} catch (Exception $e) {
    echo $e->getMessage();
}

$playlist = [];
if ($row = $statement->fetch()) {
    $playlist[$row['track_code']] = $row;
    $playlist_name = $row['label'];
    $playlist_id = $row['playlist_id'];
    while ($row = $statement->fetch()) {
        $playlist[$row['track_code']] = $row;
    }
}
$statement->closeCursor();

$sql_morceaux = "SELECT t.track_id, t.album, t.length, t.id_cover, t.id_music, a.artist_id, a.name FROM tracks t
                 INNER JOIN produce p ON t.track_id = p.track_id 
                 INNER JOIN artists a ON p.artist_id = a.artist_id;
                ";
$statement = $pdo->prepare($sql_morceaux);
try {
    $statement->execute();
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

$morceaux = [];
while ($row = $statement->fetch()) {
    $morceaux[] = $row;
}

$list = array(
    'A',
    'B',
    'C',
    'D',
    'E',
    'F',
    'G',
    'H',
    'I'
);

$identifier_list = [];

foreach ($list as $letter) {
    for ($i = 1; $i <= 9; $i++) {
        $identifier_list[] = $letter . $i;
    }
}
