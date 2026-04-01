<?php

require_once __DIR__ . '/../functions/utilities.php';

function getAllSelectedPlaylistTracks(PDO $db): void
{
    $tracks = getAllTracksBySelectedPlaylist($db);

    echo json_encode([
        'tracks' => $tracks,
    ]);
}
