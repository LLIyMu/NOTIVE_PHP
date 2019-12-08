<?php session_start();



// Если есть КУКА авторизации убиваем её
if (isset($_COOKIE['user_aut'])) {
    setcookie('user_aut', '', time() - 3600);
}
//убиваем сессию
unset($_SESSION['user_info']);

//редирект на главную
header('location: /');