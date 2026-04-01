<?php

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require "../connect.php";
        $db = new PDO(DNS, LOGIN, PASSWORD, $options);

        if (!empty($_POST['nom'])) {

            $sql = "INSERT INTO artists (name)
                    VALUES (:name)";

            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':name' => $_POST['nom'],
            ]);

            $message = "L'artiste a été ajouté avec succès !";
        } else {
            $message = "Veuillez remplir tous les champs obligatoires.";
        }
    } catch (PDOException $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un artiste</title>
    <link rel="stylesheet" href="ajout.css">
</head>

<body>

    <h1>Ajouter un artiste</h1>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="ajout_artist.php" method="post">

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