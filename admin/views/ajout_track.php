<?php
session_start();
require_once "../functions/utilities.php";
requireAdminSession("index.php");
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter une musique</title>
    <link rel="stylesheet" href="../css/ajout.css">
</head>

<body>
    <main class="admin-page form-layout">
        <div class="admin-shell">
            <section class="form-card">
                <header class="page-header page-header--center">
                    <div>
                        <p class="page-kicker">Bibliothèque</p>
                        <h1 class="page-title">Ajouter une musique</h1>
                        <p class="page-subtitle">Importez le morceau, sa durée et sa cover depuis l’admin.</p>
                    </div>
                    <div class="toolbar">
                        <a class="delete-btn" href="../functions/logout.php">Déconnecter</a>
                    </div>
                </header>

                <?php if (isset($message)): ?>
                    <p class="form-status"><?= htmlspecialchars($message) ?></p>
                <?php endif; ?>

                <form action="../functions/create_track.php" method="post" enctype="multipart/form-data">
                    <div class="field-group">
                        <label for="album">Album</label>
                        <input type="text" id="album" name="album" required>
                    </div>

                    <div class="field-group">
                        <label for="length">Durée</label>
                        <input type="text" id="length" name="length" required>
                    </div>

                    <div class="field-group">
                        <label for="cover">Image (cover)</label>
                        <input type="file" id="cover" name="cover" accept=".jpg,.png,.jpeg" required>
                    </div>

                    <div class="field-group">
                        <label for="music">Fichier MP3</label>
                        <input type="file" id="music" name="music" accept=".mp3" required>
                    </div>
                    <div class="actions-bar">
                        <button type="submit" class="button">Ajouter la musique</button>
                        <a href="sons.php" class="button-secondary">Retour</a>
                    </div>
                </form>
            </section>
        </div>
    </main>
</body>

</html>
