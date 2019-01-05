    <h2>Редактирование вопросов в категории "<?= $descr ?>"</h2>
    <table>
    <?php foreach ($qlist as $question):

        switch ($question['qstatus']) {
        case 0:
            $status = 'Ожидает ответа';
            break;
        case 1:
            $status = 'Опубликован';
            break;
        case 2:
            $status = 'Скрыт';
            break;
         default:
            $status = 'Статус неопределен';
        }
    ?>
        <tr>
            <td class="strong"><?= $question['qdescr'] ?></td>
            <td><a href="./admin.php?catID=<?= $question['categoryID']?>&id=<?= $question['ID'] ?>&act=del_question">Удалить</a></td>
            <td><a href="./admin.php?id=<?= $question['ID'] ?>&act=edit_question">Редактировать</a></td>
        </tr>
        <tr>
            <td colspan="3">Дата создания: <?= $question['qdate']; ?>; Статус: <?= $status ?>;</td>
        </tr>
    <?php endforeach; ?>
    </table>