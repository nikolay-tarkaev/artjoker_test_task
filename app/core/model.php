<?php
	class Model
	{
        /**
         * $dbc - экземпляр класса PDO
         *
         * Параметры метода queryMethod()
         *    *  $type - 'select' (если запрос select) или 'insert' (если запрос insert)
         *
         *    *  $fetch (используется если $type = 'select') -  'one' (если нужно вернуть одну строку, ->fetch()),
         *          'all' (если нужно вернуть все строки, ->fetchAll), возвращает ассоциативный массив.
         *          Если $type='insert', то значение $fetch указать false.
         *
         *    *  $sql - подготовленный sql запрос (используется PDO),
         *          пример "INSERT INTO " . __CLASS__ . "(name, email, territory) VALUES(:name, :email, :territory)";
         *
         *       $vars - ассоциативный массив, содержащий переменные, имена ключей массива должны совпадать с именами полей таблицы,
         *          пример, array('name'=> $name,'email'=> $email,'territory' => $territory);
         *
         *       * - обязательные параметры
         */

        protected $dbc;

        public function __construct()
        {
            $this->connect();
        }

        protected function connect()
        {
            try {
                $this->dbc = new PDO(DB . ':host=' . DB_HOST . ';dbname=' .DB_NAME, DB_USER, DB_PASSWORD);
            } catch (PDOException $e) {
                die('Ошибка подключения к базе данных: ' . $e->getMessage());
            }
        }

        public function queryMethod($type, $fetch, $sql, array $vars = array()){
            $query = $this->dbc->prepare($sql);
            if(!empty($vars) and is_array($vars)){
                $execute = $query->execute($vars);
            } else{
                $execute = $query->execute();
            }
            if($type == 'select'){
                if($fetch == 'one'){
                    return $query->fetch(PDO::FETCH_ASSOC);
                } elseif($fetch == 'all'){
                    return $query->fetchAll(PDO::FETCH_ASSOC);
                }
            } elseif($type == 'insert'){
                return $execute;
            }
        }

        public function __destruct()
        {
            $this->dbc = null;
        }
	}
