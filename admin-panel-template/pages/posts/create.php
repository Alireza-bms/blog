<?php include "../../layout/header.php";?>
<?php include "../../../config.php";?>
<?php
$categories=$conn->query("SELECT * FROM categories");
$msg_title = "";
$msg_author = "";
$msg_category = "";
$msg_image = "";
$msg_body = "";
$flag=1;
if (isset($_POST['btn-create'])) {
    if (empty(trim($_POST['title']))) {
        $msg_title = " عنوان را وارد نمایید.";
        $flag=0;
    }
    if (empty(trim($_POST['author']))) {
        $msg_author = " نام نویسنده را وارد نمایید.";
        $flag=0;
    }
    if (empty(trim($_POST['category_id']))) {
        $msg_category = " دسته را وارد نمایید.";
        $flag=0;
    }
    if (empty(trim($_FILES['image']['name']))) {
        $msg_image = " تصویر را وارد نمایید.";
        $flag=0;
    }
    if (empty(trim($_POST['body']))) {
        $msg_body = " متن را وارد نمایید.";
        $flag=0;
    }
    if ($flag==1) {
        $img = $_FILES['image']['name'];
        if (move_uploaded_file($_FILES['image']['tmp_name'],"../../../assets/images/$img")) {
            $post=$conn->prepare("INSERT INTO `posts`(`title`, `body`, `category_id`, `author`, `image`) VALUES (:title,:body,:category_id,:author,:image)");
            $post->execute(['title'=>$_POST['title'],'body'=>$_POST['body'],'category_id'=>$_POST['category_id'],'author'=>$_POST['author'],'image'=>$img]);
        }
    }
}
?>
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar Section -->
                <?php include("../../layout/sidebar.php")
                ?>

                <!-- Main Section -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
                    >
                        <h1 class="fs-3 fw-bold">ایجاد مقاله</h1>
                    </div>

                    <!-- Posts -->
                    <div class="mt-4">
                        <form class="row g-4" method="post" enctype="multipart/form-data">
                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">عنوان مقاله</label>
                                <input type="text" class="form-control" name="title" />
                                <div class="form-text text-danger"><?=$msg_title?></div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">نویسنده مقاله</label>
                                <input type="text" class="form-control" name="author" />
                                <div class="form-text text-danger"><?=$msg_author?></div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label"
                                    >دسته بندی مقاله</label
                                >
                                <select class="form-select" name="category_id">
                                <?php foreach($categories as $category):?>
                                    <option value="<?=$category['id']?>"><?=$category['title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <div class="form-text text-danger"><?=$msg_category?></div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="formFile" class="form-label"
                                    >تصویر مقاله</label
                                >
                                <input class="form-control" type="file" name="image" />
                                <div class="form-text text-danger"><?=$msg_image?></div>
                            </div>

                            <div class="col-12">
                                <label for="formFile" class="form-label"
                                    >متن مقاله</label
                                >
                                <textarea
                                    class="form-control"
                                    rows="6"
                                    name="body"
                                ></textarea>
                                <div class="form-text text-danger"><?=$msg_body?></div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-dark" name="btn-create">
                                     ایجاد
                                </button>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
        </div>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
