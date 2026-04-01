<?php 
session_start();
require_once "../functions/utilities.php";
requireAdminSession("index.php");
include_once "../functions/get_playlist.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier playlist</title>
    <link rel="stylesheet" href="../css/ajout.css">
</head>
<body>
    <main class="admin-page form-layout">
        <div class="admin-shell">
            <section class="form-card">
                <header class="page-header page-header--center">
                    <div>
                        <p class="page-kicker">Programmation</p>
                        <h1 class="page-title">Modifier la playlist</h1>
                        <p class="page-subtitle"><?= htmlspecialchars($playlist['label'] ?? "") ?></p>
                    </div>
                    <div class="toolbar">
                        <a class="delete-btn" href="../functions/logout.php">Déconnecter</a>
                    </div>
                </header>
                <form action="../functions/update_playlist.php" method="POST">
                    <div class="field-group">
                        <label for="playlist_name">Nom de la playlist</label>
                        <input type="text" id="playlist_name" name="playlist_name" value="<?= htmlspecialchars($playlist['label'] ?? "") ?>" required>
                    </div>
                    <input type="hidden" name="playlist_id" value="<?= htmlspecialchars($playlist['playlist_id'] ?? "") ?>">
                    <div class="actions-bar">
                        <button type="submit" class="button">Valider</button>
                        <a href="playlist.php" class="button-secondary">Retour</a>
                    </div>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
