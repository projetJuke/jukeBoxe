<?php

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require "../connect.php";
        $db = new PDO(DNS, LOGIN, PASSWORD, $options);

        if (!empty($_POST['nom'])) {

            $sql = "INSERT INTO playlists (label)
                    VALUES (:label)";

            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':label' => $_POST['nom'],
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
    <title>Ajouter une playliste</title>
    <link rel="stylesheet" href="ajout.css">
</head>

<body>

    <h1>Ajouter une playliste</h1>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="ajout_playliste.php" method="post">

        <div class="field-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>

        <div class="actions-bar">
            <button type="submit">Ajouter</button>
            <a href="playliste.php">Retour</a>
        </div>

    </form>

</body>

</html>