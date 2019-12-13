<?php
require_once('db.php');
require_once('function.php');

$id = $_SESSION['user_id'];
$name = htmlentities(trim($_POST['name']));
$email = htmlentities(trim($_POST['email']));
$image = $_FILES['image'];

$validate = 1; // переменная состояния валидации

if (isset($name) && ($name != $_SESSION['name'])) {//Если имя в $_POST существует И  ИМЯ из $_POST не равно 
                                                   //ИМЕНИ из сессии

    $sql = 'UPDATE users SET name = :name WHERE id = :id';//подготавливаю запрос к БД и меняю имя
    $stmt = $pdo->prepare($sql);                          //подготавливаю запрос (защита от sql-инъекций)
    $stmt->execute([':name' => $name, ':id' => $id]);     //получаю новое имя 
}

if (!empty($email) && ($email != $_SESSION['email'])) {//если поле email не пустое И емайл НЕ равен эмайлу из сессии
    
    $sql = 'SELECT email FROM `users` WHERE email = :email'; //подготавливаю запрос в БД ищу email
    $stmt_check = $pdo->prepare($sql);
    $stmt_check->execute([':email' => $email]);
} 
if (!preg_match('#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#', $email)) {
    
    $_SESSION['emailErr'] = 'Неправильный формат email';
    $validate = 0;
}
if ($stmt_check->fetch()) {
    $_SESSION['emailErr'] = 'Такой email уже зарегестрирован';
    $validate = 0;
} 
if($validate == 1) {
    $sql = 'UPDATE users SET email = :email WHERE id = :id'; //подготавливаю запрос к БД и меняю email
    $stmt = $pdo->prepare($sql);                             //подготавливаю запрос (защита от sql-инъекций)
    $stmt->execute([':email' => $email, ':id' => $id]);      //получаю новый email
}

dd($image);
move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . uniqid() . '.jpg');