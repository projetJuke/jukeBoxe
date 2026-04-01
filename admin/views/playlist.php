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
    <title>Playlists</title>
    <link rel="stylesheet" href="../css/artist.css">
</head>

<body>
    <main class="admin-page">
        <div class="admin-shell">
            <header class="page-header">
                <div>
                    <p class="page-kicker">Programmation</p>
                    <h1 class="page-title">Playlists</h1>
                    <p class="page-subtitle">Créez les playlists puis ouvrez leur grille pour placer les morceaux par code.</p>
                </div>
                <div class="toolbar">
                    <a class="button-secondary" href="dashboard.php">Retour dashboard</a>
                    <a class="delete-btn" href="../functions/logout.php">Déconnecter</a>
                </div>
            </header>

            <section class="table-card">
                <div class="top-bar">
                    <form method="POST" class="search">
                        <label class="visually-hidden" for="playlist-search">Recherche playlist</label>
                        <input type="text" id="playlist-search" name="label" placeholder="Rechercher une playlist">
                        <button type="submit" class="button">Valider</button>
                    </form>

                    <a href="ajouter_playlist.php" class="add-btn">Ajouter une playlist</a>
                </div>

                <div class="table-container">
                    <div class="table-header table-header--playlists">
                        <span>ID</span>
                        <span>Nom</span>
                        <span>Sélection</span>
                        <span>Ouvrir</span>
                        <span>Supprimer</span>
                    </div>

                    <?php
                    $hasRows = false;
                    try {
                        if (!empty($_POST["label"])) {
                            $baba = '%' . $_POST["label"] . '%';
                            $sql = 'SELECT * FROM playlists WHERE label LIKE :recherche';
                            $statement = $pdo->prepare($sql);
                            $statement->bindParam(':recherche', $baba);
                        } else {
                            $sql = 'SELECT * FROM playlists ORDER BY is_selected DESC, label ASC';
                            $statement = $pdo->prepare($sql);
                        }

                        $statement->execute();

                        while ($row = $statement->fetch()) {
                            $hasRows = true;
                            $isSelected = isset($row['is_selected']) && (int) $row['is_selected'] === 1;
                            echo '<div class="row row--playlists' . ($isSelected ? ' row--selected' : '') . '">';
                            echo '<span>' . htmlspecialchars($row['playlist_id']) . '</span>';
                            echo '<span class="playlist-label">';
                            echo '<span>' . htmlspecialchars($row['label']) . '</span>';
                            if ($isSelected) {
                                echo '<span class="status-badge">Playlist sélectionnée</span>';
                            }
                            echo '</span>';
                            echo '<form action="../functions/select_playlist.php" method="POST">';
                            echo '<input type="hidden" name="playlist_id" value="' . htmlspecialchars($row['playlist_id']) . '">';
                            echo '<button type="submit" class="' . ($isSelected ? 'btn-primary' : 'button-secondary') . '">' . ($isSelected ? 'Sélectionnée' : 'Sélectionner') . '</button>';
                            echo '</form>';
                            echo '<a class="button-secondary" href="gestion_playlist.php?playlist_id=' . urlencode((string) $row['playlist_id']) . '">Ouvrir</a>';
                            echo '<form action="../functions/supprimer_playliste.php" method="POST">';
                            echo '<input type="hidden" name="playlist_id" value="' . htmlspecialchars($row['playlist_id']) . '">';
                            echo '<button type="submit" class="delete-btn">Supprimer</button>';
                            echo '</form>';
                            echo '</div>';
                        }

                        if (!$hasRows) {
                            echo '<p class="empty-list">Aucune playlist trouvée.</p>';
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
