<?php include "../../layout/header.php"; ?>
<?php include "../../../config.php"; ?>
<?php
$posts = $conn->query("SELECT * FROM posts ORDER BY id DESC");
?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Section -->
        <?php include("../../layout/sidebar.php")
            ?>
        <!-- Main Section -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="fs-3 fw-bold">مقالات</h1>

                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="./create.php" class="btn btn-sm btn-dark">
                        ایجاد مقاله
                    </a>
                </div>
            </div>

            <!-- Posts -->
            <div class="mt-4">
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
                        <tbody>
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <th><?= $post['id'] ?></th>
                                    <td><?= $post['title'] ?></td>
                                    <td><?= $post['author'] ?></td>
                                    <td>
                                        <a href="./edit.php?id=<?= $post['id'] ?>"
                                            class="btn btn-sm btn-outline-dark">ویرایش</a>
                                        <a href="#" class="btn btn-sm btn-outline-danger">حذف</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
</body>

</html>