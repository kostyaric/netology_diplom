<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Авторизация</title>
    <link rel="stylesheet" href="./view/admin.css">
    <meta charset="utf-8">
</head>
<body>

    <form action="./admin.php" method="POST">
        <label>Имя:
            <input type="text" name="login" value="" />
        </label>
        <label>Пароль:
            <input type="password" name="pass" value="" />
        </label>
        <input type="submit" name="bt_access" value="ОК" />
    </form>

</body>
</html>