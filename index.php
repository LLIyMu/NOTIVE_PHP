<?php require_once('header.php'); ?>

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
                <?php if (isset($_SESSION['email'])) : ?>
                    <div class="card">
                        <div class="card-header">
                            <h3>Оставить комментарий</h3>
                        </div>


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
                    </div>
                <?php else : ?>

                    <div class="alert alert-success">
                        Чтобы оставить комментарий, <a href="register.php">зарегистрируйтесь</a> или <a href="login.php">авторизуйтесь</a>
                    </div>
                <?php endif; ?>

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