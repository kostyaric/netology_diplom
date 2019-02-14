<?php

class UserQuery
{

    /*Получает список вопросов-ответов из базы данных и формирует из них массив для вывода*/
    function getContent()
    {

        $query_text = "
        SELECT
            categorys.ID        As catID
            , categorys.descr   As catdescr
            , questions.ID      As qID
            , questions.qdate   As qdate
            , questions.descr   As qdescr
            , answers.ID        As aID
            , answers.adate     As adate
            , answers.descr     As adescr
        FROM categorys
        INNER JOIN questions
            ON categorys.ID = questions.categoryID
        INNER JOIN answers
            ON answers.questionID = questions.ID
        WHERE questions.status = 1
        ORDER BY
            categorys.descr
            , questions.qdate
            , answers.adate";


        $connection = new Connect($query_text);
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

    /*Получает список категорий для поля выбора*/
    function getCategoryList()
    {

        $query_text = "
        SELECT
            categorys.ID        As ID
            , categorys.descr   As descr
        FROM categorys
        ORDER BY
            categorys.descr";

        $connection = new Connect($query_text);
        return $connection ->execQuery();

    }

    /*Вносит в базу данные пользователя задавшего вопрос*/
    function createUser($name, $email)
    {

        $query_text = "
        INSERT INTO
            users(name, email)
        VALUES
            (:par_name, :par_email)
        ";

        $user_params['par_name'] = $name;
        $user_params['par_email'] = $email;

        $connection = new Connect($query_text);
        $connection ->execQuery($user_params, FALSE);

    }

    /*Получает данные пользователя из базы данных по его адресу электронной почты*/
    function getUserByMail($email)
    {

        $query_text = "
        SELECT
            id
            , name
            , email
        FROM users
        WHERE email = :par_email
        ";

        $params['par_email'] = $email;

        $connection = new Connect($query_text);
        return $connection ->execQuery($params);

    }

    /*Сохраняет заданный вопрос в базе данных*/
    function saveQuestion($category, $name, $email, $question)
    {

        $user = $this->getUserByMail($email);

        if (empty($user)) {
            $this->createUser($name, $email);
            $user = $this->getUserByMail($email);
        }

        $userID = $user[0]['id'];

        $query_text = "
        INSERT INTO
            questions(qdate, userID, categoryID, descr, status)
        VALUES
            (CURDATE(), :par_UserID, :par_categoryID, :par_descr, 0)
        ";

        $params['par_UserID'] = $userID;
        $params['par_categoryID'] = $category;
        $params['par_descr'] = $question;

        $connection = new Connect($query_text);
        $connection ->execQuery($params, FALSE);

    }

}
