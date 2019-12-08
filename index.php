<?php require_once('db.php'); ?>
<? var_dump($_COOKIE); ?>
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

                        <?php if (isset($_SESSION['user_info'])) : ?>
                            <!-- если есть сессия то выводим вместо меню, имя пользователя -->
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Привет, <?php echo $_SESSION['user_info']['name'] ?></a>
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

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Комментарии</h3>
                            </div>

                            <div class="card-body">
                                <div class="alert alert-success <? if (empty($_SESSION['alert'])) : echo 'd-none' ?><? endif; ?>" role="alert">
                                    <? //Добавляю сообщение о добавлении комментария
                                    if (isset($_SESSION['alert'])) {
                                        echo $_SESSION['alert'];
                                        unset($_SESSION['alert']);
                                    }
                                    ?>
                                </div>
                                <?php
                                //вывод комментариев
                                require_once('db.php');

                                $comments = $pdo->query('SELECT * FROM `form` ORDER BY id DESC')->fetchAll();

                                ?>
                                <?php foreach ($comments as $comment) : ?>
                                    <div class="media">
                                        <img src="img/no-user.jpg" class="mr-3" alt="..." width="64" height="64">
                                        <div class="media-body">
                                            <h5 class="mt-0"><?= $comment['user'] ?></h5>
                                            <span><small><?= date('d/m/Y', strtotime($comment['date'])) ?></small></span>
                                            <p>
                                                <?= $comment['text'] ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="card">
                            <div class="card-header">
                                <h3>Оставить комментарий</h3>
                            </div>
                        
                            <?php if(isset($_SESSION['user_info'])) : ?>
                            <div class="card-body">
                                <form action="store.php" method="post">

                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea2">Сообщение</label>
                                        <textarea name="text" class="form-control" id="exampleFormControlTextarea2" rows="3"></textarea>
                                        <div class="alert alert-success <? if (empty($_SESSION['text'])) : echo 'd-none' ?><? endif; ?> " role="alert">
                                            <? //Add alert message user
                                            if (isset($_SESSION['text'])) {
                                                echo $_SESSION['text'];
                                                unset($_SESSION['text']);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Отправить</button>
                                </form>
                            </div>
                            <?php else : ?>

                                <div class="alert alert-success">
                                    <p>Чтобы оставить комментарий, </p>
                                    <a href="register.php">зарегистрируйтесь</a>
                                    <p>или</p>
                                    <a href="login.php">авторизуйтесь</a> 
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
                                    <!-- <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Имя</label>
                                        <input name="user" class="form-control" id="exampleFormControlTextarea1">
                                        <div class="alert alert-success <? if (empty($_SESSION['user'])) : echo 'd-none' ?><? endif; ?> " role="alert">
                                            <? //Add alert message user
                                            if (isset($_SESSION['user'])) {
                                                echo $_SESSION['user'];
                                                unset($_SESSION['user']);
                                            }
                                            ?>
                                        </div>
                                    </div> -->