<?php
session_start();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un artiste</title>
    <link rel="stylesheet" href="../css/ajout.css">
</head>

<body>

    <h1>Ajouter un artiste</h1>

    <?php if (isset($message)): ?>
        <p><?= htmlspecialchars($message) ?? "" ?></p>
    <?php endif; ?>

    <form action="../functions/add_artist.php" method="POST">

        <div class="field-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>

        <div class="actions-bar">
            <button type="submit">Ajouter</button>
            <a href="artist.php">Retour</a>
        </div>

    </form>

</body>

</html>