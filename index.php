<?php

require "User.php";

$user = new User();

// Inscription
$newUser = $user->register("pascal", "1234", "pascal@mail.com", "pascal", "bouché");
print_r($newUser);

// Connexion
if ($user->connect("pascal", "1234")) {
    echo "Connecté !<br>";
    print_r($user->getAllInfos());
}
