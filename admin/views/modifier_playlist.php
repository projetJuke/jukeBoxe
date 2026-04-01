<?php 
session_start();
    include_once "../functions/get_playlist.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier playlist</title>
</head>
<body>
    <h1> Modifier la playlist : <?= $playlist['label'] ?? "" ?></h1>
    <form action="../functions/update_playlist.php" method="POST">
        <label for="">Nom de la playlist</label>
        <input type="text" name="playlist_name" value="<?= $playlist['label'] ?? "" ?>" required> <br>
        <input type="hidden" name="playlist_id" value="<?= $playlist['playlist_id'] ?? "" ?>">
        <button type="submit"> Valider </button>
    </form>
</body>
</html>