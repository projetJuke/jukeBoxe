<?php

function validateUsername($username, $min, $max)
{
    return preg_match('/^[\w\d!#$%^&\-@\_]{' . $min . ',' . $max . '}$/', $username);
}

function validatePassword($password, $min, $max)
{
    return preg_match('/^[\w\d!#%^\-*]{' . $min . ',' . $max . '}$/', $password);
}

function validateInteger($integer)
{
    return is_numeric($integer);
}

function verifySessionStatus()
{
    if (
        !isset($_SESSION['user']) ||
        empty($_SESSION['user']) ||
        !isset($_SESSION['user']['is_logged']) ||
        $_SESSION['user']['is_logged'] !== true
    ) {
        header("Location: ../views/index.php");
        exit();
    }
}

function requireAdminSession($redirectPath = 'index.php')
{
    $isLogged = isset($_SESSION['user']['is_logged']) && $_SESSION['user']['is_logged'] === true;
    $isAdmin = isset($_SESSION['user']['is_admin']) && $_SESSION['user']['is_admin'] === true;

    if ($isLogged && $isAdmin) {
        return;
    }

    $_SESSION['popup'] = "Vous devez être connecté et administrateur pour accéder à l'admin.";
    header("Location: " . $redirectPath);
    exit();
}

function validateIdentificationCode($code)
{
    return preg_match("/^[ABCDEFGHI][1-9]$/", $code);
}
