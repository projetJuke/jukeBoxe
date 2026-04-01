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
    <header>
        <?php if (isset($_SESSION['popup'])): ?>
            <div class="popup">
                <p> <?= $_SESSION['popup']; ?> </p>
                <?php unset($_SESSION['popup']) ?>
            </div>
        <?php endif; ?>
        <?php if(isset ($_SESSION['error'])): ?>
            <div class="error">
                <p> <?= $_SESSION['error'] ?> </p>
                <?php unset($_SESSION['error']) ?>
            </div>
        <?php endif; ?>
    </header>

    <div class="header-container">
        <h1 class="title"> Playlist: <?= $playlist_name ?? "" ?> </h1>
    </div>

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
            <div class="empty-state">
                <p>Sélectionnez un emplacement pour voir les détails ou ajouter un morceau.</p>
            </div>
        </section>
    </div>
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
            <div class="track-details">
                <p><strong>Artiste :</strong> ${data.name}</p>
                <p><strong>Durée :</strong> ${data.length} secondes</p>
                <p><strong>Code :</strong> ${data.track_code}</p>
            </div>
            <form action="../functions/remove_track.php" method="POST" class="action-form">
                <input type="hidden" name="playlist_id" value="${data.playlist_id}">
                <button type="submit" name="track_code" value="${data.track_code}" class="btn-danger"> Supprimer de la playlist </button> 
            </form>
        `;
    }

    function showInfoRed(identifier) {
        document.getElementById('info_panel').innerHTML = `
        <h2>Emplacement ${identifier} vide</h2>
        <p class="subtitle">Ajoutez un morceau à cet emplacement</p>
        <form action="../functions/add_track.php" method="POST" class="action-form">
            <div class="form-group">
                <label for="recherche_${identifier}">Recherche :</label>
                <input type="text" id="recherche_${identifier}" onkeyup="filterMorceaux(this, '${identifier}')" placeholder="Tapez pour filtrer..."> 
            </div>
            
            <input type="hidden" name="identifier" value="${identifier}">
            
            <div class="form-group">
                <label for="id_morceau_${identifier}">Liste des morceaux :</label> 
                <select name="id_morceau" id="id_morceau_${identifier}"> 
                </select> 
            </div>
            
            <input type="hidden" name="playlist_id" value="${playlist_id}">
            
            <div class="button-group">
                <button type="submit" class="btn-primary">Ajouter à la playlist</button> 
                <a href="ajouter_morceau.php" class="btn-secondary"> Créer un nouveau morceau </a>
            </div>
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