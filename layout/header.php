<?php include "config.php";
$res = $conn->query("SELECT * FROM `categories`");
$res = $res->fetchAll(PDO::FETCH_ASSOC);
session_start();
?>

<!DOCTYPE html>
<html dir="rtl" lang="fa">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>php tutorial || blog project</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />

    <link rel="stylesheet" href="./assets/css/style.css" />
</head>

<body>
    <div class="container py-3">
        <header class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
            <a href="index.php" class="fs-4 fw-medium link-body-emphasis text-decoration-none">
                weblog &nbsp;&nbsp;
            </a>
            <div class="col-auto">
                <a href=<?= (isset($_SESSION['login']) && $_SESSION['login'] == true) ? "admin-panel-template/" : "admin-panel-template/pages/auth/login.php" ?> class="btn btn-primary">ورود به
                    پنل ادمین
                </a>
            </div>
            <nav class="d-inline-flex mt-2 mt-md-0 me-md-auto">
                <?php foreach ($res as $cat) { ?>
                    <a class="me-3 py-2 link-body-emphasis text-decoration-none 
                        <?= (isset($_GET['catid']) && $cat['id'] == $_GET['catid']) ? 'fw-bold , border' : '' ?>"
                        href="index.php?catid=<?= $cat['id']; ?>"><?php echo $cat['title'];
                } ?></a>

            </nav>
        </header>