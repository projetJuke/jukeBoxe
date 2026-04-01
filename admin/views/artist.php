<?php
session_start();
require_once "../functions/utilities.php";
requireAdminSession("index.php");
require "../../connect.php";
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Artistes</title>
    <link rel="stylesheet" href="../css/artist.css">
</head>

<body>
    <main class="admin-page">
        <div class="admin-shell">
            <header class="page-header">
                <div>
                    <p class="page-kicker">Catalogue</p>
                    <h1 class="page-title">Artistes</h1>
                    <p class="page-subtitle">Recherchez rapidement un artiste et maintenez la bibliothèque propre.</p>
                </div>
                <div class="toolbar">
                    <a class="button-secondary" href="dashboard.php">Retour dashboard</a>
                    <a class="delete-btn" href="../functions/logout.php">Déconnecter</a>
                </div>
            </header>

            <section class="table-card">
                <div class="top-bar">
                    <form method="POST" class="search">
                        <label class="visually-hidden" for="artist-search">Recherche artiste</label>
                        <input type="text" id="artist-search" name="name" placeholder="Rechercher un artiste">
                        <button type="submit" class="button">Valider</button>
                    </form>

                    <a href="ajout_artist.php" class="add-btn">Ajouter un artiste</a>
                </div>

                <div class="table-container">
                    <div class="table-header table-header--artists">
                        <span>ID</span>
                        <span>Artiste</span>
                        <span>Action</span>
                    </div>

                    <?php
                    $hasRows = false;
                    try {
                        if (!empty($_POST["name"])) {
                            $baba = '%' . $_POST["name"] . '%';
                            $sql = 'SELECT * FROM artists WHERE name LIKE :recherche';
                            $statement = $pdo->prepare($sql);
                            $statement->bindParam(':recherche', $baba);
                        } else {
                            $sql = 'SELECT * FROM artists';
                            $statement = $pdo->prepare($sql);
                        }

                        $statement->execute();

                        while ($row = $statement->fetch()) {
                            $hasRows = true;
                            echo '<div class="row row--artists">';
                            echo '<span>' . htmlspecialchars($row['artist_id']) . '</span>';
                            echo '<span>' . htmlspecialchars($row['name']) . '</span>';
                            echo '<div class="cell-actions">';
                            echo '<form action="../functions/supprimer_artiste.php" method="POST">';
                            echo '<input type="hidden" name="artist_id" value="' . htmlspecialchars($row['artist_id']) . '">';
                            echo '<button type="submit" class="delete-btn">Supprimer</button>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                        }

                        if (!$hasRows) {
                            echo '<p class="empty-list">Aucun artiste trouvé.</p>';
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
