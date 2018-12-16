<?php

class pdoConnection {

    private $host;
    private $basename;
    private $user;
    private $password;
    private $query_text;

    function __construct($query_text,
                        $host = 'localhost',
                        $basename = 'netology_diplom',
                        $user = 'root',
                        $password = '') {

        $this->query_text = $query_text;
        $this->host = $host;
        $this->basename = $basename;
        $this->user = $user;
        $this->password = $password;
    }

    function getConnection() {

        try {

            return new PDO("mysql:host=$this->host; dbname=$this->basename", $this->user, $this->password);

        } catch (PDOException $ex) {

            echo 'Connection Error: ' . $ex->getMessage();

        }

    }

    function execQuery($params = [], $return_result = true) {

        $pdo = $this->getConnection();
        $pdo_prepare = $pdo -> prepare($this->query_text);
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

}

?>