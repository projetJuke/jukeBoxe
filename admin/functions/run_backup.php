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

$action = $_POST['backup_type'] ?? '';
$availableScripts = [
    'db' => realpath(__DIR__ . '/../scripts/sqldump.sh'),
    'app' => realpath(__DIR__ . '/../scripts/app_backup.sh'),
];

if ($action === 'db') {
    $scripts = [$availableScripts['db']];
} elseif ($action === 'app') {
    $scripts = [$availableScripts['app']];
} elseif ($action === 'all') {
    $scripts = [$availableScripts['db'], $availableScripts['app']];
} else {
    $_SESSION['backup_message'] = 'Type de sauvegarde invalide.';
    $_SESSION['backup_message_type'] = 'error';
    header('Location: ../views/backup.php');
    exit();
}

foreach ($scripts as $scriptPath) {
    if ($scriptPath === false || !is_file($scriptPath)) {
        $_SESSION['backup_message'] = 'Script de sauvegarde introuvable.';
        $_SESSION['backup_message_type'] = 'error';
        header('Location: ../views/backup.php');
        exit();
    }
}

$messages = [];

foreach ($scripts as $scriptPath) {
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

    $messages[] = implode("\n", $output);
}

$_SESSION['backup_message'] = implode("\n", $messages);
$_SESSION['backup_message_type'] = 'success';

header('Location: ../views/backup.php');
exit();
