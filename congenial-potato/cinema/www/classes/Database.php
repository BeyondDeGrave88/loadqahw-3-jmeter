<?php
    require $_SERVER['DOCUMENT_ROOT'] . '/config/autoloader.php';
    class Database 
    {
        private $linkDB;
        private $response = array();

        public function __construct() 
        {
            //$this->connect();
        }

        private function connect() {
            $this->linkDB = mysqli_connect(BD_HOST, BD_USER_NAME, BD_PASSWORD, DB_NAME, DB_PORT);

            if (mysqli_errno($this->linkDB)) {
                echo BD_HOST+' '+ BD_USER_NAME+' '+BD_PASSWORD+' '+ DB_NAME+' '+DB_PORT;
                echo "Ошибка подключения к базе " . mysqli_errno($this->$linkDB) . ": " . mysqli_error($this->$linkDB);
            }
        }

        public  function mysqlQuery($query)
        {
            $this->connect();
            $result = mysqli_query($this->linkDB, $query);
            $this->response["result"] = (is_bool($result)) ? $result : mysqli_fetch_all($result, MYSQLI_ASSOC);
            $this->response["err"] = mysqli_errno($this->linkDB);
            $this->response["errMessage"] = mysqli_error($this->linkDB);
            return $this->response;
        }

        public function updateHalls() {
            return $this->mysqlQuery("SELECT * FROM halls ORDER BY hall_name");
        }

        public function updateFilms() {
            return  $this->mysqlQuery("SELECT * FROM films ORDER BY film_name");
        }

        public function updateSeances() {
            return $this->mysqlQuery("SELECT * FROM seances ORDER BY seance_start");
        }

        public function updateSales() {
            return $this->mysqlQuery("SELECT * FROM sales");
        }
    }
