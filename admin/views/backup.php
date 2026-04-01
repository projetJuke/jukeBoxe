<?php
session_start();
require_once "../functions/utilities.php";
requireAdminSession("index.php");

$message = $_SESSION['backup_message'] ?? null;
$messageType = $_SESSION['backup_message_type'] ?? 'info';
unset($_SESSION['backup_message'], $_SESSION['backup_message_type']);

$env = parse_ini_file(__DIR__ . '/../scripts/.env');
$backupDir = $env['BACKUP_DIR'] ?? (__DIR__ . '/../backups');
$backupFiles = glob(rtrim($backupDir, '/') . '/*.tar.gz');
if ($backupFiles === false) {
    $backupFiles = [];
}

rsort($backupFiles);

$dbBackups = [];
$appBackups = [];

foreach ($backupFiles as $backupFile) {
    $name = basename($backupFile);

    if (strpos($name, 'jukebox-db-') === 0) {
        $dbBackups[] = $name;
        continue;
    }

    if (strpos($name, 'jukebox-app-') === 0) {
        $appBackups[] = $name;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/backup.css">
</head>

<body>
    <main class="backup-page">
        <h1>Sauvegardes</h1>
        <p class="backup-intro">Gère les archives de la base et de l'application depuis une seule page. Les sauvegardes sont stockées dans <code><?= htmlspecialchars($backupDir, ENT_QUOTES, 'UTF-8') ?></code>.</p>
        <div class="backup-panel">
            <div class="backup-grid">
                <section class="backup-card">
                    <h2>Base de données</h2>
                    <p>Génère une archive <code>jukebox-db-AAAA-MM-JJ-HH-MM-SS.tar.gz</code> à partir de la base MariaDB.</p>
                    <form action="../functions/run_backup.php" method="POST" class="backup-actions">
                        <input type="hidden" name="backup_type" value="db">
                        <button class="backup-button" type="submit">Sauvegarder la base</button>
                    </form>
                </section>
                <section class="backup-card">
                    <h2>Application</h2>
                    <p>Génère une archive <code>jukebox-app-AAAA-MM-JJ-HH-MM-SS.tar.gz</code> à partir des fichiers du projet.</p>
                    <form action="../functions/run_backup.php" method="POST" class="backup-actions">
                        <input type="hidden" name="backup_type" value="app">
                        <button class="backup-button" type="submit">Sauvegarder l'application</button>
                    </form>
                </section>
            </div>
            <div class="backup-actions">
                <form action="../functions/run_backup.php" method="POST">
                    <input type="hidden" name="backup_type" value="all">
                    <button class="backup-button" type="submit">Lancer les deux sauvegardes</button>
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
            <h2>Dernieres archives</h2>
            <?php if (empty($backupFiles)): ?>
                <p>Aucune sauvegarde trouvée dans <code><?= htmlspecialchars($backupDir, ENT_QUOTES, 'UTF-8') ?></code>.</p>
            <?php else: ?>
                <div class="backup-grid">
                    <section class="backup-card">
                        <h2>Archives base</h2>
                        <?php if (empty($dbBackups)): ?>
                            <p>Aucune archive de base disponible.</p>
                        <?php else: ?>
                            <ul class="backup-list">
                                <?php foreach ($dbBackups as $backupFile): ?>
                                    <li class="backup-item">
                                        <span class="backup-name"><?= htmlspecialchars($backupFile, ENT_QUOTES, 'UTF-8') ?></span>
                                        <form action="../functions/run_restore_db.php" method="POST">
                                            <input type="hidden" name="backup_file" value="<?= htmlspecialchars($backupFile, ENT_QUOTES, 'UTF-8') ?>">
                                            <button class="restore-button" type="submit">Restaurer cette version</button>
                                        </form>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </section>
                    <section class="backup-card">
                        <h2>Archives application</h2>
                        <?php if (empty($appBackups)): ?>
                            <p>Aucune archive de l'application disponible.</p>
                        <?php else: ?>
                            <ul class="backup-list">
                                <?php foreach ($appBackups as $backupFile): ?>
                                    <li><?= htmlspecialchars($backupFile, ENT_QUOTES, 'UTF-8') ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </section>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>
