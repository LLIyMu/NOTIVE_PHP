<?php
require_once('db.php');
require_once('function.php');

$id = $_SESSION['user_id'];
$name = htmlentities(trim($_POST['name']));
$email = htmlentities(trim($_POST['email']));
$image = $_FILES['image'];

$validate = 1; // переменная состояния валидации

function check_user($pdo, $email)
{           // функция проверки информации о пользователе из БД
    $sql_get = 'SELECT * FROM users WHERE email = :email'; //Формирую запрос к БД
    $stmt_get = $pdo->prepare($sql_get);      //Подготавливаю запрос (защита от sql-инъекций), выполняем его 
    $stmt_get->execute([':email' => $email]); //связываю переменные
    $result = $stmt_get->fetch();             // присваиваю данные из БД переменной, получаю их в ввиде ассоц массива
    return $result;                           // возвращаю результат
}

if (isset($name) && ($name != $_SESSION['name'])) {//Если имя в $_POST существует И  ИМЯ из $_POST не равно 
                                                   //ИМЕНИ из сессии

    $sql = 'UPDATE users SET name = :name WHERE id = :id';//подготавливаю запрос к БД и меняю имя
    $stmt = $pdo->prepare($sql);                          //подготавливаю запрос (защита от sql-инъекций)
    $stmt->execute([':name' => $name, ':id' => $id]);     //получаю новое имя 
}

if (!empty($email) && ($email != $_SESSION['email'])) {//если поле email не пустое И емайл НЕ равен эмайлу из сессии
    
    $result_email = check_user($pdo, $email);
    
}

if ($result_email['email'] == $email) {
    
    $_SESSION['emailErr'] = 'Такой email уже зарегестрирован';
    $validate = 0;
    dd($result_email['email']);
}
if (!preg_match('#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#', $email)) {
    
    $_SESSION['emailErr'] = 'Неправильный формат email';
    $validate = 0;
}
 
if($validate == 1) {
    $sql = 'UPDATE users SET email = :email WHERE id = :id'; //подготавливаю запрос к БД и меняю email
    $stmt = $pdo->prepare($sql);                             //подготавливаю запрос (защита от sql-инъекций)
    $stmt->execute([':email' => $email, ':id' => $id]);      //получаю новый email
}


header('location:/profile.php');
exit;

move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . uniqid() . '.jpg');