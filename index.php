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
    echo "L'utilisateur est connecté<br>";
} else {
    echo "L'utilisateur n'est pas connecté<br>";
}
