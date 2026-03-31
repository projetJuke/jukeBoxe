<?php
$tracks = [];
$errorMessage = '';

try {
    require_once __DIR__ . '/../../connect.php';
    require_once __DIR__ . '/utilities.php';

    $tracks = getLesTracksByIdPlaylists($db);
} catch (Throwable $exception) {
    $errorMessage = $exception->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test playlist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 32px;
            background: #f5f5f5;
            color: #222;
        }

        h1 {
            margin-bottom: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #efefef;
        }

        .message {
            padding: 16px;
            background: #fff;
            border: 1px solid #ddd;
        }

        .error {
            border-color: #c62828;
            color: #c62828;
        }
    </style>
</head>

<body>
    <h1>Tracks de la playlist selectionnee</h1>

    <?php if ($errorMessage !== ''): ?>
        <div class="message error">
            <strong>Erreur :</strong>
            <?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php elseif (empty($tracks)): ?>
        <div class="message">Aucun track trouve.</div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Track ID</th>
                    <th>Album</th>
                    <th>Duree</th>
                    <th>ID Cover</th>
                    <th>ID Music</th>
                    <th>Track Code</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tracks as $track): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) $track['track_id'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $track['album'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $track['length'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $track['id_cover'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $track['id_music'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $track['track_code'], ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>

</html>
