<?php require_once('db.php'); ?>
<?php 
if (isset($_SESSION['email']) && !isset($_COOKIE['email'])) {
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];
    $user_id = $_SESSION['user_id'];
} else{
    $email = $_COOKIE['email'];
    $name = $_COOKIE['name'];
    $user_id = $_COOKIE['user_id'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comments</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    Project
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <?php if (isset($email)) : ?>
                            <!-- если есть сессия то выводим вместо меню, имя пользователя -->
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Привет, <?php echo $name ?></a>
                            </li>
                            <li><a href="logout.php">Выход</a></li>
                        <?php else : ?>
                            <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>