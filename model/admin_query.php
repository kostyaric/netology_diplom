<?php

include_once __DIR__ . '/connect.php';

class adminQuery {

    function getAdminList($id = '') {

        $query_text = "
        Select
            id
            , login
        From admins
        " . ($id === '' ? "" : "Where id = :par_id");

        $connection = new pdoConnection($query_text);

        if ($id === '') {
            return $connection ->execQuery();
        }
        else {
            $params['par_id'] = $id;
            $adminlist = $connection->execQuery($params);
            return $adminlist[0];
        }
    }

    function addAdmin($login, $pass) {

        $query_text = "
        Insert Into
            admins(login, password)
        Values(:par_login, :par_pass)
        ";

        $params['par_login'] = $login;
        $params['par_pass'] = $pass;

        $connection = new pdoConnection($query_text);
        $connection ->execQuery($params, FALSE);

    }

    function deleteAdmin($id) {

        $query_text = "
        delete From
            admins
        Where id = :par_id
        ";

        $params['par_id'] = $id;

        $connection = new pdoConnection($query_text);
        $connection ->execQuery($params, FALSE);

    }

    function changeAdminPass($id, $pass) {

        $query_text = "
        Update admins
            Set password = :par_pass
        Where id = :par_id
        ";

        $params['par_id'] = $id;
        $params['par_pass'] = $pass;

        $connection = new pdoConnection($query_text);
        $connection ->execQuery($params, FALSE);

    }

    function getCategoryDescrByID($id) {

        $query_text = "
        Select
            descr
        From categorys
        Where ID = :par_ID
        ";

        $params['par_ID'] = $id;

        $connection = new pdoConnection($query_text);
        $category = $connection ->execQuery($params);

        if (empty($category)) {
            $descr = '';
        }
        else {
            $descr = $category[0]['descr'];
        }

        return $descr;

    }

    function getCategoryList() {

        $query_text = "
        Select
            categorys.ID
            , categorys.descr
            , COUNT(questions.ID) AS QuestionNum
            , SUM(Case
                    When questions.status = 0
                        Then 1
                    Else 0
                End) AS QuestionAdded
            , SUM(Case
                    When questions.status = 1
                        Then 1
                    Else 0
                End) AS QuestionPublished
            , SUM(Case
                    When questions.status = 2
                        Then 1
                    Else 0
                End) QuestionHidden
            , SUM(Case
                    When questions.ID IS Not NULL And answers.ID IS NULL
                        Then 1
                    Else 0
                End) WithoutAnswer
        From categorys
            Left Join questions
                On categorys.ID = questions.categoryID
            Left Join answers
                On questions.ID = answers.questionID
        Group By
            categorys.ID
            , categorys.descr
        ";

        $connection = new pdoConnection($query_text);
        return $connection ->execQuery();

    }

    function addCategory($title) {

        $query_text = "
        Insert Into
            categorys(descr)
        Values(:par_title)
        ";

        $params['par_title'] = $title;

        $connection = new pdoConnection($query_text);
        $connection ->execQuery($params, FALSE);

    }

    function getCategoryQuestions($categoryID) {

//        $query_text = "
//        Select
//            categorys.ID        As catID
//            , categorys.descr   As catdescr
//            , questions.qdate   As qdate
//            , questions.userID  As userID
//            , questions.descr   As qdescr
//            , users.name        As userName
//            , answers.adate     As adate
//            , answers.descr     As adescr
//        From categorys
//        Left Join questions
//            On categorys.ID = questions.categoryID
//        Left Join users
//            On questions.userID = users.ID
//        Left Join answers
//            On answers.questionID = questions.ID
//        Where categorys.ID = :par_categoryID
//        Order By
//            categorys.ID
//            , questions.qdate
//            , answers.adate
//        ";

        $query_text = "
        Select
            questions.ID        As ID
            , questions.qdate   As qdate
            , questions.descr   As qdescr
            , questions.status  As qstatus
            , users.id          As userID
            , users.name        As userName
        From questions
        Left Join users
            On questions.userID = users.id
        Where questions.categoryID = :par_categoryID
        Order By
            questions.qdate
        ";

        $params['par_categoryID'] = $categoryID;

        $connection = new pdoConnection($query_text);
        return $connection ->execQuery($params);

    }

    function getQuestionInfo($id) {

        $query_text = "
        Select
            questions.categoryID    As catID
            , questions.qdate       As qdate
            , questions.descr       As qdescr
            , questions.userID      As userID
            , users.name            As userName
            , answers.ID            As aID
            , answers.adate         As adate
            , answers.descr         As adescr
        From questions
        Left Join users
            On questions.userID = users.ID
        Left Join answers
            On answers.questionID = questions.ID
        Where questions.ID = :par_ID
        ";

        $params['par_ID'] = $id;

        $connection = new pdoConnection($query_text);
        return $connection ->execQuery($params);


    }

    function getUserList() {

        $query_text = "
        Select
            id
            , name
            , email
        From users
        ";

        $connection = new pdoConnection($query_text);
        return $connection -> execQuery();

    }

    function checkUser($login, $pass) {

        $query_text = "
        Select
            password
        From admins
        Where login = :par_login
        ";

        $params['par_login'] = $login;

        $connection = new pdoConnection($query_text);
        $admin = $connection ->execQuery($params);

        if (!empty($admin)) {

            $password = $admin[0]['password'];
            return $pass === $password;

        }

        return FALSE;
    }

}

//$query = new adminQuery();
//$adm = $query->getAdminList('2');
//var_dump($adm)
?>