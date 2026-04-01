<?php
try {
    require "connect.php";
    $db = new PDO(DNS, LOGIN, PASSWORD, $options);

    if (!empty($_POST["label"])) {
        $baba = '%' . $_POST["label"] . '%';
        $sql = 'SELECT * FROM playlists WHERE name LIKE :recherche';
        $statement = $db->prepare($sql);
        $statement->bindParam(':recherche', $baba);
    } else {
        $sql = 'SELECT * FROM playlists';
        $statement = $db->prepare($sql);
    }

    $statement->execute();

    echo '<table>';
    echo "<tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
         </tr>";

    while ($row = $statement->fetch()) {
        echo '<tr>';
        echo '<td>' . $row['playlist_id'] . '</td>';
        echo '<td>
                <a href="playlist_songs.php?id=' . $row['playlist_id'] . '">
                    ' . htmlspecialchars($row['label']) . '
                </a>
              </td>';
        echo '</tr>';
    }

    echo '</table>';

    $db = null;
} catch (PDOException $e) {
    echo 'Échec : ' . $e->getMessage();
}
