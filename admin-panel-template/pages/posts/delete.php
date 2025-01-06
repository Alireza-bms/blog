<?php
include "../../layout/header.php";
include "../../../config.php";
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM posts WHERE id=:id");
    $stmt->execute(['id' => $_GET['id']]);
    header("Location: index.php");
}
