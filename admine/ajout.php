<?php

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require "connect.php";
        $db = new PDO(DNS, LOGIN, PASSWORD, $options);

        if (!empty($_POST['nom'])) {

            $sql = "INSERT INTO artists (name)
                    VALUES (:name)";

            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':name' => $_POST['nom'], // correction ici
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
</head>

<body>

    <section>
        <h1><strong>Ajouter un artiste</strong></h1>
    </section>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="ajout.php" method="post">

        <div class="field-group">
            <label>Nom :</label>
            <input type="text" name="nom" required>
        </div>

        <div class="actions-bar">
            <button type="submit">Ajouter un artiste</button>
            <a href="artist.php">Retour à la liste</a>
        </div>

    </form>

</body>

</html>