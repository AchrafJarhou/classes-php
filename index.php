<?php

require "user-pdo.php";

$user = new User();

// Inscription
// $newUser = $user->register("fifi", "1234", "fifi@mail.com", "fifi", "jamin");
// print_r($newUser);

// Connexion
if ($user->connect("jean", "1234")) {
    echo "Connecté !<br>";
    print_r($user->getAllInfos());
}



// if ($user->disconnect()) {
//     echo "Déconnecté !<br>";
//     print_r($user->getAllInfos());
// }
// if ($user->delete()) {
//     echo "Utilisateur supprimé";
// }
if ($user->isConnected()) {
    echo "L'utilisateur {$user->getLogin()} qui a l'id : {$user->getId()} est connecté<br>";
} else {
    echo "L'utilisateur n'est pas connecté<br>";
}
if ($user->update("jean", "1234", "jean@gmail.com", "fifi", "yasmine")) {
    echo "Utilisateur mis à jour<br>";
    print_r($user->getAllInfos());
} else {
    echo "Échec de la mise à jour<br>";
}



// $user->delete();

var_dump($user->fetchAll());
