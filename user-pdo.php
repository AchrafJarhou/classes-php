<?php

require_once __DIR__ . "/config/pdo.php";

class User
{
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

    private $pdo;
    private $isConnected = false;

    public function __construct()
    {
        global $pdo;  // On récupère la connexion PDO créée dans pdo.php
        $this->pdo = $pdo;
    }

    // Méthode pour créer un utilisateur
    public function register($login, $password, $email, $firstname, $lastname)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES (?, ?, ?, ?, ?)");
        var_dump($stmt->errorInfo());
        if ($stmt->execute([$login, $passwordHash, $email, $firstname, $lastname])) {
            var_dump($stmt->errorInfo());
            return $this->getUserByLogin($login);
        } else {
            return ["error" => implode(" ", $stmt->errorInfo())];
        }
    }

    // Méthode pour connecter un utilisateur
    public function connect($login, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

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

    // Déconnexion
    public function disconnect()
    {
        if ($this->isConnected) {
            $this->id = null;
            $this->login = null;
            $this->email = null;
            $this->firstname = null;
            $this->lastname = null;
            $this->isConnected = false;
            return true;
        }
        return false;
    }

    // Méthode pour vérifier si l'utilisateur est connecté
    public function isConnected()
    {
        return $this->isConnected;
    }

    // Méthode pour récupérer les informations de l'utilisateur
    public function getUserInfo()
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
    // Méthode pour récupérer un utilisateur par son login
    private function getUserByLogin($login)
    {
        $stmt = $this->pdo->prepare("SELECT id, login, email, firstname, lastname FROM utilisateurs WHERE login = ?");
        $stmt->execute([$login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Supprimer un utilisateur connecté
    public function delete()
    {
        if ($this->isConnected && $this->id) {
            $stmt = $this->pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
            if ($stmt->execute([$this->id])) {
                $this->disconnect();
                return true;
            }
        }
        return false;
    }
    // Mettre à jour l'utilisateur
    public function update($login, $password, $email, $firstname, $lastname)
    {
        if (!$this->isConnected) {
            return false;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("UPDATE utilisateurs SET login = ?, password = ?, email = ?, firstname = ?, lastname = ? WHERE id = ?");
        if ($stmt->execute([$login, $passwordHash, $email, $firstname, $lastname, $this->id])) {
            // Mettre à jour les propriétés de l'objet
            $this->login = $login;
            $this->email = $email;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
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

    // Getters simples

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }
    // Récupérer tous les utilisateurs
    public function fetchAll()
    {
        $stmt = $this->pdo->query("SELECT id, login, email, firstname, lastname FROM utilisateurs");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
