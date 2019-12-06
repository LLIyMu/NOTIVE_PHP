<?php
error_reporting(-1);
require_once('db.php');

$email = htmlentities(trim($_POST['email']));
$password = htmlentities(trim($_POST['password']));

if (!empty($email) && !empty($password)) {
    
    $sql_get = 'SELECT `id`, `name`, `email` FROM users WHERE email = :email';
    $stmt_get = $pdo->prepare($sql_get);
    $stmt_get->execute([':email' => $email]);
    $email_log = $stmt_get->fetchAll();
    
    if ($email_log) {
        
       if (strLen($password) < 6) {
           $_SESSION['passErr'] = 'пароль меньше 6 символов';
           header('location:/login.php');
           exit;
            var_dump($_SESSION);
       } elseif (password_verify($password, $email_log->password)) {
           # code...
       }
    }

}
