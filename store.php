<?php

require ('db.php');

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $name = $_POST['text'];

    $sql = 'INSERT INTO form (`id`, `name`, `text`, `date`) VALUES (:id, :user, :text, :date)';
    $values = [':id' => $id, ':name' => $name, ':text' => $text, ':date' => $date];
    $statement = $pdo->prepare($sql);
    $statement->execute($values);

}