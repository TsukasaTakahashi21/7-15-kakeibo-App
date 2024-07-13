<?php
function getPdo(): PDO
{
  $dbUserName = 'root';
    $dbPassword = 'password';

    return new PDO(
        'mysql:host=mysql; dbname=kakeibo; charset=utf8',
        $dbUserName,
        $dbPassword
    );
}