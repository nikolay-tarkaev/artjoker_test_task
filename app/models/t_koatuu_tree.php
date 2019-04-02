<?php

class t_koatuu_tree extends Model{

    public function getTerritory($ter_id){
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

    public function getFullAddress($ter_id){
        $query = $this->dbc->prepare("SELECT ter_address FROM " . __CLASS__ . " WHERE ter_id = ?");
        $query->execute(array($ter_id));
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}