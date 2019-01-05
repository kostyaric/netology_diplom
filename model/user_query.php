<?php

class userQuery {

    function getContent() {

        $query_text = "
        Select
            categorys.ID        As catID
            , categorys.descr   As catdescr
            , questions.ID      As qID
            , questions.qdate   As qdate
            , questions.descr   As qdescr
            , answers.ID        As aID
            , answers.adate     As adate
            , answers.descr     As adescr
        From categorys
        Inner Join questions
            On categorys.ID = questions.categoryID
        Inner Join answers
            On answers.questionID = questions.ID
        Where questions.status = 1
        Order By
            categorys.descr
            , questions.qdate
            , answers.adate";


        $connection = new pdoConnection($query_text);
        $arr_content = $connection ->execQuery();

        $content = [];
        foreach ($arr_content as $content_row) {

            $content[$content_row['catID']]['catdescr'] = $content_row['catdescr'];

            $content[$content_row['catID']]['questions'][$content_row['qID']]['qdate'] = $content_row['qdate'];
            $content[$content_row['catID']]['questions'][$content_row['qID']]['qdescr'] = $content_row['qdescr'];

            $content[$content_row['catID']]['questions'][$content_row['qID']]['answers'][$content_row['aID']]['adate'] = $content_row['adate'];
            $content[$content_row['catID']]['questions'][$content_row['qID']]['answers'][$content_row['aID']]['adescr'] = $content_row['adescr'];

        }

        return $content;
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
        return $connection ->execQuery($params);

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
        $params['par_categoryID'] = $category;
        $params['par_descr'] = $question;

        $connection = new pdoConnection($query_text);
        $connection ->execQuery($params, FALSE);

    }

}

?>