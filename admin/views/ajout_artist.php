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
    <title>Ajouter un artiste</title>
    <link rel="stylesheet" href="../css/ajout.css">
</head>

<body>
    <main class="admin-page form-layout">
        <div class="admin-shell">
            <section class="form-card">
                <header class="page-header page-header--center">
                    <div>
                        <p class="page-kicker">Catalogue</p>
                        <h1 class="page-title">Ajouter un artiste</h1>
                        <p class="page-subtitle">Ajoutez un nouveau nom au catalogue admin.</p>
                    </div>
                    <div class="toolbar">
                        <a class="delete-btn" href="../functions/logout.php">Déconnecter</a>
                    </div>
                </header>

                <?php if (isset($message)): ?>
                    <p class="form-status"><?= htmlspecialchars($message) ?></p>
                <?php endif; ?>

                <form action="../functions/add_artist.php" method="POST">
                    <div class="field-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>

                    <div class="actions-bar">
                        <button type="submit" class="button">Ajouter</button>
                        <a href="artist.php" class="button-secondary">Retour</a>
                    </div>
                </form>
            </section>
        </div>
    </main>
</body>

</html>
