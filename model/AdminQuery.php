<?php

class AdminQuery
{
    /*
    Получает из базы данных id и логин администроторов и возвращает массив с результатом
    Если передан id, то возвращаются данные для администратора с указанным id, иначе для всех администраторов
    */
    function getAdminList($id = '')
    {

        $query_text = "
        SELECT
            id
            , login
        FROM admins
        " . ($id === '' ? "" : "WHERE id = :par_id");

        $connection = new Connect($query_text);

        if ($id === '') {
            return $connection ->execQuery();
        }
        else {
            $params['par_id'] = $id;
            $adminlist = $connection->execQuery($params);
            return $adminlist[0];
        }
    }

    /*Записывает логин и пароль администратора в базу данных*/
    function addAdmin($login, $pass)
    {

        $query_text = "
        INSERT INTO
            admins(login, password)
        VALUES(:par_login, :par_pass)
        ";

        $params['par_login'] = $login;
        $params['par_pass'] = $pass;

        $connection = new Connect($query_text);
        $connection ->execQuery($params, FALSE);

    }

    /*Удаляет администратора из базы данных*/
    function deleteAdmin($id)
    {

        $query_text = "
        DELETE FROM
            admins
        WHERE id = :par_id
        ";

        $params['par_id'] = $id;

        $connection = new Connect($query_text);
        $connection ->execQuery($params, FALSE);

    }

    /*изменяет пароль администратора в базе данных*/
    function changeAdminPass($id, $pass)
    {

        $query_text = "
        UPDATE admins
            SET password = :par_pass
        WHERE id = :par_id
        ";

        $params['par_id'] = $id;
        $params['par_pass'] = $pass;

        $connection = new Connect($query_text);
        $connection ->execQuery($params, FALSE);

    }

    /*получает из базы данных описание категории по ее id*/
    function getCategoryDescrByID($id)
    {

        $query_text = "
        SELECT
            descr
        FROM categorys
        WHERE ID = :par_ID
        ";

        $params['par_ID'] = $id;

        $connection = new Connect($query_text);
        $category = $connection ->execQuery($params);

        if (empty($category)) {
            $descr = '';
        }
        else {
            $descr = $category[0]['descr'];
        }

        return $descr;

    }

    /*Получает из базы данных описание категории и количество вопросов и ответов в ней*/
    function getCategoryList()
    {

        $query_text = "
        SELECT
            categorys.ID
            , categorys.descr
            , COUNT(questions.ID) AS QuestionNum
            , SUM(CASE
                    WHEN questions.status = 0
                        THEN 1
                    ELSE 0
                END) AS QuestionAdded
            , SUM(CASE
                    WHEN questions.status = 1
                        THEN 1
                    ELSE 0
                END) AS QuestionPublished
            , SUM(CASE
                    WHEN questions.status = 2
                        THEN 1
                    ELSE 0
                END) QuestionHidden
            , SUM(CASE
                    WHEN questions.ID IS Not NULL And answers.ID IS NULL
                        THEN 1
                    ELSE 0
                END) WithoutAnswer
        FROM categorys
            LEFT JOIN questions
                ON categorys.ID = questions.categoryID
            LEFT JOIN answers
                ON questions.ID = answers.questionID
        GROUP BY
            categorys.ID
            , categorys.descr
        ";

        $connection = new Connect($query_text);
        return $connection ->execQuery();

    }

    /*Добавляет категорию в базу данных*/
    function addCategory($title)
    {

        $query_text = "
        INSERT INTO
            categorys(descr)
        VALUES(:par_title)
        ";

        $params['par_title'] = $title;

        $connection = new Connect($query_text);
        $connection ->execQuery($params, FALSE);

    }

    /*Удаляет категорию из базы данных*/
    function deleteCategory($ID)
    {

        $query_text = "
        DELETE
            categorys, questions, answers
        FROM categorys
            LEFT JOIN questions
                ON categorys.ID = questions.categoryID
            LEFT JOIN answers
                ON questions.ID = answers.questionID
        WHERE categorys.ID = :par_ID
        ";

        $params['par_ID'] = $ID;

        $connection = new Connect($query_text);
        $connection -> execQuery($params, FALSE);

    }

    /*Получает перечень вопросов по ID категории*/
    function getCategoryQuestions($categoryID)
    {

        $query_text = "
        SELECT
            questions.ID            As ID
            , questions.qdate       As qdate
            , questions.descr       As qdescr
            , questions.status      As qstatus
            , questions.categoryID  As categoryID
            , users.id              As userID
            , users.name            As userName
        FROM questions
        LEFT JOIN users
            ON questions.userID = users.id
        WHERE questions.categoryID = :par_categoryID
        ORDER BY
            questions.qdate
        ";

        $params['par_categoryID'] = $categoryID;

        $connection = new Connect($query_text);
        return $connection ->execQuery($params);

    }

    /*Получает расширенную информацию о вопросе и ответе по id вопроса*/
    function getQuestionInfo($id)
    {

        $query_text = "
        SELECT
            questions.categoryID    As catID
            , questions.ID          As qID
            , questions.qdate       As qdate
            , questions.descr       As qdescr
            , questions.userID      As userID
            , questions.status      As qstatus
            , users.name            As userName
            , answers.ID            As aID
            , answers.adate         As adate
            , answers.descr         As adescr
        FROM questions
        LEFT JOIN users
            ON questions.userID = users.ID
        LEFT JOIN answers
            ON answers.questionID = questions.ID
        WHERE questions.ID = :par_ID
        ";

        $params['par_ID'] = $id;

        $connection = new Connect($query_text);
        return $connection ->execQuery($params);

    }

    /*Изменяет вопрос в базе данных*/
    function changeQuestion($ID, $userID, $categoryID, $descr, $status)
    {

        $query_text = "
        UPDATE questions
        SET
            userID = :par_userID
            , categoryID = :par_categoryID
            , descr = :par_descr
            , status = :par_status
        WHERE
            ID = :par_ID
        ";

        $params['par_ID'] = $ID;
        $params['par_userID'] = $userID;
        $params['par_categoryID'] = $categoryID;
        $params['par_descr'] = $descr;
        $params['par_status'] = $status;

        $connection = new Connect($query_text);
        return $connection ->execQuery($params, FALSE);

    }

    /*Удаляет вопрос из базы данных*/
    function deleteQuestion($qID)
    {

        $query_text = "
        DELETE
            questions, answers
        FROM questions
            LEFT JOIN answers
                ON questions.ID = answers.questionID
        WHERE questions.ID = :par_qID
        ";

        $params['par_qID'] = $qID;

        $connection = new Connect($query_text);
        $connection -> execQuery($params, FALSE);

    }

    /*Получает из базы данных перечень вопросов без ответа*/
    function getQuestionWithoutAnswer()
    {

        $query_text = "
        SELECT
            categorys.ID        As catID
            , categorys.descr   As catdescr
            , questions.ID      As qID
            , questions.qdate   As qdate
            , questions.descr   As qdescr
        FROM categorys
        INNER JOIN questions
            ON categorys.ID = questions.categoryID
        LEFT JOIN answers
            ON answers.questionID = questions.ID
        WHERE answers.ID Is NULL
        ORDER BY
            questions.qdate";

        $connection = new Connect($query_text);
        return $connection ->execQuery();

    }

    /*Добавляет ответ на вопрос в базу данных*/
    function addAnswer($questionID, $descr)
    {

        $query_text = "
        INSERT INTO answers
            (questionID, adate, descr)
        VALUES
            (:par_questionID, CurDate(), :par_descr)
        ";

        $params['par_questionID'] = $questionID;
        $params['par_descr'] = $descr;

        $connection = new Connect($query_text);
        return $connection ->execQuery($params, FALSE);

    }

    /*Изменяет ответ в базе данных*/
    function changeAnswer($ID, $answer)
    {

        $query_text = "
        UPDATE answers
        SET
            descr = :par_answer
            , adate = CurDate()
        WHERE
            ID = :par_ID
        ";

        $params['par_ID'] = $ID;
        $params['par_answer'] = $answer;

        $connection = new Connect($query_text);
        return $connection ->execQuery($params, FALSE);

    }

    /*Удаляет ответ из базы данных*/
    function deleteAnswer($ID)
    {

        $query_text = "
        DELETE
        FROM answers
        WHERE
            ID = :par_ID
        ";

        $params['par_ID'] = $ID;

        $connection = new Connect($query_text);
        return $connection -> execQuery($params, FALSE);

    }

    /*Получает список пользователей из базы данных*/
    function getUserList()
    {

        $query_text = "
        SELECT
            id
            , name
            , email
        FROM users
        ";

        $connection = new Connect($query_text);
        return $connection -> execQuery();

    }

    /*Сверяет пароль введенный администратором в браузере с паролем в базе данных*/
    function checkUser($login, $pass)
    {

        $query_text = "
        SELECT
            password
        FROM admins
        WHERE login = :par_login
        ";

        $params['par_login'] = $login;

        $connection = new Connect($query_text);
        $admin = $connection ->execQuery($params);

        if (!empty($admin)) {

            $password = $admin[0]['password'];
            return $pass === $password;

        }

        return FALSE;
    }

}