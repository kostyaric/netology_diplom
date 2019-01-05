<?php
include_once __DIR__ . '/model/user_query.php';
include_once __DIR__ . '/controllers/usercontrol.php';
include_once __DIR__ . '/model/connect.php';

$message = '';
$errors = array();

$controller = new usercontrol();

if (!empty($_POST)) {

    $controller->addQuestion();

}

$controller->showContent();

?>

