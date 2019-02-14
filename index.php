<?php
include_once __DIR__ . '/model/UserQuery.php';
include_once __DIR__ . '/controllers/UserControl.php';
include_once __DIR__ . '/model/Connect.php';

$controller = new UserControl();

if (!empty($_POST)) {

    $controller->addQuestion();

}

$controller->showContent();


