<?php

include_once __DIR__ . '/connect.php';

class adminQuery {

    function getAdminList() {

        $query_text = "
        Select
            id
            , login
        From admins
        ";

        $connection = new pdoConnection($query_text);
        return $connection ->execQuery();

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


    function getCategoryList() {

    }

    function getQuestionList() {

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
//$adm = $query->checkUser('admin', 'admin');
//var_dump($adm)
?>