<?php
error_reporting(-1);
require_once('db.php');
require_once('function.php');

$email = htmlentities(trim($_POST['email'])); // получаю email
$password = htmlentities(trim($_POST['password'])); // получаю пароль
$remeber_me = htmlentities(trim($_POST['remember'])); // получаю данные о нажатом чек боксе

$validate = 1; // переменная состояния валидации

function check_user($pdo, $email) { // функция проверки информации о пользователе из БД
    $sql_get = 'SELECT * FROM users WHERE email = :email';
    $stmt_get = $pdo->prepare($sql_get);
    $stmt_get->execute([':email' => $email]);
    $result = $stmt_get->fetch(); // присваиваю данные из БД переменной
    return $result; // возвращаю результат
}

// Проверка email на допустимые символы
if (!preg_match('#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#', $email)) {

    $_SESSION['emailErr'] = 'Укажите правильный email';
    $validate = 0;
} 
// Проверка email на пустоту
if (empty($email)) {
    $_SESSION['emailErr'] = 'Введите email';
    $validate = 0;
}
// Проверка пароля на количество символов
if (strLen($password) < 6) {
    $_SESSION['passErr'] = 'Пароль меньше 6 символов';
    $validate = 0;
} 
// Проверка пароля на пустоту
if (empty($password)) {
    $_SESSION['passErr'] = 'Введите пароль';
    $validate = 0;
}
// Если валидация прошла успешно, присваю результат переменной который вернула функция,
// а так же результат проверки пароля
if ($validate == 1) { 
    $result_user = check_user($pdo, $email);
    $result_pass = password_verify($password, $result_user['password']);

    //Если пользователь существует и введен верный пароль - записываю пользователя в сессию
    if ($result_user && $result_pass) {
        $_SESSION['success'] = 'Вы успешно авторизованы';
        $_SESSION['email'] = $result_user['email'];
        $_SESSION['name'] = $result_user['name'];

        // Если нажат чек-бокс записываю данные в COOKIE
        if (isset($remeber_me)) {
            setcookie('email', $result_user['email'], time() + 3600);
            setcookie('name', $result_user['name'], time() + 3600);
        }
        header('location: /'); // Редирект на главную при условии успешной авторизации
        exit;
    } 
    $_SESSION['emailErr'] = 'Неверный email или пароль';
    
}
header('location:/login.php'); // редирект при ошибке ввода или введении неверных данных
exit;

  

   
        /* if (!$result ) {

            $_SESSION['emailErr'] = 'Укажите правильный email';
            $validate = 0;
        } */
     
        // проверяю ввод email на допустимые символы