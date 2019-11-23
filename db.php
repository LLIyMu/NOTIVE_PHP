<?php
require 'function.php';

$driver = 'mysql';
$host = 'localhost';
$db_name = 'blog';
$db_user = 'mysql';
$db_password = 'mysql';
$charset = 'utf8';

$dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";
$options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn, $db_user, $db_password, $options);

$sql = "SELECT * FROM `form` WHERE id =:id";

$statement = $pdo->prepare($sql);

$statement->execute(['id'=>1]);

$result = $statement->fetch();

dd($result);
?>