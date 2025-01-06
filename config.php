<?php
$cdn = "mysql:host=localhost;dbname=weblog;charset=utf8";
$username = "root";
$password = "";
try {
    $conn = new PDO($cdn, $username, $password);

} catch (PDOException $e) {
    echo $e->getMessage();
}
?>