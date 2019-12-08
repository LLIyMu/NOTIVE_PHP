<?php
error_reporting(-1);
require_once('db.php');

$email = htmlentities(trim($_POST['email']));
$password = htmlentities(trim($_POST['password']));

if (!empty($email) && !empty($password)) {
    
    $sql_get = 'SELECT * FROM users WHERE email = :email';
    $stmt_get = $pdo->prepare($sql_get);
    $stmt_get->execute([':email' => $email]);
    $email_log = $stmt_get->fetch();
    
        //Если переменная $email_log существует
    if ($email_log) {
            // проверяю ввод email на допустимые символы
        if(!preg_match('#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#', $email)) {

        $_SESSION['emailErr'] = 'Укажите правильный email';
        //header('location:/login.php');
        exit;
        }
        //проверяю пароль на количество символов
       elseif(strLen($password) < 6) {
           $_SESSION['passErr'] = 'пароль меньше 6 символов';
           //header('location:/login.php');
           exit;
           // var_dump($_SESSION);
       } elseif (password_verify($password, $email_log['password'])) {
            //если эмейл и парроль совпадает, подключаем пользователя в сессию.
            if (empty($email)) { 
                if (isset($_COOKIE['user_aut'])) { //если есть кука - извлекаю данные из email
                    $email = $_COOKIE['user_aut'];
                }
                if (isset($_SESSION['user_info'])) { //если есть сессия - извлекаем из неё данные email
                    $email = $_SESSION['user_info']->$email;
                    if(isset($_POST['remember'])){
                        setcookie('user_aut', $email_log->email, time() + 3600);
                    }
                } else{
                    echo 'Ошибка закгрузки данных';
                }
                header('location:/login.php');
                exit;
            }
            //делаю запрос, и получаю из БД инф. об авторизованном пользователе в виде объекта и присваиваю её к сессии.
            $sql_get = 'SELECT * FROM users WHERE email = :email';
            $stmt_get = $pdo->prepare($sql_get);
            $stmt_get->execute([':email' => $email]);
            $_SESSION['user_info'] = $stmt_get->fetch();

            header('location:/'); //редирект на главную
            exit;
        } else{
            $_SESSION['passErr'] = 'неверно введен пароль';
            header('location: /login.php');
        }
        
      
    } else{
        $_SESSION['emailErr'] = 'неверно введен email';
        header('location: /login.php');
    }      

} else{
    //если все поля пустые - запись ошибки в сессию и редирект
    $_SESSION['emailErr'] = 'заполните пустые поля';
    header('location:/login.php');
}