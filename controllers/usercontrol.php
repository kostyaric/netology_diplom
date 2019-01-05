<?php

class usercontrol {

    private $query;

    function __construct() {
        $this->query = new userQuery();
    }

    function addQuestion() {

        global $errors;
        global $message;

        $name = $_POST['username'];
        $email = $_POST['usermail'];
        $question = $_POST['question'];

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
            $this->query ->saveQuestion($_POST['category'], $name, $email, $question);
            $message = 'Ваш вопрос будет опубликован после проверки и утверждения администратором';
        }

    }

    function showContent() {

        global $content;
        global $category_list;
        global $errors;
        global $message;

        $content = $this->query->getContent();
        $category_list = $this->query->getCategoryList();
        include_once './view/content.php';

    }

}