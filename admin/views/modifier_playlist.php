<?php
session_start();
include_once "../functions/get_playlist_data.php";
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification playlist</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <h1 class="title"> <?= $playlist_name ?? "" ?> </h1>
    <div class="inline_section">
        <section class="left">
            <div class="identifier_list">
                <?php foreach ($identifier_list as $identifier): ?>
                    <?php if (isset($playlist[$identifier])): ?>
                        <div class="green_box" onclick="showInfoGreen('<?= $identifier ?>')">
                            <?= $identifier ?>
                        </div>
                    <?php else: ?>
                        <div class="red_box" onclick="showInfoRed('<?= $identifier ?>')">
                            <?= $identifier ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="right" id="info_panel">

        </section>
    </div class="inline_section">
</body>
<script>
    const allData = <?= json_encode($playlist) ?>;
    const listeMorceaux = <?= json_encode($morceaux) ?>;
    const playlist_id = <?= json_encode($playlist_id) ?>;
    console.log(listeMorceaux);

    function showInfoGreen(identifier) {
        const data = allData[identifier];
        document.getElementById('info_panel').innerHTML = `
            <h2>${data.album}</h2>
            <p> Duree : ${data.length} secondes</p>
            <p> Artist : ${data.name} </p>
            <p> Code : ${data.track_code} </p>
            <form action="../functions/remove_track.php" method="POST">
                <input type="hidden" name="playlist_id" value="${data.playlist_id}">
                <button type="submit" name="track_code" value="${data.track_code}"> Supprimer de la playlist </button> 
            </form>
        `;
    }

    function showInfoRed(identifier) {
        document.getElementById('info_panel').innerHTML = `
        <p>Emplacement vide - ajoutez un morceau</p>
        <form action="../functions/add_track.php" method="POST">
            <label for="recherche">Recherche :</label>
            <input type="text" id="recherche_${identifier}" onkeyup="filterMorceaux(this, '${identifier}')" placeholder="Tapez pour filtrer..."> <br>
            <input type="hidden" name="identifier" value="${identifier}">
            <label for="id_morceau">Liste des morceaux :</label> <br>
            <select name="id_morceau" id="id_morceau_${identifier}"> 
            </select> <br>
            <input type="hidden" name="playlist_id" value="${playlist_id}">
            <button type="submit">Ajouter à la playlist</button> <br>
            <a href="ajouter_morceau.php"><button type="button"> Ajouter un morceau </button></a>
        </form>
    `;
        filterMorceaux(document.getElementById(`recherche_${identifier}`), identifier, '');
    }

    function filterMorceaux(input, identifier, forceTerm = null) {
        const searchTerm = forceTerm !== null ? forceTerm.toLowerCase() : input.value.toLowerCase();
        const select = document.getElementById(`id_morceau_${identifier}`);
        let options = '';

        for (const morceau of listeMorceaux) {
            const album = morceau.album.toLowerCase();
            const name = morceau.name.toLowerCase();
            if (album.includes(searchTerm) || name.includes(searchTerm)) {
                options += `<option value="${morceau.track_id}">${morceau.album} - ${morceau.name}</option>`;
            }
        }

        select.innerHTML = options;
        if (options === '') {
            select.innerHTML = '<option value="" disabled>Aucun résultat trouvé</option>';
        }
    }
</script>

</html>