<?php
    class User
    {
        private $logged = false;
        public $name;
        public $email;
        public $status;

        public function __construct($session_data = null)
        {
            if (is_array($session_data) && (isset($session_data['email']))) {
                $this->email = $session_data['email'];
                $this->logged = true;
            } elseif (isset($_COOKIE['email'])) {
                $this->email = $_COOKIE['email'];
                $this->logged = true;
            }
        }

        public function isLogged()
        {
            return $this->logged;
        }
    }
?>