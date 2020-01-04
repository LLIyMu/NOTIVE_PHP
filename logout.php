<?php session_start();



// Если есть КУКА авторизации убиваем её
//if (isset($_COOKIE['email'])) {
    setcookie('email', '', time() - 3600);
    setcookie('name', '', time() - 3600);
    setcookie('user_id', '', time() - 3600);
    setcookie('user_img', '', time() - 3600);
//}
//убиваем сессию
unset($_SESSION['email']);
unset($_SESSION['name']);
unset($_SESSION['user_id']);
unset($_SESSION['user_img']);

//редирект на главную
header('location: /');