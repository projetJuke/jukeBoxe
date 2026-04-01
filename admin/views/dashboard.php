<?php
session_start();
require_once "../functions/utilities.php";
verifySession();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: #f6efe4;
            color: #44211b;
            font-family: sans-serif;
        }

        .admin-page {
            max-width: 900px;
            margin: 0 auto;
            padding: 48px 24px;
        }

        .admin-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 32px;
        }

        .admin-card {
            padding: 20px;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 12px 30px rgba(68, 33, 27, 0.08);
        }

        .admin-button {
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
    </style>
</head>
<body>
    <main class="admin-page">
        <h1>Dashboard Administration</h1>
        <section class="admin-actions">
            <div class="admin-card">
                <a class="admin-button" href="create_playlist.php">Créer une playlist</a>
            </div>
            <div class="admin-card">
                <a class="admin-button" href="modify_playlist.php">Modifier une playlist</a>
            </div>
            <div class="admin-card">
                <a class="admin-button" href="backup.php">Sauvegarder la base</a>
            </div>
        </section>
    </main>
</body>
</html>
