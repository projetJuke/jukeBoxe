<?php

require_once __DIR__ . '/../functions/utilities.php';

function getTrackByCode(PDO $db): void
{
    $trackCode = strtoupper(trim($_GET['code'] ?? ''));

    if (!preg_match('/^[A-I][1-9]$/', $trackCode)) {
        http_response_code(400);
        echo json_encode(['error' => 'Code track invalide.']);
        return;
    }

    $track = getTrackByCodeFromSelectedPlaylist($db, $trackCode);

    if ($track === null) {
        http_response_code(404);
        echo json_encode(['error' => 'Track introuvable pour ce code.']);
        return;
    }

    echo json_encode([
        'track' => $track,
    ]);
}
