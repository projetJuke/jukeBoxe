<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter playlist</title>
</head>
<body>
    <h1> Ajouter une playlist </h1>
    <form action="../functions/add_playlist.php" method="POST">
        <label for="">Nom de la playlist</label>
        <input type="text" name="playlist_name" required> <br>
        <button type="submit"> Valider </button>
    </form>
</body>
</html>