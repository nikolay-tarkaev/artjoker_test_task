<?php

class tt_users extends Model
{
    /**
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

    public function getEmail($email)
    {
        $sql = "SELECT * FROM " . __CLASS__ . " WHERE email= :email";
        return $this->queryMethod('select', 'one', $sql, array('email' => $email));
    }

    public function saveUser($name, $email, $territory)
    {
        $sql = "INSERT INTO " . __CLASS__ . "(name, email, territory) VALUES(:name, :email, :territory)";
        $vars = array(
            'name'      => $name,
            'email'     => $email,
            'territory' => $territory
        );
        return $this->queryMethod('insert', false, $sql, $vars);
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM " . __CLASS__ . " ORDER BY id DESC";
        return $this->queryMethod('select', 'all', $sql);
    }
}