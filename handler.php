<?php
require_once('db.php');


if (!empty($_POST['user'])&&!empty($_POST['text'])) {

    $date = date("Y-m-d"); //Получаем текущую дату (Год, месяц, день)
    $text = htmlentities(trim($_POST['text'])); //Получаем текст из комментария, избавляемся от пробелов с его концов, предотвращаем возможность скриптовой атаки
    $user = htmlentities(trim($_POST['user'])); //Получаю имя пользователя.
    //Вставляем введенныую пользователем информацию в БД.
    $sql = 'INSERT INTO `form` (`user`, `text`, `date`) VALUES (:user, :text, :date)';
    $values = ['user' => $user, 'text' => $text, 'date' => $date];
    $statement = $pdo->prepare($sql);
    $statement->execute($values);
    //Добавление алерта, для комментария
    $_SESSION['alert'] = 'Комментарий успешно добавлен';
} else{
    $_SESSION['text'] = 'Введите ваше сообщение';
    $_SESSION['user'] = 'Введите ваше имя';
}
header("Location: /");//Перенаправление на index.php
exit;