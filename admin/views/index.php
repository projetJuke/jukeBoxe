 <?php
session_start();
include_once "../functions/utilities.php";
if (isset($_SESSION['user']) && !empty($_SESSION['user'])){
    if($_SESSION['user']['is_logged'] === true){
        header("Location: dashboard.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

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

    <body>
        <?php if (isset($_SESSION['popup'])): ?>
            <div class="popup"> 
                <p> <?= $_SESSION['popup'] ?></p>
            <?php unset($_SESSION['popup']); ?>
            </div>
        <?php endif; ?>
        <h1> Log in </h1>

        <form action="../functions/login.php" method="POST">
            <label for="username"> Username </label>
            <input type="text" placeholder="username" name="username" id="username" min="4" max="20" required>
            <label for="password"> Password</label>
            <input type="password" name="password" id="password" min="8" max="24" required>
            <button type="submit"> Valider </button>
        </form>
    </body>
</body>

</html>