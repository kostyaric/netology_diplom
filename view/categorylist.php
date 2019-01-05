    <section>
    <h2>Категории</h2>
    <table>
        <?php foreach ($categorylist as $category):?>
        <tr>
            <td class="strong"><?= $category['descr']?></td>
            <td><a href="./admin.php?id=<?= $category['ID'] ?>&act=del_category">Удалить</a></td>
            <td><a href="./admin.php?id=<?= $category['ID'] ?>&act=edit_category">Редактировать</a></td>
        </tr>
        <tr>
            <td colspan="3">
            Количество вопросов: <?= $category['QuestionNum'] ?>; &nbsp;
            Опубликовано: <?= $category['QuestionPublished'] ?>; &nbsp;
            Без ответа: <?= $category['WithoutAnswer'] ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="center">
    <form action="./admin.php" method="POST">
        <fieldset>
            <legend>Добавить категорию</legend>
            <label>Название
                <input type="text" name="title">
            </label>
            <input type="submit" name="bt_addcategory" value="Добавить">
        </fieldset>
    </form>
    </div>
    </section>