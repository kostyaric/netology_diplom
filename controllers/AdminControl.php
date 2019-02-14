<?php

class AdminControl
{
    private $query;

    function __construct()
    {
        $this->query = new adminQuery();
    }

    /*Проверяет заполненность полей и добавляет администратора в базу данных*/
    function addAdmin()
    {

        $errors = [];
        $login = $_POST['login'];
        $pass = $_POST['pass'];

        if (empty($login)) {
            $errors['login'] = 'Вы не указали имя администратора';
        }
        if (empty($pass)) {
            $errors['pass'] = 'Вы не указали пароль администратора';
        }

        if (count($errors) == 0) {
            $this->query->addAdmin($login, $pass);
        }
        else {
            include_once './view/errors.php';
        }

        $this->showAdminList();
    }

    /*Выводит окно для смены пароля администратора*/
    function showAdminPasswordWindow()
    {

        $id = $_GET['id'];
        $admin = $this->query->getAdminList($id);
        $login = $admin['login'];
        include_once './view/newpassword.php';
        exit;

    }

    /*Меняет пароль администратора в базе данных*/
    function changeAdminPassword()
    {

        $id = $_POST['id'];
        $pass = $_POST['pass'];

        $this->query->changeAdminPass($id, $pass);
        $this->showAdminList();

    }

    /*Удаляет администратора из базы данных*/
    function deleteAdmin()
    {

        $this->query->deleteAdmin($_GET['id']);
        $this->showAdminList();

    }

    /*Добавляет категорию в базу данных*/
    function addCategory()
    {

        $errors = [];
        $title = $_POST['title'];
        if (empty($title)) {
            $errors['title'] = 'Вы не указали название категории';
        }

        if (count($errors) == 0) {
            $this->query->addCategory($title);
        }
        else {
            include_once './view/errors.php';
        }

        $this->showCategoryList();
    }

    /*
    1. Получает описание категории по ID
    2. Получает список вопросов относящихся к категории
    3. Выводит список вопросов категории для редактирования
    */
    function editCategory()
    {

        $id = $_GET['id'];
        $descr = $this->query->getCategoryDescrByID($id);
        $qlist = $this->query->getCategoryQuestions($id);
        include_once './view/category_questions.php';
        exit;

    }

    /*Удаляет категорию из базы данных*/
    function deleteCategory()
    {
        $this->query->deleteCategory($_GET['id']);
        $this->showCategoryList();
    }

    /*Изменяет вопрос и ответ на него*/
    function editQuestion()
    {

        $aID = $_POST['aID'];
        $qID = $_POST['qID'];
        $answer = $_POST['answer'];
        $question = $_POST['question'];
        $userID = $_POST['user'];
        $categoryID = $_POST['category'];
        $status = $_POST['status'];

        if(empty($aID) && !empty($answer)) {
            $this->query->addAnswer($qID, $answer);
        }
        elseif(empty($answer)) {
            $this->query->deleteAnswer($aID);
        }
        else {
            $this->query->changeAnswer($aID, $answer);
        }

        if (!empty($qID)) {
            $this->query -> changeQuestion($qID, $userID, $categoryID, $question, $status);
        }

        $descr = $this->query->getCategoryDescrByID($_POST['category_in']);
        $qlist = $this->query->getCategoryQuestions($_POST['category_in']);

        include_once './view/category_questions.php';
        exit;

    }

    /*Выводит окно для редактирования вопроса*/
    function showEditQuestionWindow()
    {

        $id = $_GET['id'];
        $user_list = $this->query ->getUserList();
        $category_list = $this->query->getCategoryList();
        $qInfo = $this->query ->getQuestionInfo($id);
        include_once './view/question_edit.php';
        exit;

    }

    /*Удаляет вопрос*/
    function deleteQuestion()
    {

        $this->query->deleteQuestion($_GET['id']);

        $descr = $this->query->getCategoryDescrByID($_GET['catID']);
        $qlist = $this->query->getCategoryQuestions($_GET['catID']);
        include_once './view/category_questions.php';
        exit;

    }

    /*Выводит окно с перечнем вопросов без ответа*/
    function questionWithoutAnswer()
    {

        $qlist = $this->query->getQuestionWithoutAnswer();
        include_once './view/without_answer.php';
        exit;

    }

    /*Выводит окно со списком администраторов*/
    function showAdminList()
    {
        $adminlist = $this->query->getAdminList();
        include_once './view/adminlist.php';
    }

    /*Выводит окно с перечнем категорий*/
    function showCategoryList()
    {
        $categorylist = $this->query->getCategoryList();
        include_once './view/categorylist.php';
    }

    /*Выполняет авторизацию*/
    function authorise()
    {

        if (!empty($_POST)) {

            $login = $_POST['login'];
            $pass = $_POST['pass'];

            if ($this->query->checkUser($login, $pass)) {
                $_SESSION['name'] = $login;
                header('location: admin.php');
            }
            else {

                http_response_code(401);
                exit;

            }

        }

        include_once './view/login.php';

    }
}