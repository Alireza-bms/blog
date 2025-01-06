<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("location:./../");
    exit();
}
?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>php tutorial || blog project || webprog.io</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <?php if (str_contains($_SERVER['REQUEST_URI'], 'pages')): ?>
        <link rel="stylesheet" href="../../assets/css/style.css" />
    <?php else: ?>
        <link rel="stylesheet" href="./assets/css/style.css" />
    <?php endif; ?>
</head>

<body>
    <header class="navbar sticky-top bg-secondary flex-md-nowrap p-0 shadow-sm">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-5 text-white" href="index.php">پنل ادمین</a>
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-5 text-white" href="../index.php"> وبلاگ</a>
        <button class="ms-2 nav-link px-3 text-white d-md-none" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#sidebarMenu">
            <i class="bi bi-justify-left fs-2"></i>
        </button>
        <div class="col-auto">
            <a href="./pages/auth/logout.php" class="btn btn-danger">خروج از
                حساب کاربری
            </a>
        </div>
    </header>
    <?php include "../config.php"; ?>
    <?php
    $comments = $conn->query("SELECT * FROM `comments` ORDER BY `id` DESC LIMIT 3");
    $posts = $conn->query("SELECT * FROM `posts` ORDER BY `id` DESC LIMIT 3");
    $categories = $conn->query("SELECT * FROM `categories` ORDER BY `id` DESC LIMIT 3");
    ?>
    <?php
    if (isset($_GET['action']) and isset($_GET['entity']) and isset($_GET['id'])) {
        if (($_GET['action']) == 'delete' and ($_GET['entity']) == 'comments') {
            $sql_comments = $conn->prepare("DELETE FROM `comments` WHERE id=:cid");
            $query = $sql_comments->execute(['cid' => $_GET['id']]);
        }
        if (($_GET['action']) == 'edit' and ($_GET['entity']) == 'comments') {
            $sql_comments = $conn->prepare("UPDATE `comments` SET `status` ='1' WHERE id=:cid");
            $query = $sql_comments->execute(['cid' => $_GET['id']]);
        }
        header('location:index.php');
    }

    ?>
    <?php
    if (isset($_GET['action']) and isset($_GET['entity']) and isset($_GET['id'])) {
        if (($_GET['action']) == 'delete' and ($_GET['entity']) == 'posts') {
            $sql_posts = $conn->prepare("DELETE FROM `posts` WHERE id=:pid");
            $query = $sql_posts->execute(['pid' => $_GET['id']]);
        }
    }

    ?>
    <?php
    if (isset($_GET['action']) and isset($_GET['entity']) and isset($_GET['id'])) {
        if (($_GET['action']) == 'delete' and ($_GET['entity']) == 'cat') {
            $sql_posts = $conn->prepare("DELETE FROM `categories` WHERE id=:caid");
            $query = $sql_posts->execute(['caid' => $_GET['id']]);
        }
    }

    ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Section -->
            <?php include "layout/sidebar.php"; ?>
            <!-- Main Section -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="fs-3 fw-bold">داشبورد</h1>
                </div>
                <!-- Recently Posts -->
                <div class="mt-4">
                    <h4 class="text-secondary fw-bold">مقالات اخیر</h4>
                    <div class="table-responsive small">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>عنوان</th>
                                    <th>نویسنده</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <?php foreach ($posts as $post): ?>
                                <tbody>
                                    <tr>
                                        <th><?= $post['id'] ?></th>
                                        <td><?= $post['title'] ?></td>
                                        <td><?= $post['author'] ?></td>
                                        <td>
                                            <a href="pages\posts\edit.php?id=<?= $post['id'] ?>"
                                                class="btn btn-sm btn-outline-dark">ویرایش</a>
                                            <a href="?action=delete&entity=posts&id=<?= $post['id'] ?>"
                                                class="btn btn-sm btn-outline-danger">حذف</a>
                                        </td>
                                    </tr>
                                </tbody>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
                <!-- Recently Comments -->
                <div class="mt-4">
                    <h4 class="text-secondary fw-bold">کامنت های اخیر</h4>
                    <div class="table-responsive small">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>نام</th>
                                    <th>متن کامنت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <?php foreach ($comments as $comment): ?>
                                <tbody>
                                    <tr>
                                        <th><?= $comment['id'] ?></th>
                                        <td><?= $comment['name'] ?></td>
                                        <td><?= $comment['comment'] ?></td>
                                        <td>
                                            <?php if ($comment['status'] == 0): ?>
                                                <a href="?action=edit&entity=comments&id=<?= $comment['id'] ?>"
                                                    class="btn btn-sm btn-outline-info">در انتظار تایید</a>
                                            <?php elseif ($comment['status'] == 1): ?>
                                                <a href="#" class="btn btn-sm btn-outline-dark disabled">تایید شده</a>
                                            <?php endif; ?>
                                            <a href="?action=delete&entity=comments&id=<?= $comment['id'] ?>"
                                                class="btn btn-sm btn-outline-danger">حذف</a>
                                        </td>
                                    </tr>
                                </tbody>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
                <!-- Categories -->
                <div class="mt-4">
                    <h4 class="text-secondary fw-bold">دسته بندی</h4>
                    <div class="table-responsive small">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>عنوان</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $ctg): ?>
                                <tbody>
                                    <tr>
                                        <th><?= $ctg['id'] ?></th>
                                        <td><?= $ctg['title'] ?></td>
                                        <td>
                                            <a href="pages\categories\edit.php?id=<?= $ctg['id'] ?>"
                                                class="btn btn-sm btn-outline-dark">ویرایش</a>
                                            <a href="?action=delete&entity=cat&id=<?= $ctg['id'] ?>"
                                                class="btn btn-sm btn-outline-danger">حذف</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
</body>

</html>