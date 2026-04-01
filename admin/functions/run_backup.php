<?php
session_start();

require_once "utilities.php";
verifySession();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['backup_message'] = 'Requete invalide pour lancer la sauvegarde.';
    $_SESSION['backup_message_type'] = 'error';
    header('Location: ../views/backup.php');
    exit();
}

$scriptPath = realpath(__DIR__ . '/../scripts/sqldump.sh');

if ($scriptPath === false || !is_file($scriptPath)) {
    $_SESSION['backup_message'] = 'Script de sauvegarde introuvable.';
    $_SESSION['backup_message_type'] = 'error';
    header('Location: ../views/backup.php');
    exit();
}

$command = escapeshellarg($scriptPath) . ' 2>&1';
$output = [];
$exitCode = 1;
exec($command, $output, $exitCode);

if ($exitCode !== 0) {
    $_SESSION['backup_message'] = "Echec de la sauvegarde.\n" . implode("\n", $output);
    $_SESSION['backup_message_type'] = 'error';
    header('Location: ../views/backup.php');
    exit();
}

$_SESSION['backup_message'] = implode("\n", $output);
$_SESSION['backup_message_type'] = 'success';

header('Location: ../views/backup.php');
exit();
