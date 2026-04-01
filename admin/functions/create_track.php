<?php
session_start();
require_once "utilities.php";
requireAdminSession("../views/index.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require "../../connect.php";

        if (!empty($_POST['album']) && !empty($_POST['length'])) {

            /* ====== IMAGE ====== */
            $coverName = $_FILES['cover']['name'];
            $coverTmp = $_FILES['cover']['tmp_name'];
            $coverPath = "../../frontend/public/images/" . $coverName;

            $musicName = $_FILES['music']['name'];
            $musicTmp = $_FILES['music']['tmp_name'];
            $musicPath = "../../frontend/public/audio/" . $musicName;

            if (!move_uploaded_file($coverTmp, $coverPath) || !move_uploaded_file($musicTmp, $musicPath)) {
                $_SESSION['error'] = "Erreur upload image ou son<br>";
                header("Location: ../views/ajout_track.php");
                exit();
            }

            /* ====== INSERT ====== */
            $sql = "INSERT INTO tracks (album, length, id_cover, id_music)
                    VALUES (:album, :length, :id_cover, :id_music)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':album' => $_POST['album'],
                ':length' => $_POST['length'],
                ':id_cover' => $coverName,
                ':id_music' => $musicName
            ]);

            $_SESSION['popup'] = "Musique + image ajoutées avec succès !";
            header("Location: ../views/sons.php");
            exit();
        } else {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            header("Location: ../views/ajout_track.php");
            exit();
        }
    } catch (PDOException $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}
