<?php
require "../connect.php";
$db = new PDO(DNS, LOGIN, PASSWORD, $options);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Sons</title>
    <link rel="stylesheet" href="artist.css">
</head>

<body>

    <h1>sons</h1>

    <div class="top-bar">
        <form method="POST" class="search">
            <input type="text" name="name" placeholder="recherche">
            <button type="submit">valider</button>
        </form>

        <a href="ajout_track.php">
            <button class="add-btn">Ajouter</button>
        </a>
    </div>

    <div class="table-container">

        <div class="table-header">
            <span>ID</span>
            <span>Musique</span>
            <span>Durée</span>
            <span>Cover</span>
            <span>Mémoire</span>
            <span>Action</span>
        </div>

        <?php
        try {

            if (!empty($_POST["name"])) {
                $baba = '%' . $_POST["name"] . '%';
                $sql = 'SELECT * FROM tracks WHERE album LIKE :recherche';
                $statement = $db->prepare($sql);
                $statement->bindParam(':recherche', $baba);
            } else {
                $sql = 'SELECT * FROM tracks';
                $statement = $db->prepare($sql);
            }

            $statement->execute();

            while ($row = $statement->fetch()) {
                echo '<div class="row">';

                echo '<span>' . htmlspecialchars($row['track_id']) . '</span>';
                echo '<span>' . htmlspecialchars($row['album']) . '</span>';
                echo '<span>' . htmlspecialchars($row['length']) . '</span>';
                echo '<span>' . htmlspecialchars($row['id_cover']) . '</span>';
                echo '<span>' . htmlspecialchars($row['id_music']) . '</span>';

                echo '<span>
                    <form action="sons_sup.php" method="POST">
                        <input type="hidden" name="track_id" value="' . htmlspecialchars($row['track_id']) . '">
                        <button type="submit" class="delete-btn">Supprimer</button>
                    </form>
                  </span>';

                echo '</div>';
            }
        } catch (PDOException $e) {
            echo 'Échec : ' . $e->getMessage();
        }
        ?>

    </div>

</body>

</html>