<?php
$parameters = array_slice($argv, 1);

$connection = new PDO("mysql:host={$parameters[2]}", $parameters[0], $parameters[1], [
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$sql = <<<DATABASE
CREATE DATABASE IF NOT EXISTS {$parameters[3]}
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
DATABASE;
$connection->exec($sql);

$connection->exec("GRANT ALL PRIVILEGES on {$parameters[3]}.* TO {$parameters[4]}@{$parameters[2]} IDENTIFIED BY '{$parameters[5]}'");

echo "Database {$parameters[3]} with user {$parameters[4]} created";
