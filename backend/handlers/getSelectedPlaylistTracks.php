<?php

require_once __DIR__ . '/../functions/utilities.php';

function getSelectedPlaylistTracks(PDO $db): void
{
    $tracks = getRandomTracksBySelectedPlaylist($db, 6);

    echo json_encode([
        'tracks' => $tracks,
    ]);
}
