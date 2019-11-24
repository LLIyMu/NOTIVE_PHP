<?php

require ('db.php');

if (isset($_POST['name'])) {

    $date = date("Y,m,d"); //Получаем текущую дату (Год, месяц, день)
    $text = htmlentities(trim($_POST['text'])); //Получаем текст из комментария, избавляемся от пробелов с его концоы, предотвращаем возможность скриптовой атаки
    $name = htmlentities(trim($_POST['name'])); //Получаю имя пользователя.

    $sql = 'INSERT INTO `form` (id, name, text, date) VALUES (:id, :name, :text, :date)';
    $values = ['id' => $id, 'name' => $name, 'text' => $text, 'date' => $date];
    $statement = $pdo->prepare($sql);
    $statement->execute($values);

   
}