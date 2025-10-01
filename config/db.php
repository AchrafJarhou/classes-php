<?php

$envPath = file_exists(__DIR__ . '/../.env.local')
    ? __DIR__ . '/../.env.local'
    : __DIR__ . '/../.env';

// Charger les variables depuis le fichier .env
$env = parse_ini_file($envPath);

$host = $env['DB_HOST'];
$db   = $env['DB_NAME'];
$user = $env['DB_USER'];
$pass = $env['DB_PASS'];

// Connexion avec mysqli
$conn = new mysqli($host, $user, $pass, $db);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion MySQL : " . $conn->connect_error);
}
