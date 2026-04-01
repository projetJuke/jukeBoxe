<?php
session_start();

require "connect.php";
$db = new PDO(DNS, LOGIN, PASSWORD, $options);

if (!isset($_GET['id'])) {
    die("Artiste introuvable");
}

$id = $_GET['id'];

$sql = "SELECT * FROM artists WHERE artist_id = :id";
$stmt = $db->prepare($sql);
$stmt->execute(['id' => $id]);
$artist = $stmt->fetch();

if (!$artist) {
    die("Artiste non trouvé");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier artiste</title>
</head>

<body>

    <div class="wrapper">

        <form action="update_artist.php" method="post">
            <h2>Modifier artiste</h2>

            <input type="hidden" name="artist_id" value="<?= htmlspecialchars($artist['artist_id']) ?>">

            <div class="box">
                <label>Nom</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($artist['name']) ?>">
            </div>

            <button type="submit">Modifier</button>
        </form>

        <form action="supprimer.php" method="post">
            <input type="hidden" name="artist_id" value="<?= htmlspecialchars($artist['artist_id']) ?>">
            <button type="submit">Supprimer définitivement</button>
        </form>

        <a href="artist.php">
            <button type="button">Retour</button>
        </a>

    </div>

</body>

</html>