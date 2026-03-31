<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        <label for="image"> Ajouter une image </label>
        <input type="file" name="image">
        <label for="music"> Ajouter le fichier musique </label>
        <input type="file" name="music" required>
        <label for="artist"> Nom de l'artist </label>
        <select name="artist">
            <?php foreach ($artists as $artist): ?>

            <?php endforeach; ?>
        </select>
    </form>
</body>

</html>