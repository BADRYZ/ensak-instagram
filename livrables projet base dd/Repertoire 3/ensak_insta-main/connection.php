<?php
// Connexion a MySQL
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'ensak_insta';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>