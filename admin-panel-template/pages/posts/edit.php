<?php include "../../layout/header.php";?>
<?php include "../../../config.php";?>
<?php
$categories=$conn->query("SELECT * FROM categories");
if (isset($_GET['id'])) {
    $posts=$conn->prepare("SELECT * FROM posts WHERE id=:id");
    $posts->execute(["id"=>$_GET['id']]);
    $post=$posts->fetch();
}
$msg_title = "";
$msg_author = "";
$msg_category = "";
$msg_image = "";
$msg_body = "";
$flag=1;
if (isset($_POST['btn-edit'])) {
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
    if (empty(trim($_POST['body']))) {
        $msg_body = " متن را وارد نمایید.";
        $flag=0;
    }
    if ($flag==1) {
        $img = $_FILES['image']['name']??$post['image'];
        if (isset($_FILES['image']['name'])) {
            move_uploaded_file($_FILES['image']['tmp_name'],"../../../assets/images/$img");
        }
        $post=$conn->prepare("UPDATE posts SET title=:t,body=:b,category_id=:c,author=:a,image=:i WHERE id=:id");
        $post->execute(['t'=>$_POST['title'],'b'=>$_POST['body'],'c'=>$_POST['category_id'],'a'=>$_POST['author'],'i'=>$img,'id'=>$_GET['id']]);
        header("location:index.php");   
    }
}
?>
        <div class="container-fluid">
            <div class="row">
            <?php include("../../layout/sidebar.php")
                ?>

                <!-- Main Section -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
                    >
                        <h1 class="fs-3 fw-bold">ویرایش مقاله</h1>
                    </div>

                    <!-- Posts -->
                    <div class="mt-4">
                        <form class="row g-4" method="post" enctype="multipart/form-data">
                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">عنوان مقاله</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?=$post['title']?>"
                                    name="title"
                                />
                                <div class="form-text text-danger"><?=$msg_title?></div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">نویسنده مقاله</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?=$post['author']?>"
                                    name="author"
                                />
                                <div class="form-text text-danger"><?=$msg_author?></div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label"
                                    >دسته بندی مقاله</label
                                >
                                <select class="form-select" name="category_id">
                                    <?php foreach($categories as $category):?>
                                    <option <?=($post['category_id']==$category['id'])?"selected":""?>  value="<?=$category['id']?>"><?=$category['title']?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="formFile" class="form-label"
                                    >تصویر مقاله</label
                                >
                                <input class="form-control" type="file" name="image" enctype="multipart/form-data"/>
                            </div>

                            <div class="col-12">
                                <label for="formFile" class="form-label"
                                    >متن مقاله</label
                                >
                                <textarea class="form-control" rows="8" name="body">
                                    <?=$post['body']?>
                            </textarea>
                            <div class="form-text text-danger"><?=$msg_body?></div>
                            </div>

                            
                            <div class="col-12 col-sm-6 col-md-4">
                                <img class="rounded" src="../../../assets/images/<?=$post['image']?>" width="300" />
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark" name=btn-edit>
                                    ویرایش
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
