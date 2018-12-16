<?php
include_once __DIR__ . '/header.php';
?>

<body>

    <form action="./admin.php" method="POST">
        <label>ID:
            <input type="text" name="id" value="<?= $id ?>" readonly>
        </label>
        <label>Имя:
            <input type="text" name="login" value="<?= $login ?>" readonly>
        </label>
        <label>Новый пароль:
            <input type="password" name="pass">
        </label>
        <input type="submit" name="bt_change_pass" value="ОК" />
    </form>

</body>
</html>