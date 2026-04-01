<?php

require_once __DIR__ . '/../handlers/getSelectedPlaylistTracks.php';
require_once __DIR__ . '/../handlers/getAllSelectedPlaylistTracks.php';
require_once __DIR__ . '/../handlers/getTrackByCode.php';

$routes = [
    'GET' => [
        '/api/tracks' => 'getSelectedPlaylistTracks',
        '/api/tracks/all' => 'getAllSelectedPlaylistTracks',
        '/api/tracks/by-code' => 'getTrackByCode',
    ],
];
