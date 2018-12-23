<?php
include_once __DIR__ . '/header.php';
?>

<body>
    <h1>Список вопросов без ответа</h1>
    <?php foreach($qlist as $question): ?>
        <h2><?= $question['qdescr'] ?></h2>
        <p>Категория: <?= $question['qdescr'] ?>; Дата вопроса: <?= $question['qdate'] ?></p>
        <a href="./admin.php?catID=<?= $question['catID']?>&id=<?= $question['qID'] ?>&act=del_question">Удалить</a>
        <a href="./admin.php?id=<?= $question['qID'] ?>&act=edit_question">Редактировать</a><br>
    <?php endforeach; ?>
</body>
</html>