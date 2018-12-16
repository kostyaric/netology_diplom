<?php
include_once __DIR__ . '/header.php';
?>

<body>

    <h1>Редактирование вопросов "<?= $descr ?>"</h1>
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
    <p>
    Дата создания: <?= $question['qdate']; ?>; Статус: <?= $status ?>;
    <a href="./admin.php?id=<?= $question['ID'] ?>&act=del_question">Удалить</a>
    <a href="./admin.php?id=<?= $question['ID'] ?>&act=edit_question">Редактировать</a><br>

    <?= $question['qdescr'] ?>
    </p>
    <?php endforeach; ?>

</body>
</html>