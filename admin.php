<?php

include_once __DIR__ . '/model/admin_query.php';
//include_once __DIR__ . '/model/adminfunction.php';

session_start();
$query = new adminQuery();

if (isset($_SESSION['name'])) {

    $errors = array();

    if (!empty($_POST)) {

        if (isset($_POST['bt_addadmin'])) {

            $login = $_POST['login'];
            $pass = $_POST['pass'];

            if (empty($login)) {
                $errors['login'] = 'Вы не указали имя админисратора';
            }
            if (empty($pass)) {
                $errors['pass'] = 'Вы не указали пароль админисратора';
            }

            if (count($errors) == 0) {
                $query->addAdmin($login, $pass);
            }
        }
        elseif(isset($_POST['bt_change_pass'])) {

            $id = $_POST['id'];
            $pass = $_POST['pass'];

            $query->changeAdminPass($id, $pass);

        }
        elseif (isset($_POST['bt_addcategory'])) {

            $title = $_POST['title'];
            if (empty($title)) {
                $errors['title'] = 'Вы не указали название категории';
            }

            $query->addCategory($title);

        }
        elseif (isset($_POST['bt_edit_question'])) {

            $aID = $_POST['aID'];
            $qID = $_POST['qID'];
            $answer = $_POST['answer'];
            $question = $_POST['question'];
            $userID = $_POST['user'];
            $categoryID = $_POST['category'];
            $status = $_POST['status'];

            if(empty($aID) && !empty($answer)) {
                $query->addAnswer($qID, $answer);
            }
            elseif(empty($answer)) {
                $query->deleteAnswer($aID);
            }
            else {
                $query->changeAnswer($aID, $answer);
            }

            if (!empty($qID)) {
                $query -> changeQuestion($qID, $userID, $categoryID, $question, $status);
            }

            $descr = $query->getCategoryDescrByID($_POST['category_in']);
            $qlist = $query->getCategoryQuestions($_POST['category_in']);

            include_once __DIR__ . '/view/category_questions.php';
            exit;

        }

    }

    if (!empty($_GET)) {

        if ($_GET['act'] === 'del_admin') {
            $query->deleteAdmin($_GET['id']);
        }
        elseif ($_GET['act'] === 'change_password') {

            $id = $_GET['id'];
            $admin = $query->getAdminList($id);
            $login = $admin['login'];
            include_once __DIR__ . '/view/newpassword.php';
            exit;
        }
        elseif ($_GET['act'] === 'del_category') {

            $query->deleteCategory($_GET['id']);

        }
        elseif ($_GET['act'] === 'edit_category') {

            $id = $_GET['id'];
            $descr = $query->getCategoryDescrByID($id);
            $qlist = $query->getCategoryQuestions($id);
            include_once __DIR__ . '/view/category_questions.php';
            exit;
        }
        elseif ($_GET['act'] === 'edit_question') {

            $id = $_GET['id'];
            $user_list = $query ->getUserList();
            $category_list = $query->getCategoryList();
            $qInfo = $query ->getQuestionInfo($id);
            include_once __DIR__ . '/view/question_edit.php';
            exit;

        }
        elseif ($_GET['act'] === 'del_question') {

            $query->deleteQuestion($_GET['id']);

            $descr = $query->getCategoryDescrByID($_GET['catID']);
            $qlist = $query->getCategoryQuestions($_GET['catID']);
            include_once __DIR__ . '/view/category_questions.php';
            exit;

        }
        elseif ($_GET['act'] === 'witout_answer') {

            $qlist = $query->getQuestionWithoutAnswer();
            include_once __DIR__ . '/view/without_answer.php';
            exit;

        }

    }

    $adminlist = $query->getAdminList();
    $categorylist = $query->getCategoryList();
    include_once __DIR__ . '/view/admintools.php';

}
else {

    if (!empty($_POST)) {

        $login = $_POST['login'];
        $pass = $_POST['pass'];

        if ($query->checkUser($login, $pass)) {
            $_SESSION['name'] = $login;
            header('location: admin.php');
        }
        else {

            http_response_code(401);
            exit;

        }

    }

    include_once __DIR__ . '/view/login.php';

}

include_once __DIR__ . '/view/logout.php';

?>