<?php

class tt_users extends Model{

    public function getEmail($email){
        $sql = "SELECT * FROM " . __CLASS__ . " WHERE email= ?";
        $query = $this->dbc->prepare($sql);
        $query->bindParam(1, $email);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function saveUser($name, $email, $territory){
        $sql = "INSERT INTO " . __CLASS__ . "(name, email, territory) VALUES(:name, :email, :territory)";
        $query = $this->dbc->prepare($sql);
        $query->bindParam(':name', $name);
        $query->bindParam(':email', $email);
        $query->bindParam(':territory', $territory);
        return $query->execute();
    }

    public function getAllUsers(){
        $sql = "SELECT * FROM " . __CLASS__ . " ORDER BY id DESC";
        $query = $this->dbc->query($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}