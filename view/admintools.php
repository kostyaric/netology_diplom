<?php
include_once './view/header.php';
?>

<body>

    <h1>Инструменты администратора</h1>

    <div class="error">
        <?php foreach ($errors as $err_key => $err_value): ?>
            <p><?= $err_value ?></p>
        <?php endforeach; ?>
    </div>


    <h2>Администраторы</h2>
    <?php foreach ($adminlist as $admin):?>
    <p>
        <?= $admin['login']?>
        <a href="./admin.php?id=<?= $admin['id'] ?>&act=del_admin">Удалить</a>
        <a href="./admin.php?id=<?= $admin['id'] ?>&act=change_password">Изменить пароль</a>
    </p>
    <?php endforeach; ?>

    <form action="./admin.php" method="POST">

        <fieldset>
            <legend>Добавить администратора</legend>
            <label>Имя
                <input type="text" name="login">
            </label>
            <label>Пароль
                <input type="password" name="pass">
            </label>
            <input type="submit" name="bt_addadmin" value="Добавить">
        </fieldset>
    </form>

    <h2>Категории</h2>
    <?php foreach ($categorylist as $category):?>
        <h3><?= $category['descr']?></h3>
        <a href="./admin.php?id=<?= $category['ID'] ?>&act=del_category">Удалить</a>
        <a href="./admin.php?id=<?= $category['ID'] ?>&act=edit_category">Редактировать</a>
    <p>
        Количество вопросов: <?= $category['QuestionNum'] ?><br>
        Опубликовано: <?= $category['QuestionPublished'] ?><br>
        Без ответа: <?= $category['WithoutAnswer'] ?>
    </p>
    <?php endforeach; ?>

    <form action="./admin.php" method="POST">
        <fieldset>
            <legend>Добавить категорию</legend>
            <label>Название
                <input type="text" name="title">
            </label>
            <input type="submit" name="bt_addcategory" value="Добавить">
        </fieldset>
    </form>


</body>
</html>