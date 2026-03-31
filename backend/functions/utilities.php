<?php
/**
 * Retourne les tracks de la playlist selectionnee (playlists.is_selected = 1).
 *
 * Appel :
 * $tracks = getLesTracksByIdPlaylists($db);
 *
 * Champs retournes pour chaque track :
 * - track_id
 * - album
 * - length
 * - id_cover
 * - id_music
 * - track_code
 */
function getLesTracksByIdPlaylists(PDO $db): array
{
    $statement = $db->prepare('
        SELECT t.track_id, t.album, t.length, t.id_cover, t.id_music, b.track_code
        FROM tracks t
        INNER JOIN belong b ON b.track_id = t.track_id
        INNER JOIN playlists p ON p.playlist_id = b.playlist_id
        WHERE p.is_selected = :valeur
        ORDER BY b.track_code
    ');

    $statement->execute([':valeur' => 1]);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
