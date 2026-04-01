<?php
require "../connect.php";
$db = new PDO(DNS, LOGIN, PASSWORD, $options);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Artist</title>
    <link rel="stylesheet" href="artist.css">
</head>

<body>

    <h1>Artist</h1>

    <div class="top-bar">
        <form method="POST" class="search">
            <input type="text" name="name" placeholder="recherche">
            <button type="submit">valider</button>
        </form>

        <a href="ajout_artist.php">
            <button class="add-btn">Ajouter</button>
        </a>
    </div>

    <div class="table-container">
        <div class="table-header">
            <span>id</span>
            <span>ARTIST</span>
            <span></span>
        </div>

        <?php
        try {

            if (!empty($_POST["name"])) {
                $baba = '%' . $_POST["name"] . '%';
                $sql = 'SELECT * FROM artists WHERE name LIKE :recherche';
                $statement = $db->prepare($sql);
                $statement->bindParam(':recherche', $baba);
            } else {
                $sql = 'SELECT * FROM artists';
                $statement = $db->prepare($sql);
            }

            $statement->execute();

            while ($row = $statement->fetch()) {
                echo '<div class="row">';
                echo '<span>' . htmlspecialchars($row['artist_id']) . '</span>';
                echo '<span>' . htmlspecialchars($row['name']) . '</span>';

                echo '<form action="supprimer_artiste.php" method="POST">
                <input type="hidden" name="artist_id" value="' . $row['artist_id'] . '">
                <button type="submit" class="delete-btn">Supprimer</button>
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