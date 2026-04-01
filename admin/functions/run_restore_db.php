<?php
session_start();

require_once "utilities.php";
verifySession();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['backup_message'] = 'Requete invalide pour lancer la restauration.';
    $_SESSION['backup_message_type'] = 'error';
    header('Location: ../views/backup.php');
    exit();
}

$backupName = basename($_POST['backup_file'] ?? '');

if ($backupName === '' || strpos($backupName, 'jukebox-db-') !== 0 || substr($backupName, -7) !== '.tar.gz') {
    $_SESSION['backup_message'] = 'Nom de sauvegarde invalide.';
    $_SESSION['backup_message_type'] = 'error';
    header('Location: ../views/backup.php');
    exit();
}

$env = parse_ini_file(__DIR__ . '/../scripts/.env');
$configuredBackupDir = $env['BACKUP_DIR'] ?? (__DIR__ . '/../backups');
$backupDir = realpath($configuredBackupDir);
$scriptPath = realpath(__DIR__ . '/../scripts/restore_db.sh');

if ($backupDir === false || $scriptPath === false || !is_file($scriptPath)) {
    $_SESSION['backup_message'] = 'Script ou dossier de restauration introuvable.';
    $_SESSION['backup_message_type'] = 'error';
    header('Location: ../views/backup.php');
    exit();
}

$backupPath = realpath($backupDir . '/' . $backupName);

if ($backupPath === false || strpos($backupPath, $backupDir . DIRECTORY_SEPARATOR) !== 0 || !is_file($backupPath)) {
    $_SESSION['backup_message'] = 'Archive de base introuvable.';
    $_SESSION['backup_message_type'] = 'error';
    header('Location: ../views/backup.php');
    exit();
}

$command = escapeshellarg($scriptPath) . ' ' . escapeshellarg($backupPath) . ' 2>&1';
$output = [];
$exitCode = 1;
exec($command, $output, $exitCode);

if ($exitCode !== 0) {
    $_SESSION['backup_message'] = "Echec de la restauration.\n" . implode("\n", $output);
    $_SESSION['backup_message_type'] = 'error';
    header('Location: ../views/backup.php');
    exit();
}

$_SESSION['backup_message'] = implode("\n", $output);
$_SESSION['backup_message_type'] = 'success';

header('Location: ../views/backup.php');
exit();
