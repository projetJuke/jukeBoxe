<?php
    define('DNS', 'mysql:host=127.0.0.1;port=3306;dbname=exemple');
    define('LOGIN', 'username');
    define ('PASSWORD', 'password');
    $options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                     PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
                     PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8");

    $pdo = new PDO(DNS, LOGIN, PASSWORD, $options);

?>