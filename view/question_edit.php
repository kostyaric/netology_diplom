<?php
include_once __DIR__ . '/header.php';
?>

<body>

    <form action="./admin.php" method="POST">

        <label>Категория:
            <select name="category">
                <?php foreach ($category_list as $category): ?>
                <option value="<?= $category['ID'] ?>"><?= $category['descr'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Автор:
            <select name="user">
                <?php foreach ($user_list as $user): ?>
                <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Вопрос:
            <textarea name="question" rows="10" cols="60"></textarea><br>
        </label>

        <label>Ответ:
            <textarea name="answer" rows="10" cols="60"></textarea><br>
        </label>
        <fieldset>
            <legend>Статус</legend>
            <label><input class="check" type="radio" name="status" value="0">Ждет ответа</label>
            <label><input class="check" type="radio" name="status" value="1">Опубликован</label>
            <label><input class="check" type="radio" name="status" value="2">Скрыт</label>
        </fieldset>
        <input type="submit" name="bt_edit_question" value="Записать">

    </form>

    <?php include_once __DIR__ . '/logout.php'; ?>

</body>
</html>