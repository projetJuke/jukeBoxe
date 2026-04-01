<?php
require "../connect.php";

if (!isset($_POST['track_id']) || empty($_POST['track_id'])) {
    die("Erreur : ID manquant");
}

try {
    $db = new PDO(DNS, LOGIN, PASSWORD, $options);

    $id = (int) $_POST['track_id'];

    // 🔥 récupérer les DEUX colonnes
    $sql = "SELECT id_music, id_cover FROM tracks WHERE track_id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id' => $id]);
    $track = $stmt->fetch();

    if ($track) {

        // supprimer mp3
        $audioPath = "../frontend/public/audio/" . $track['id_music'];
        if (!empty($track['id_music']) && file_exists($audioPath)) {
            unlink($audioPath);
        }

        //supprimer image
        $imagePath = "../frontend/public/images/" . $track['id_cover'];
        if (!empty($track['id_cover']) && file_exists($imagePath)) {
            unlink($imagePath);
        }

        // supprimer relations
        $sql = "DELETE FROM produce WHERE track_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);

        //supprimer track
        $sql = "DELETE FROM tracks WHERE track_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    header("Location: sons.php");
    exit();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
