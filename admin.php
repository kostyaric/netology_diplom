<?php

include_once __DIR__ . '/model/admin_query.php';
include_once __DIR__ . '/model/adminfunction.php';

$query = new adminQuery();
session_start();

if (!empty($_POST)) {

    $login = $_POST['login'];
    $pass = $_POST['pass'];

    if ($query->checkUser($login, $pass)) {
        $_SESSION['name'] = $login;
        include_once __DIR__ . '/view/admintools.php';
    }
    else {

        http_response_code(401);
        exit;

    }

}
elseif (isset($_SESSION['name'])) {

    include_once __DIR__ . '/view/admintools.php';

}
else {

    include_once __DIR__ . '/view/login.php';

}

include_once __DIR__ . '/view/logout.php';

?>