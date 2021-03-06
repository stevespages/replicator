<?php


// Dev
$host = '127.0.0.1';
$db   = 'snippets';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$user = 'root';
$pass = '';
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];


/*
// Prod
$host = 'db722336839.db.1and1.com';
$db   = 'db722336839';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$user = 'dbo722336839';
$pass = '12345678';
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
*/

$db = new PDO($dsn, $user, $pass, $opt);


//$db = new PDO("mysql:host=localhost;dbname=snippets;charset=utf8mb4", "root", "");

//$db = new PDO("mysql:host=db719301055.db.1and1.com;dbname=db719301055;charset=utf8mb4", "dbo719301055", "Hstand!m")