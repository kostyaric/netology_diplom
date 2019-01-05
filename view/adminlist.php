    <section>
    <h2>Администраторы</h2>
    <table>
        <?php foreach ($adminlist as $admin):?>
        <tr>
            <td><?= $admin['login']?></td>
            <td><a href="./admin.php?id=<?= $admin['id'] ?>&act=del_admin">Удалить</a></td>
            <td><a href="./admin.php?id=<?= $admin['id'] ?>&act=change_password">Изменить пароль</a></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <form action="./admin.php" method="POST">

        <fieldset>
            <legend>Добавить администратора</legend>
            <label>Имя
                <input type="text" name="login">
            </label>
            <label>Пароль
                <input type="password" name="pass">
            </label>
            <input type="submit" name="bt_addadmin" value="Добавить">
        </fieldset>
    </form>
    </section>