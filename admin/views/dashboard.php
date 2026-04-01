<?php
session_start();
require_once "../functions/utilities.php";
requireAdminSession("index.php");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/artist.css">
</head>

<body>
    <main class="admin-page">
        <div class="admin-shell stack">
            <header class="page-header page-header--center">
                <div>
                    <p class="page-kicker">Jukebox Admin</p>
                    <h1 class="page-title">Dashboard Administration</h1>
                    <p class="page-subtitle">Pilotez les playlists, les artistes et les morceaux avec une interface visuelle alignée sur l’univers du frontend.</p>
                </div>
                <div class="toolbar">
                    <a class="delete-btn" href="../functions/logout.php">Déconnecter</a>
                </div>
            </header>

            <section class="dashboard-grid">
                <a class="nav-card" href="playlist.php">
                    <strong>Playlists</strong>
                    <span>Créer, renommer et organiser les playlists.</span>
                </a>
                <a class="nav-card" href="artist.php">
                    <strong>Artistes</strong>
                    <span>Ajouter, rechercher et nettoyer le catalogue.</span>
                </a>
                <a class="nav-card" href="sons.php">
                    <strong>Musiques</strong>
                    <span>Importer les morceaux et suivre leurs fichiers associés.</span>
                </a>
                <a class="nav-card" href="backup.php">
                    <strong>Backup</strong>
                    <span>Exécuter les scripts de sauvegarde</span>
                </a>
            </section>
        </div>
    </main>
</body>

</html>