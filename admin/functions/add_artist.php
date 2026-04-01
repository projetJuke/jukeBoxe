<?php 
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require "../../connect.php";
        if (!empty($_POST['nom'])) {

            $sql = "INSERT INTO artists (name)
                    VALUES (:name)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $_POST['nom'],
            ]);

            $_SESSION['popup'] = "L'artiste a été ajouté avec succès !";
            header("Location: ../views/artist.php");
            exit();
        } else {
            $_SESSION['error'] = "Veuillez remplir tous les champs obligatoires.";
            header("Location: ../views/artist.php");
            exit();
        }
    } catch (PDOException $e) {
        $message = "Erreur : " . $e->getMessage();
        $_SESSION['error'] = "Erreur de connexion à la base de données";
        header("Location: ../views/index.php");
        exit();
    }
}