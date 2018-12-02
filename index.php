<?php
include_once __DIR__ . '/model/user_query.php';

include_once './view/header.php';

$query = new userQuery();
$category_list = $query->getCategoryList();

$message = '';
$errors = array();

if (!empty($_POST)) {

    $name = $_POST['username'];
    $email = $_POST['usermail'];
    $question = $_POST['question'];

//    var_dump($_POST);
    if (empty($name)) {
        $errors['name'] = 'Вы не указали имя';
    }

    if (empty($email)) {
        $errors['mail'] = 'Вы не указали адрес электронной почты';
    }

    if (empty($question)) {
        $errors['question'] = 'Не заполнено поле с вопросом';
    }

    if (count($errors) == 0) {
        $query ->saveQuestion($_POST['category'], $name, $email, $question);
        $message = 'Ваш вопрос будет опубликован после проверки и утверждения администратором';
    }
}

include_once __DIR__ . '/view/content.php';

?>

