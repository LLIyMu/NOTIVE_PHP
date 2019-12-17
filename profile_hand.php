<?php
require_once('db.php');
require_once('function.php');


$data =[]; // подготавливаю переменную для динамического запроса к БД с пустым массивом
$id = $_SESSION['user_id']; // записываю id пользователя из сессии в переменную
$name = htmlentities(trim($_POST['name'])); // получаю имя из формы и защищаю от возможных hack атак
$email = htmlentities(trim($_POST['email'])); // получаю email из формы и защищаю от возможных hack атак
$image = $_FILES['image']; // записываю в переменную данные о полученной картинке

$validate = 1; // переменная состояния валидации

function check_user($pdo, $email)           // функция проверки информации о пользователе из БД
{          
    $sql_get = 'SELECT * FROM users WHERE email = :email'; //Формирую запрос к БД
    $stmt_get = $pdo->prepare($sql_get);      //Подготавливаю запрос (защита от sql-инъекций), выполняем его 
    $stmt_get->execute([':email' => $email]); //связываю переменные
    $result = $stmt_get->fetch();             // присваиваю данные из БД переменной, получаю их в ввиде ассоц массива
    return $result;                           // возвращаю результат
}

if (empty($name) || isset($_SESSION['name'])) { //если поле пустое ИЛИ есть сессия с именем пользователя
    
    $data['name'] = $_SESSION['name']; // записываю в переменную имя из сессии
}
if (empty($email) || isset($_SESSION['email'])) { //если поле пустое ИЛИ есть сессия с email пользователя
    
    $data['email'] = $_SESSION['email']; // записываю в переменную email из сессии
}
if (isset($name) && ($name != $_SESSION['name'])) {//Если имя в $_POST существует И  ИМЯ из $_POST не равно 
                                                   //ИМЕНИ из сессии
    $data['name'] = $name; // записываю в переменную $data имя полученное из POST
    
}

if (!empty($email) && ($email != $_SESSION['email'])) { //если поле email не пустое И емайл НЕ равен эмайлу из сессии

    $data['email'] = $email; // записываю в переменную $data, email полученный из POST
    
    //проверяю email на допустимые символы
    if (!preg_match('#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#', $email)) {

        $_SESSION['emailErr'] = 'Неправильный формат email'; // записываю в сессию ошибку валидации
        $validate = 0; // валидация не пройдена (false)
    
  }
}

$result_email = check_user($pdo, $email); // передаю параметры в функцию и присваиваю полученные данные переменной
  if ($result_email && isset($email)) { // если есть данные из переменной И существует введенный емайл через форму

    $_SESSION['emailErr'] = 'Такой email уже зарегестрирован'; //записываю сообщение в сессию
    $validate = 0; // валидация не пройдена (false)
}

if($validate == 1) { //если валидация пройдена (true)

    $set = ''; // Присваиваю переменной пустую строку
    foreach ($data as $key => $value) { // прогоняю $data через цикл, что бы получить данные в sql запрос
        $set = $set . $key . ' = :' . $key . ', '; // преобразую массив в строку и конкатинирую ключи и разделитель  
    }

    $set = rtrim($set, ", "); // обрезаю последнюю запятую и пробел из строки
    $data['id'] = $id; // присваиваю id пользователя в переменную data
    
    $sql = "UPDATE users SET $set  WHERE id = :id"; //подготавливаю запрос к БД и меняю name или email
    $stmt_up = $pdo->prepare($sql);                 //подготавливаю запрос (защита от sql-инъекций)
    $stmt_up->execute($data);                       //выполнение запроса

    
    $_SESSION['email'] = $email; //перезаписываю новый емайл в сессию
    $_SESSION['name'] = $name; //перезаписываю новый емайл в сессию
    //dd($email);
    
    $_SESSION['success'] = 'Профиль успешно изменен'; //сообщение о успешном изменении профиля

    
}
header('location: /profile.php'); // редирект 
exit;

function upoadImage($image){

    $extention = pathinfo($image['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . "." . $extention;

    move_uploaded_file($image['tmp_name'], 'img/' . uniqid() . $extention);

    return $filename;
}

$filename = upoadImage($_FILES['image']);
