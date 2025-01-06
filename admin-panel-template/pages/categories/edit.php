<?php include "../../layout/header.php"; ?>
<?php include "../../../config.php"; ?>

<?php
$category = $conn->prepare("SELECT * FROM categories WHERE id=:caid");
$query = $category->execute(['caid' => $_GET['id']]);
$row = $category->fetch(PDO::FETCH_ASSOC);
?>
<?php
$msg_fail = "";
if (isset($_POST['btnedit'])) {
    $txtcat = $_POST['txtedit'];
    // unique category
    $result = $conn->prepare('SELECT * FROM categories WHERE title=?');
    $result->bindValue(1, $txtcat);
    $result->execute();
    if ($result->rowCount() == 0) {
        $newtitle = $_POST['txtedit'];
        $catupdate = $conn->prepare("UPDATE categories SET title =:newtitle WHERE id =:caid");
        $catupdate->execute([
            'newtitle' => $newtitle,
            'caid' => $_GET['id']
        ]);
        header("Location: index.php");
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
                <h1 class="fs-3 fw-bold">ویرایش دسته بندی</h1>
            </div>

            <!-- category -->
            <div class="mt-4">
                <form class="row g-4" method="post">
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">عنوان دسته بندی</label>
                        <input type="text" class="form-control" id="title" value="<?= $row['title'] ?>" name="txtedit"
                            required />
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-dark" name="btnedit">
                            ویرایش
                        </button>
                        <div class="form-text text-danger"><?= $msg_fail ?></div>
                    </div>
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