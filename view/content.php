<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Вопросы и ответы</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./view/user.css">
</head>
<body>
        <h1>Список вопросов</h1>

        <?php foreach($content as $category):?>
            <h2><?= $category['catdescr'] ?></h2>
            <?php foreach($category['questions'] as $question):?>
            <div class="question">
                <h3><?= $question['qdescr'] ?></h3>
                <?php foreach($question['answers'] as $answer):?>
                    <p><?= $answer['adescr'] ?></p>
                <?php endforeach;?>
            </div>
            <?php endforeach;?>
        <?php endforeach;?>

        <div class="error">
            <?php foreach ($errors as $err_key => $err_value): ?>
                <p><?= $err_value ?></p>
            <?php endforeach; ?>
        </div>

        <div class="message">
            <p><?= $message ?></p>
        </div>

        <form action="index.php" method="POST">
            <fieldset>
            <legend>Задать вопрос</legend>
            <label>Ваше имя:
                <input type="text" name="username">
            </label>
            <label>Ваш e-mail:
                <input type="text" name="usermail">
            </label>
            <label>Категория:
            <select name="category">

                <?php foreach ($category_list as $category): ?>
                <option value="<?= $category['ID'] ?>"><?= $category['descr'] ?></option>
                <?php endforeach; ?>

            </select>
            </label>
            Вопрос:
            <textarea name="question" rows="10" cols="60"></textarea><br>
            <input type="submit" name="send" value="Отправить">
            </fieldset>
        </form>

    </body>

</html>
