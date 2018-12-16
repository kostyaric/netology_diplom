<?php
include_once './view/header.php';
?>

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