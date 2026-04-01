 <?php
    session_start();
    include_once "../functions/utilities.php";
    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
        if ($_SESSION['user']['is_logged'] === true) {
            header("Location: dashboard.php");
            exit();
        }
    }
    ?>
 <!DOCTYPE html>
 <html lang="fr">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../css/style.css">
     <title>Log in</title>
 </head>

 <body>
     <header>
         <!--  Bar de navigation -->
     </header>
     <?php if (isset($_SESSION['popup'])): ?>
         <div class="popup">
             <p> <?= $_SESSION['popup'] ?></p>
             <?php unset($_SESSION['popup']); ?>
         </div>
     <?php endif; ?>
     <section>
         <div class="leaves">
             <div class="set">
                 <div><img src="../images/leaf_01.png"></div>
                 <div><img src="../images/leaf_02.png"></div>
                 <div><img src="../images/leaf_03.png"></div>
                 <div><img src="../images/leaf_04.png"></div>
                 <div><img src="../images/leaf_01.png"></div>
                 <div><img src="../images/leaf_02.png"></div>
                 <div><img src="../images/leaf_03.png"></div>
                 <div><img src="../images/leaf_04.png"></div>
             </div>
         </div>
         <img src="../images/bg.jpg" class="bg">
         <img src="../images/girl.png" class="girl">
         <img src="../images/trees.png" class="trees">
         <form action="../functions/login.php" method="POST" class="login">
             <h2> Connexion</h2>
             <label for="username"> Utilisateur </label>
             <div class="inputBox">

                 <input type="text" name="username" id="username" min="4" max="20" required>
             </div>
             <label for="password"> Mot de passe</label>
             <div class="inputBox">
                 <input type="password" name="password" id="password" min="8" max="24" required>
             </div>
             <div class="inputBox">
                 <input type="submit" value="valider">
             </div>
         </form>
     </section>
 </body>

 </html>