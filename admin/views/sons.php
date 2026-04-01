<?php
session_start();
require_once "../functions/utilities.php";
requireAdminSession("index.php");
require "../../connect.php";
$pdo = new PDO(DNS, LOGIN, PASSWORD, $options);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Musiques</title>
    <link rel="stylesheet" href="../css/artist.css">
</head>

<body>
    <main class="admin-page">
        <div class="admin-shell">
            <header class="page-header">
                <div>
                    <p class="page-kicker">Bibliothèque</p>
                    <h1 class="page-title">Musiques</h1>
                    <p class="page-subtitle">Parcourez les morceaux, vérifiez leurs fichiers associés et supprimez-les proprement si besoin.</p>
                </div>
                <div class="toolbar">
                    <a class="button-secondary" href="dashboard.php">Retour dashboard</a>
                    <a class="delete-btn" href="../functions/logout.php">Déconnecter</a>
                </div>
            </header>

            <section class="table-card">
                <div class="top-bar">
                    <form method="POST" class="search">
                        <label class="visually-hidden" for="track-search">Recherche musique</label>
                        <input type="text" id="track-search" name="name" placeholder="Rechercher un album">
                        <button type="submit" class="button">Valider</button>
                    </form>

                    <a href="ajout_track.php" class="add-btn">Ajouter une musique</a>
                </div>

                <div class="table-container">
                    <div class="table-header table-header--tracks">
                        <span>ID</span>
                        <span>Musique</span>
                        <span>Durée</span>
                        <span>Cover</span>
                        <span>Mémoire</span>
                        <span>Action</span>
                    </div>

                    <?php
                    $hasRows = false;
                    try {
                        if (!empty($_POST["name"])) {
                            $baba = '%' . $_POST["name"] . '%';
                            $sql = 'SELECT * FROM tracks WHERE album LIKE :recherche';
                            $statement = $pdo->prepare($sql);
                            $statement->bindParam(':recherche', $baba);
                        } else {
                            $sql = 'SELECT * FROM tracks';
                            $statement = $pdo->prepare($sql);
                        }

                        $statement->execute();

                        while ($row = $statement->fetch()) {
                            $hasRows = true;
                            echo '<div class="row row--tracks">';
                            echo '<span>' . htmlspecialchars($row['track_id']) . '</span>';
                            echo '<span>' . htmlspecialchars($row['album']) . '</span>';
                            echo '<span>' . htmlspecialchars($row['length']) . '</span>';
                            echo '<span>' . htmlspecialchars($row['id_cover']) . '</span>';
                            echo '<span>' . htmlspecialchars($row['id_music']) . '</span>';
                            echo '<div class="cell-actions">';
                            echo '<form action="sons_sup.php" method="POST">';
                            echo '<input type="hidden" name="track_id" value="' . htmlspecialchars($row['track_id']) . '">';
                            echo '<button type="submit" class="delete-btn">Supprimer</button>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                        }

                        if (!$hasRows) {
                            echo '<p class="empty-list">Aucun morceau trouvé.</p>';
                        }
                    } catch (PDOException $e) {
                        echo '<p class="empty-list">Échec : ' . htmlspecialchars($e->getMessage()) . '</p>';
                    }
                    ?>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
