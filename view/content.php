    <body>
        <h1>Список вопросов</h1>

        <h2>Категория</h2>
        <h3>Вопрос1</h3>
        <p>
            Первый ответ на Вопрос1
        </p>
        <p>
            Второй ответ на Вопрос1
        </p>

        <h3>Вопрос2</h3>
        <p>
            Первый ответ на Вопрос2
        </p>
        <p>
            Второй ответ на Вопрос2
        </p>

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
