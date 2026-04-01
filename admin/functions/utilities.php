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
    if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
        if ($_SESSION['user']['is_logged'] !== true) {
            header("Location: index.php");
            exit();
        }
    }
}

function validateIdentificationCode($code)
{
    return preg_match("/^[ABCDEFGHI][1-9]$/", $code);
}
