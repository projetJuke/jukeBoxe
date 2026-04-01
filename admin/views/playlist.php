<?php
require "../../connect.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Playlists</title>
    <link rel="stylesheet" href="../css/artist.css">
</head>

<body>

    <h1>Playlists</h1>

    <div class="top-bar">
        <form method="POST" class="search">
            <input type="text" name="name" placeholder="recherche">
            <button type="submit">valider</button>
        </form>

        <a href="ajouter_playlist.php">
            <button class="add-btn">Ajouter</button>
        </a>
    </div>

    <div class="table-container">
        <div class="table-header">
            <span>id</span>
            <span>nom</span>
            <span></span>
        </div>

        <?php
        try {

            if (!empty($_POST["label"])) {
                $baba = '%' . $_POST["label"] . '%';
                $sql = 'SELECT * FROM playlists WHERE name LIKE :recherche';
                $statement = $pdo
                    ->prepare($sql);
                $statement->bindParam(':recherche', $baba);
            } else {
                $sql = 'SELECT * FROM playlists';
                $statement = $pdo
                    ->prepare($sql);
            }

            $statement->execute();

            while ($row = $statement->fetch()) {
                echo '<div class="row">';
                echo '<span>' . htmlspecialchars($row['playlist_id']) . '</span>';
                echo '<span>' . htmlspecialchars($row['label']) . '</span>';

                echo '<form action="../functions/supprimer_playliste.php" method="POST">
                <input type="hidden" name="playlist_id" value="' . $row['playlist_id'] . '">
                <button type="submit" class="delete-btn">Supprimer</button>
              </form>';
                echo '<form action="modifier_playliste.php" method="POST">
                <input type="hidden" name="artist_id" value="' . $row['playlist_id'] . '">
                <button type="submit" class="delete-btn">Modifier</button>
              </form>';
                
                echo '</div>';
            }
        } catch (PDOException $e) {
            echo 'Échec : ' . $e->getMessage();
        }
        ?>

    </div>

</body>

</html>