    <h2>Список вопросов без ответа</h2>
    <table>
    <?php foreach($qlist as $question): ?>
        <tr>
            <td class="strong"><?= $question['qdescr'] ?></td>
            <td><a href="./admin.php?catID=<?= $question['catID']?>&id=<?= $question['qID'] ?>&act=del_question">Удалить</a></td>
            <td><a href="./admin.php?id=<?= $question['qID'] ?>&act=edit_question">Редактировать</a></td>
        </tr>
        <tr>
            <td colspan="3">Категория: <?= $question['catdescr'] ?>; Дата вопроса: <?= $question['qdate'] ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
