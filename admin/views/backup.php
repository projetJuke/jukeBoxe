<?php
session_start();
// require_once "../functions/utilities.php";
// verifySession();

// $message = $_SESSION['backup_message'] ?? null;
// $messageType = $_SESSION['backup_message_type'] ?? 'info';
// unset($_SESSION['backup_message'], $_SESSION['backup_message_type']);

// $backupFiles = glob(__DIR__ . '/../scripts/backups/*.tar.gz');
// if ($backupFiles === false) {
//     $backupFiles = [];
// }

// rsort($backupFiles);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: #f6efe4;
            color: #44211b;
            font-family: sans-serif;
        }

        .backup-page {
            max-width: 900px;
            margin: 0 auto;
            padding: 48px 24px;
        }

        .backup-panel {
            margin-top: 24px;
            padding: 24px;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 12px 30px rgba(68, 33, 27, 0.08);
        }

        .backup-button,
        .back-link {
            display: inline-block;
            padding: 12px 18px;
            border: none;
            border-radius: 999px;
            background: #8f2c24;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
            font-size: 16px;
        }

        .back-link {
            background: #5d524b;
        }

        .backup-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 16px;
        }

        .backup-message {
            margin-top: 16px;
            padding: 12px 16px;
            border-radius: 12px;
        }

        .backup-message.success {
            background: #dff5e3;
            color: #1f5c2c;
        }

        .backup-message.error {
            background: #f8dede;
            color: #8c1d18;
        }

        .backup-list {
            margin-top: 16px;
            padding-left: 20px;
        }

        .backup-list li+li {
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <main class="backup-page">
        <h1>Sauvegarde de la base MariaDB</h1>
        <div class="backup-panel">
            <p>Le bouton ci-dessous lance le script <code>admin/scripts/sqldump.sh</code> et crée une archive au format <code>jukebox-AAAA-MM-JJ.tar.gz</code>.</p>
            <div class="backup-actions">
                <form action="../functions/run_backup.php" method="POST">
                    <button class="backup-button" type="submit">Lancer la sauvegarde</button>
                </form>
                <a class="back-link" href="dashboard.php">Retour au dashboard</a>
            </div>

            <?php if ($message !== null): ?>
                <div class="backup-message <?= htmlspecialchars($messageType, ENT_QUOTES, 'UTF-8') ?>">
                    <?= nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="backup-panel">
            <h2>Dernières archives</h2>
            <?php if (empty($backupFiles)): ?>
                <p>Aucune sauvegarde trouvée dans <code>admin/scripts/backups</code>.</p>
            <?php else: ?>
                <ul class="backup-list">
                    <?php foreach ($backupFiles as $backupFile): ?>
                        <li><?= htmlspecialchars(basename($backupFile), ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>