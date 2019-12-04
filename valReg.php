<?php
//Функции бля валидации регистрации нового пользователя.
function clean($value = '') {
    $value = trim($value);   
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
}

//Функция для определения длинны строки на максимальное и минимального количества символов. 
function check_lenght($value = '', $min, $max) {
    $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
    return !$result;
}
;
