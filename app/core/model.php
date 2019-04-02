<?php
	class Model{

        protected $dbc;

        public function __construct(){
            $this->connect();
        }

        protected function connect(){
            try {
                $this->dbc = new PDO(DB . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASSWORD);
            } catch (PDOException $e) {
                die('Ошибка подключения к базе данных: ' . $e->getMessage());
            }
        }

        public function __destruct(){
            $this->dbc = null;
        }
	}
