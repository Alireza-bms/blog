
<?php include "config.php";?>
<?php include "layout/header.php";?>
<?php
    $id = $_GET['id'];
    
    $posts = $conn->query("SELECT * FROM posts WHERE id=$id");
    $categories = $conn->query("SELECT * FROM categories");
    $comments = $conn->query("SELECT * FROM comments WHERE post_id=$id AND status='1'");

    if(isset($_POST['sub'])){
        if(!empty($_POST['txtname']) && !empty($_POST['txtmail'])){ 
        $name = $_POST['name'];
        $email = $_POST['email'];
        $result = $conn->prepare('INSERT INTO subscribers SET name=?, email=?');
        $result->bindValue(1, $name);
        $result->bindValue(2, $email);
        $result->execute();
        echo "<span style = color:green>Successfully Created</span><br>";
        }else{
        echo "<span style = color:red>Please Enter Your Information</span><br>";}}


    if(isset($_GET['searchBtn'])){
        $search=$_GET['txtsearch'];
        $posts=$conn->prepare("SELECT * FROM 'posts' WHERE 'title' LIKE :title");
        $posts->execute(['title'=>"%$search"]);
    }

?>
<?php
    if(isset($_POST['cmntbtn'])){
        if(!empty($_POST['cmntname']) && !empty($_POST['cmnttext'])){ 
        $cmntname = $_POST['cmntname'];
        $cmnttext = $_POST['cmnttext'];

        $result = $conn->prepare('INSERT INTO comments SET name=?, comment=?, post_id=?');
        $result->bindValue(1, $cmntname);
        $result->bindValue(2, $cmnttext);
        $result->bindValue(3, $id);
        $result->execute();
        echo "<span style = color:green>Successfully Created</span><br>";
        }else{
        echo "<span style = color:red>Please Enter Your Information</span><br>";}}
?>


<!DOCTYPE html>
<html dir="rtl" lang="fa">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>php tutorial || blog project</title>

        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
        />
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9"
            crossorigin="anonymous"
        />

        <link rel="stylesheet" href="./assets/css/style.css" />
    </head>

    <body>
        <div class="container py-3">

            <main>
                <!-- Content -->
                <section class="mt-4">
                    <div class="row">
                        <!-- Posts & Comments Content -->
                        <div class="col-lg-8">
                            <div class="row justify-content-center">
                                <!-- Post Section -->
                                <?php foreach($posts as $post): ?>
                                <div class="col">
                                    <div class="card">
                                        <img
                                            src="./assets/images/<?= $post['image'] ?>"
                                            class="card-img-top"
                                            alt="post-image"
                                        />
                                        <div class="card-body">
                                            <div
                                                class="d-flex justify-content-between"
                                            >
                                                <h5 class="card-title fw-bold">
                                                <?= $post['title'] ?>
                                                </h5>
                                                <div>
                                                    <span class="badge text-bg-secondary"><?php foreach($categories as $category){if($post['category_id'] == $category['id']){echo $category['title'];   }} ?> </span
                                                    >
                                                </div>
                                            </div>
                                            <p
                                                class="card-text text-secondary text-justify pt-3"
                                            ><?= $post['body'] ?></p>
                                            <div>
                                                <p class="fs-6 mt-5 mb-0">
                                                    نویسنده : <?= $post['author'] ?> 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>

                                <hr class="mt-4" />

                                <!-- Comment Section -->
                                <div class="col">
                                    <!-- Comment Form -->
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="fw-bold fs-5">
                                                ارسال کامنت
                                            </p>

                                            <form method="post">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        >نام</label
                                                    >
                                                    <input
                                                        type="text"
                                                        name="cmntname"
                                                        class="form-control"
                                                    />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        >متن کامنت</label
                                                    >
                                                    <textarea
                                                        class="form-control"
                                                        name="cmnttext"
                                                        rows="3"
                                                    ></textarea>
                                                </div>
                                                <button
                                                    type="submit"
                                                    name="cmntbtn"
                                                    class="btn btn-dark"
                                                >
                                                    ارسال
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <hr class="mt-4" />
                                    <!-- Comment Content -->
                                    <p class="fw-bold fs-6">تعداد کامنت : <?php echo $comments->rowCount(); ?></p>
                                    <?php foreach($comments as $comment): ?>
                                    <div class="card bg-light-subtle mb-3">
                                        <div class="card-body">
                                            <div
                                                class="d-flex align-items-center"
                                            >
                                                <img
                                                    src="./assets/images/profile.png"
                                                    width="45"
                                                    height="45"
                                                    alt="user-profle"
                                                />

                                                <h5
                                                    class="card-title me-2 mb-0"
                                                >
                                                    <?= $comment['name'] ?>
                                                </h5>
                                            </div>

                                            <p class="card-text pt-3 pr-3"> <?= $comment['comment'] ?></p>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Section -->
                        <div class="col-lg-4">
                            <!-- Sesrch Section -->
                            <div class="card">
                    <div class="card-body">
                        <p class="fw-bold fs-6">جستجو در وبلاگ</p>
                        <form action="search.php" method="get" >
                            <div class="input-group mb-3">
                                <input
                                    type="text"
                                    name="wordSearch"
                                    class="form-control"
                                    placeholder="جستجو ..."
                                />
                                <button
                                    class="btn btn-secondary"
                                    name="searchBtn"
                                    type="submit"
                                >
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                            <!-- Categories Section -->
                            <div class="card mt-4">
                    <div class="fw-bold fs-6 card-header">دسته بندی ها</div>
                    <ul class="list-group list-group-flush p-0">
                    <?php foreach($categories as $category): ?>
                        <li class="list-group-item">
                            <a
                                class="link-body-emphasis text-decoration-none"
                                href="#"
                                ><?php echo $category['title']; ?></a
                            >
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                            <!-- Subscribue Section -->
                            <div class="card mt-4">
                    <div class="card-body">
                        <p class="fw-bold fs-6">عضویت در خبرنامه</p>

                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label"
                                    >نام</label
                                >
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                />
                            </div>
                            <div class="mb-3">
                                <label class="form-label"
                                    >ایمیل</label
                                >
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                />
                            </div>
                            <div class="d-grid gap-2">
                                <button
                                    type="submit"
                                    name="sub"
                                    class="btn btn-secondary"
                                >
                                    ارسال
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                            <!-- About Section -->
                            <div class="card mt-4">
                                <div class="card-body">
                                    <p class="fw-bold fs-6">درباره ما</p>
                                    <p class="text-justify">
                                        لورم ایپسوم متن ساختگی با تولید سادگی
                                        نامفهوم از صنعت چاپ و با استفاده از
                                        طراحان گرافیک است. چاپگرها و متون بلکه
                                        روزنامه و مجله در ستون و سطرآنچنان که
                                        لازم است و برای شرایط فعلی تکنولوژی مورد
                                        نیاز و کاربردهای متنوع با هدف بهبود
                                        ابزارهای کاربردی می باشد.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <!-- Footer -->
            <footer class="text-center pt-4 my-md-5 pt-md-5 border-top">
                <div class="row flex-column">
                    <div>
                        <p class="">
                            کلیه حقوق محتوا این سایت متعلق به وب سایت weblog
                            میباشد
                        </p>
                    </div>
                    <div>
                        <a href="#"
                            ><i
                                class="bi bi-telegram fs-3 text-secondary ms-2"
                            ></i
                        ></a>
                        <a href="#"
                            ><i
                                class="bi bi-whatsapp fs-3 text-secondary ms-2"
                            ></i
                        ></a>
                        <a href="#"
                            ><i class="bi bi-instagram fs-3 text-secondary"></i
                        ></a>
                    </div>
                </div>
            </footer>
        </div>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
