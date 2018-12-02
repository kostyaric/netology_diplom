<?php

include_once __DIR__ . '/connect.php';

class userQuery {

    private $qwery_text;

    function execQuery($params = [], $return_result = true) {

        $connection = new pdoConnection();
        $pdo = $connection -> getConnection();
        $pdo_prepare = $pdo -> prepare($this->qwery_text);
        if (!empty($params)) {
            $pdo_prepare -> execute($params);
        }
        else {
            $pdo_prepare -> execute();
        }
        if ($return_result) {
            $result = $pdo_prepare -> fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    function getContent() {

        $query_text = "
        Select
            categorys.ID        As catID
            , categorys.descr   As catdescr
            , questions.descr   As qdescr
            , answers.adate     As adate
            , answers.descr     As adescr
        From categorys
        Inner Join questions
            On categorys.ID = questions.categoryID
        Inner Join answers
            On answers.questionID = questions.ID
        Where questions.status = 3
        Order By
            categorys.descr
            , questions.qdate
            , answers.adate";


        $connection = new pdoConnection($query_text);
        $arr_answer = $connection ->execQuery();

        foreach ($arr_answer as $value) {

        }

    }

    function getCategoryList() {

        $query_text = "
        Select
            categorys.ID        As ID
            , categorys.descr   As descr
        From categorys
        Order By
            categorys.descr";

        $connection = new pdoConnection($query_text);
        return $connection ->execQuery();

    }

    function createUser($name, $email) {

        $query_text = "
        Insert Into
            users(name, email)
        values
            (:par_name, :par_email)
        ";

        $user_params['par_name'] = $name;
        $user_params['par_email'] = $email;

        $connection = new pdoConnection($query_text);
        $connection ->execQuery($user_params, FALSE);

//        $this->execQuery($user_params, FALSE);
    }


    function getUserByMail($email) {

        $query_text = "
        Select
            id
            , name
            , email
        From users
        Where email = :par_email
        ";

        $params['par_email'] = $email;

        $connection = new pdoConnection($query_text);
        $connection ->execQuery($params);

//        return $this->execQuery($params);
    }

    function saveQuestion($category, $name, $email, $question) {

        $user = $this->getUserByMail($email);

        if (empty($user)) {
            $this->createUser($name, $email);
            $user = $this->getUserByMail($email);
        }

        $userID = $user[0]['id'];

        $query_text = "
        Insert Into
            questions(qdate, userID, categoryID, descr, status)
        values
            (CURDATE(), :par_UserID, :par_categoryID, :par_descr, 0)
        ";

        $params['par_UserID'] = $userID;
        $params['par_categoryID'] = (int)$category;
        $params['par_descr'] = $question;

        $connection = new pdoConnection($query_text);
        $connection ->execQuery($params, FALSE);


//        $this->execQuery($params, FALSE);

    }

}

//$query = new userQuery();
//$arrCat = $query->getCategoryList();
//var_dump($arrCat);

?>