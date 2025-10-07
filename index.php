<?php

require "User.php";

$user = new User();

// Inscription
// $newUser = $user->register("lala", "1234", "lala@mail.com", "lala", "jamin");
// print_r($newUser);

// Connexion
if ($user->connect("achraf", "1234")) {
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
    echo "L'utilisateur $user->login qui a l'id : {$user->getId()} est connecté<br>";
} else {
    echo "L'utilisateur n'est pas connecté<br>";
}
if ($user->update("achraf", "1234", "achraf@gmail.com", "Achraf", "Jamin")) {
    echo "Utilisateur mis à jour<br>";
    print_r($user->getAllInfos());
} else {
    echo "Échec de la mise à jour<br>";
}
