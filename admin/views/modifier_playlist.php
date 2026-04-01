<?php 
session_start();
    include_once ""
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier playlist</title>
</head>
<body>
<body>
    <h1> Modifier la playlist : <?= $playlist_name ?></h1>
    <form action="../functions/modify_playlist.php" method="POST">
        <label for="">Nom de la playlist</label>
        <input type="text" name="playlist_name" required> <br>
        <input type="hidden" name="playlist_id" value="<?= $playlist_id ?>">
        <button type="submit"> Valider </button>
    </form>
</body>
</body>
</html>