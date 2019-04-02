<?php

/**
 * @Note Проверка существования таблиц в базе данных
 *
 * Если таблица отсутствует, выполняется импорт файла sql, файл должен находиться в /lib/sql_tables/
 * имя файла должно совпадать с именем таблицы.
 *
 * Принимает многомерный массив:
 *
 *  $checkdb = array(
 *      array(
 *          'table' => 't_koatuu_tree',  - имя таблицы (проверка её существования), тип string
 *          'is_empty' => true           - проверять ли на пустоту, тип boolean
 *      ),
 *      array(
 *          'table' => 'tt_users',
 *          'is_empty' => false
 *      )
 *  );
 */

    final class dbcheck{

        private $dbc;
        private $dir_sql_files = '../lib/sql_tables/';
        
        public function __construct(array $tables){
            if($this->checkArray($tables) === true){
                $this->connect();
                foreach($tables as $table){
                    $this->checkTable($table['table'], $table['is_empty']);
                }
                $this->dbc = false;
            } else{
                die('Не правильно заполнен многомерный массив класса dbcheck');
            }
        }

        private function checkArray($array){
            if(empty($array)){
                return false;
            }
            foreach($array as $sub_array){
                if(!is_array($sub_array)){
                    return false;
                } elseif(!isset($sub_array['table']) and !isset($sub_array['is_empty'])){
                    return false;
                } elseif(empty($sub_array['table']) or !is_string($sub_array['table']) or !is_bool($sub_array['is_empty'])){
                    return false;
                }
            }
            return true;
        }

        private function connect(){
            try {
                $this->dbc = new PDO(DB . ':host=' . DB_HOST . ';dbname=' .DB_NAME, DB_USER, DB_PASSWORD);
            } catch (PDOException $e) {
                die('Ошибка подключения к базе данных: ' . $e->getMessage());
            }
        }

        private function checkTable($table, $is_empty){
            $sql_array['is_exist'] = "SHOW TABLES FROM " . DB_NAME . " LIKE '" . $table . "'";
            if($is_empty === true){
                $sql_array['is_empty'] = "SELECT * FROM " . $table . " LIMIT 1";
            }

            foreach($sql_array as $sql){
                try {
                    $query = $this->dbc->query($sql);
                    $result = $query->fetch();
                    if($result === false){
                        throw new PDOException("0");
                    }
                } catch (PDOException $e) {
                    if($e->getMessage() === "0"){
                        $this->importTable($table);
                    } else {
                        die($e->getMessage());
                    }
                }
            }
        }

        private function importTable($table){
            $file_sql = $this->dir_sql_files . $table . ".sql";
            if(file_exists($file_sql)){
                if(!$this->dbc->query(file_get_contents($file_sql))){
                    die('Ошибка импорта файла ' . $table . '.sql');
                }
            } else {
                die('Ошибка! Не найден файл дампа ' . $table . '.sql');
            }
        }
    }
