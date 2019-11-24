<?php

require('db.php');

if (isset($_POST['user'])) {

    $date = date("Y-m-d"); //Получаем текущую дату (Год, месяц, день)
    $text = htmlentities(trim($_POST['text'])); //Получаем текст из комментария, избавляемся от пробелов с его концоы, предотвращаем возможность скриптовой атаки
    $user = htmlentities(trim($_POST['user'])); //Получаю имя пользователя.
    
    $sql = 'INSERT INTO `form` (`user`, `text`, `date`) VALUES (:user, :text, :date)';
    $values = ['user' => $user, 'text' => $text, 'date' => $date];
    $statement = $pdo->prepare($sql);
    $statement->execute($values);
}
header("Location: /");
exit;