<?php

function getDbConnection(): PDO
{
    $rootPath = dirname(__DIR__, 2);
    $connectFiles = [
        $rootPath . '/connect.php',
        $rootPath . '/connect.exemple.php',
    ];

    foreach ($connectFiles as $connectFile) {
        if (!is_file($connectFile)) {
            continue;
        }

        require $connectFile;

        if (isset($db) && $db instanceof PDO) {
            return $db;
        }

        if (isset($pdo) && $pdo instanceof PDO) {
            return $pdo;
        }
    }

    throw new RuntimeException('Connexion a la base de donnees introuvable.');
}
