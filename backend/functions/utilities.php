<?php
/**
 * Retourne les tracks de la playlist selectionnee (playlists.is_selected = 1).
 *
 * Appel :
 * $tracks = getRandomTracksBySelectedPlaylist($db, 6);
 *
 * Champs retournes pour chaque track :
 * - track_id
 * - album
 * - length
 * - id_cover
 * - id_music
 * - track_code
 * - name
 */
function getRandomTracksBySelectedPlaylist(PDO $db, int $limit = 6): array
{
    if ($limit < 1) {
        return [];
    }

    $statement = $db->prepare('
        SELECT
            t.track_id,
            t.album,
            t.length,
            t.id_cover,
            t.id_music,
            b.track_code,
            GROUP_CONCAT(DISTINCT a.name ORDER BY a.name SEPARATOR " & ") AS name
        FROM tracks t
        INNER JOIN belong b ON b.track_id = t.track_id
        INNER JOIN playlists p ON p.playlist_id = b.playlist_id
        INNER JOIN produce pro ON pro.track_id = t.track_id
        INNER JOIN artists a ON a.artist_id = pro.artist_id
        WHERE p.is_selected = :valeur
        GROUP BY t.track_id, t.album, t.length, t.id_cover, t.id_music, b.track_code
        ORDER BY RAND()
        LIMIT :limit
    ');

    $statement->bindValue(':valeur', 1, PDO::PARAM_INT);
    $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTracksBySelectedPlaylist(PDO $db): array
{
    $statement = $db->prepare('
        SELECT
            t.track_id,
            t.album,
            t.length,
            t.id_cover,
            t.id_music,
            b.track_code,
            GROUP_CONCAT(DISTINCT a.name ORDER BY a.name SEPARATOR " & ") AS name
        FROM tracks t
        INNER JOIN belong b ON b.track_id = t.track_id
        INNER JOIN playlists p ON p.playlist_id = b.playlist_id
        INNER JOIN produce pro ON pro.track_id = t.track_id
        INNER JOIN artists a ON a.artist_id = pro.artist_id
        WHERE p.is_selected = :valeur
        GROUP BY t.track_id, t.album, t.length, t.id_cover, t.id_music, b.track_code
        ORDER BY b.track_code
    ');

    $statement->bindValue(':valeur', 1, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getTrackByCodeFromSelectedPlaylist(PDO $db, string $trackCode): ?array
{
    $statement = $db->prepare('
        SELECT
            t.track_id,
            t.album,
            t.length,
            t.id_cover,
            t.id_music,
            b.track_code,
            GROUP_CONCAT(DISTINCT a.name ORDER BY a.name SEPARATOR " & ") AS name
        FROM tracks t
        INNER JOIN belong b ON b.track_id = t.track_id
        INNER JOIN playlists p ON p.playlist_id = b.playlist_id
        INNER JOIN produce pro ON pro.track_id = t.track_id
        INNER JOIN artists a ON a.artist_id = pro.artist_id
        WHERE p.is_selected = :valeur AND b.track_code = :track_code
        GROUP BY t.track_id, t.album, t.length, t.id_cover, t.id_music, b.track_code
    ');

    $statement->bindValue(':valeur', 1, PDO::PARAM_INT);
    $statement->bindValue(':track_code', $trackCode, PDO::PARAM_STR);
    $statement->execute();

    $track = $statement->fetch(PDO::FETCH_ASSOC);

    return $track ?: null;
}
