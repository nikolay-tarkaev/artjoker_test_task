<?php

class t_koatuu_tree extends Model
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

    protected function getTerritoryProtected($ter_id)
    {
        if($ter_id !== null){
            $sql_ter = "ter_pid = ?";
        } else{
            $sql_ter = "ter_level = ?";
        }
        $sql = "SELECT ter_id, ter_name FROM " . __CLASS__ . " WHERE " . $sql_ter;
        $query = $this->dbc->prepare($sql);
        if($ter_id !== null){
            $query->bindParam(1, $ter_id);
        } else{
            $ter_level = 1;
            $query->bindParam(1, $ter_level);
        }
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTerritory($ter_id)
    {
        return $this->getTerritoryProtected($ter_id);

    }

    public function getFullAddress($ter_id)
    {
        $sql = "SELECT ter_address FROM " . __CLASS__ . " WHERE ter_id = :ter_id";
        return $this->queryMethod('select', 'one', $sql, array('ter_id' => $ter_id));
    }
}