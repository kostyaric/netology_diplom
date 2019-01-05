    <h2>Редактируем вопрос-ответ</h2>
    <form class="varticalalign" action="./admin.php" method="POST">

        <input type="hidden" name="category_in" value="<?= $qInfo[0]['catID'] ?>">
        <label>Категория:
            <select name="category">
                <?php foreach ($category_list as $category): ?>
                <option value="<?= $category['ID'] ?>" <?= $qInfo[0]['catID'] == $category['ID'] ? 'selected' : '' ?>><?= $category['descr'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Автор:
            <select name="user">
                <?php foreach ($user_list as $user): ?>
                <option value="<?= $user['id'] ?>" <?= $qInfo[0]['userID'] == $user['id'] ? 'selected' : '' ?>><?= $user['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <input type="hidden" name="qID" value="<?= $qInfo[0]['qID'] ?>">
        <input type="hidden" name="aID" value="<?= $qInfo[0]['aID'] ?>">
        <label>Вопрос:
            <textarea name="question" rows="10" cols="60"><?= $qInfo[0]['qdescr'] ?></textarea><br>
        </label>

        <label>Ответ:
            <textarea name="answer" rows="10" cols="60"><?= $qInfo[0]['adescr'] ?></textarea><br>
        </label>
        <fieldset>
            <legend>Статус</legend>
            <?php $status = $qInfo[0]['qstatus'];?>
            <label><input class="check" type="radio" name="status" value="0" <?= $status == '0' ? 'checked' : '' ?>>Ждет ответа</label>
            <label><input class="check" type="radio" name="status" value="1" <?= $status == '1' ? 'checked' : '' ?>>Опубликован</label>
            <label><input class="check" type="radio" name="status" value="2" <?= $status == '2' ? 'checked' : '' ?>>Скрыт</label>
        </fieldset>
        <input type="submit" name="bt_edit_question" value="Записать">

    </form>