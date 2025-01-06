<?php include "../../layout/header.php"; ?>
<?php include "../../../config.php"; ?>
<?php
$msg_fail = "";
$msg_Success = "";
if (isset($_POST['createcat'])) {
    $txtcat = $_POST['txtcat'];
    // unique category
    $result = $conn->prepare('SELECT * FROM categories WHERE title=?');
    $result->bindValue(1, $txtcat);
    $result->execute();
    if ($result->rowCount() == 0) {

        $result = $conn->prepare('INSERT INTO `categories` SET title=?');
        $result->bindValue(1, $txtcat);
        $result->execute();
        $msg_Success = "دسته بندی با موفقیت ایجاد شد";
    } else {
        $msg_fail = "این دسته بندی از قبل وجود دارد";
    }
}
?>
<div class="container-fluid">
    <div class="row">
        <?php include "../../layout/sidebar.php"; ?>
        <!-- Main Section -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="fs-3 fw-bold">ایجاد دسته بندی</h1>
            </div>

            <!-- Posts -->
            <div class="mt-4">
                <form method="post" class="row g-4">
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">عنوان دسته بندی</label>
                        <input type="text" class="form-control" name="txtcat" required />
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-dark" name="createcat">
                            ایجاد
                        </button>
                    </div>
                    <div class="form-text text-danger"><?= $msg_fail ?></div>
                    <div class="text-success"><?= $msg_Success ?></div>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
</body>

</html>