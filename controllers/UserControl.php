<?php

class UserControl
{
    private $query;
    private $errors;
    private $message;

    function __construct()
    {
        $this->query = new userQuery();
        $this->errors = [];
        $this->message = '';
    }

    /*Проверяет заполненность полей и отправляет вопрос на проверку*/
    function addQuestion()
    {

        $name = $_POST['username'];
        $email = $_POST['usermail'];
        $question = $_POST['question'];

        if (empty($name)) {
            $this->errors['name'] = 'Вы не указали имя';
        }

        if (empty($email)) {
            $this->errors['mail'] = 'Вы не указали адрес электронной почты';
        }

        if (empty($question)) {
            $this->errors['question'] = 'Не заполнено поле с вопросом';
        }

        if (count($this->errors) == 0) {
            $this->query ->saveQuestion($_POST['category'], $name, $email, $question);
            $this->message = 'Ваш вопрос будет опубликован после проверки и утверждения администратором';
        }

    }

    /*выводит перечень вопросов-ответов*/
    function showContent()
    {

        $errors = $this->errors;
        $message = $this->message;

        $content = $this->query->getContent();
        $category_list = $this->query->getCategoryList();
        include_once './view/content.php';

    }

}