<?php

require_once __DIR__ . "/config/db.php";

class User
{
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

    private $conn;
    private $isConnected = false;

    public function __construct()
    {
        global $conn;  // On récupère la connexion mysqli créée dans db.php
        $this->conn = $conn;
    }

    // Méthode pour créer un utilisateur
    public function register($login, $password, $email, $firstname, $lastname)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $login, $passwordHash, $email, $firstname, $lastname);

        if ($stmt->execute()) {
            return $this->getUserByLogin($login);
        } else {
            return ["error" => $stmt->error];
        }
    }

    // Méthode pour connecter un utilisateur
    public function connect($login, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $this->id = $user['id'];
            $this->login = $user['login'];
            $this->email = $user['email'];
            $this->firstname = $user['firstname'];
            $this->lastname = $user['lastname'];
            $this->isConnected = true;
            return true;
        }
        return false;
    }


    // Récupérer toutes les infos
    public function getAllInfos()
    {
        if ($this->isConnected) {
            return [
                "id" => $this->id,
                "login" => $this->login,
                "email" => $this->email,
                "firstname" => $this->firstname,
                "lastname" => $this->lastname
            ];
        }
        return null;
    }


    // Méthode privée pour retrouver un utilisateur
    private function getUserByLogin($login)
    {
        $stmt = $this->conn->prepare("SELECT id, login, email, firstname, lastname FROM utilisateurs WHERE login=?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
