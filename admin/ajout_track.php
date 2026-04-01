<?php

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require "../connect.php";
        $db = new PDO(DNS, LOGIN, PASSWORD, $options);

        if (!empty($_POST['album']) && !empty($_POST['length'])) {

            /* ====== IMAGE ====== */
            $coverName = $_FILES['cover']['name'];
            $coverTmp = $_FILES['cover']['tmp_name'];
            $coverPath = "../frontend/public/images/" . $coverName;

            if (move_uploaded_file($coverTmp, $coverPath)) {
                echo "Image upload OK<br>";
            } else {
                echo "Erreur upload image<br>";
            }

            /* ====== MP3 ====== */
            $musicName = $_FILES['music']['name'];
            $musicTmp = $_FILES['music']['tmp_name'];
            $musicPath = "../frontend/public/audio/" . $musicName;

            if (move_uploaded_file($musicTmp, $musicPath)) {
                echo "MP3 upload OK<br>";
            } else {
                echo "Erreur upload MP3<br>";
            }

            /* ====== INSERT ====== */
            $sql = "INSERT INTO tracks (album, length, id_cover, id_music)
                    VALUES (:album, :length, :id_cover, :id_music)";

            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':album' => $_POST['album'],
                ':length' => $_POST['length'],
                ':id_cover' => $coverName,
                ':id_music' => $musicName
            ]);

            $message = "Musique + image ajoutées avec succès !";
        } else {
            $message = "Veuillez remplir tous les champs.";
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
    <title>Ajouter une musique</title>
    <link rel="stylesheet" href="ajout.css">
</head>

<body>

    <section>
        <h1><strong>Ajouter une musique</strong></h1>
    </section>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="ajout_track.php" method="post" enctype="multipart/form-data">

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