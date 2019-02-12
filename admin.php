<?php

include_once __DIR__ . '/model/admin_query.php';
include_once __DIR__ . '/model/connect.php';
include_once __DIR__ . '/controllers/admincontrol.php';

session_start();
$query = new adminQuery();
$controller = new admincontrol();

if (isset($_SESSION['name'])) {

    include_once './view/header.php';

    if (!empty($_POST)) {

        if (isset($_POST['bt_addadmin'])) {
            $controller->addAdmin();
        }
        elseif(isset($_POST['bt_change_pass'])) {
            $controller->changeAdminPassword();
        }
        elseif (isset($_POST['bt_addcategory'])) {
            $controller->addCategory();
        }
        elseif (isset($_POST['bt_edit_question'])) {
            $controller->editQuestion();
        }

    }

    if (!empty($_GET)) {

        if ($_GET['act'] === 'del_admin') {
            $controller->deleteAdmin();
        }
        elseif ($_GET['act'] === 'change_password') {
            $controller->showAdminPasswordWindow();
        }
        elseif ($_GET['act'] === 'del_category') {
            $controller->deleteCategory();
        }
        elseif ($_GET['act'] === 'edit_category') {
            $controller->editCategory();
        }
        elseif ($_GET['act'] === 'edit_question') {
            $controller->showEditQuestionWindow();
        }
        elseif ($_GET['act'] === 'del_question') {
            $controller->deleteQuestion();
        }
        elseif ($_GET['act'] === 'witout_answer') {
            $controller->questionWithoutAnswer();
        }
        elseif ($_GET['act'] === 'menu') {
            if ($_GET['id'] === 'admin') {
                $controller->showAdminList();
            }
            elseif ($_GET['id'] === 'category') {
                $controller->showCategoryList();
            }
        }

    }

    if (empty($_POST) && empty($_GET)) {
        $controller->showCategoryList();
    }

    include_once __DIR__ . '/view/logout.php';
    include_once __DIR__ . '/view/footer.php';
}
else {
    $controller->authorise();
}
