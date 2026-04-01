<?php
session_start();
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

    <section>
        <h1><strong>Ajouter une musique</strong></h1>
    </section>

    <?php if (isset($message)): ?>
        <p><?= htmlspecialchars($message ?? "") ?></p>
    <?php endif; ?>

    <form action="../functions/create_track.php" method="post" enctype="multipart/form-data">

        <div class="field-group">
            <label>Album :</label>
            <input type="text" name="album" required>
        </div>

        <div class="field-group">
            <label>Durée :</label>
            <input type="text" name="length" required>
        </div>

        <div class="field-group">
            <label>Image (cover) :</label>
            <input type="file" name="cover" accept=".jpg,.png,.jpeg" required>
        </div>

        <div class="field-group">
            <label>Fichier MP3 :</label>
            <input type="file" name="music" accept=".mp3" required>
        </div>
        <div class="actions-bar">
            <button type="submit">Ajouter une musique</button>
            <a href="sons.php">Retour</a>
        </div>
    </form>

</body>

</html>