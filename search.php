<?php include "config.php";?>
<?php include "layout/header.php"; ?>

<?php
if(isset($_GET['txtsearch'])) {
    $search = $_GET['txtsearch'];
    $posts = $conn->prepare("SELECT * FROM posts WHERE title LIKE :title");
    $posts->execute(['title' => "%$search%"]);
    // $x = $posts ->fetchAll();
    // print_r($x);
}
?>
            <main>
                <!-- Content Section -->
                <section class="mt-4">
                    <div class="row">
                        <!-- Posts Content -->
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col">
                                    <div class="alert alert-secondary">
                                        پست های مرتبط با کلمه [ <?= $_GET['txtsearch'] ?> ]
                                    </div>


                                </div>
                            </div>
                            <div class="row g-3">
                            <?php 
                                        if($posts->rowCount()>0){
                                            foreach($posts as $rows){
                                                $catid = $rows['category_id'];
                                                $sql_cat = "SELECT * FROM categories WHERE id = $catid";
                                                $catresult = $conn->query($sql_cat)->fetch();         
                            ?>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <img
                                            src="./assets/images/<?= $rows['image']; ?>"
                                            class="card-img-top"
                                            alt="post-image"
                                        />
                                        <div class="card-body">
                                            <div
                                                class="d-flex justify-content-between"
                                            >
                                                <h5 class="card-title fw-bold">
                                                <?= $rows['title']; ?>
                                                </h5>
                                                <div>
                                                    <span
                                                        class="badge text-bg-secondary">
                                                        <?= $catresult['title']; ?></span
                                                    >
                                                </div>
                                            </div>
                                            <p
                                                class="card-text text-secondary pt-3"
                                            >
                                            <?=substr($rows['body'],0,200) , '...' ; ?>
                                            </p>
                                            <div
                                                class="d-flex justify-content-between align-items-center"
                                            >
                                                <a
                                                    href="single.php"
                                                    class="btn btn-sm btn-dark"
                                                    >مشاهده</a
                                                >

                                                <p class="fs-7 mb-0">
                                                    نویسنده : نویسنده : <?= $rows['author']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                
                                </div>
                                <?php } ?>
                                <?php }else{
                                    echo"پیدا نشد";
                                } ?>
                                
                            </div>
                        </div>

                        <!-- Sidebar Section -->
                        <?php include "layout/sidebar.php"; ?>
                    </div>
                </section>
            </main>

<?php include "layout/footer.php"; ?>