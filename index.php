<?php include "config.php";?>
<?php include "layout/header.php"; ?>
<?php
    $sql = "SELECT * FROM `posts_slider`";
    $slider = $conn->query($sql);
?>
            <main>
                <!-- Slider Section -->
                <section>
                    <div id="carousel" class="carousel slide">
                        <div class="carousel-indicators">
                            <button
                                type="button"
                                data-bs-target="#carousel"
                                data-bs-slide-to="0"
                                class="active"
                            ></button>
                            <button
                                type="button"
                                data-bs-target="#carousel"
                                data-bs-slide-to="1"
                            ></button>
                            <button
                                type="button"
                                data-bs-target="#carousel"
                                data-bs-slide-to="2"
                            ></button>
                        </div>
                        <div class="carousel-inner rounded">
                            <?php foreach ($slider as $sld):
                                    $id = $sld['post_id'];
                                    $sql = "SELECT * FROM `posts` WHERE `id` = $id";
                                    $post = $conn->query($sql);
                                    $pst = $post->fetch();
                            ?>
                            <div class="carousel-item overlay carousel-height <?=($sld['active'])? 'active' : '' ?>">
                                <img
                                    src="./assets/images/<?php echo $pst['image'];?>"
                                    class="d-block w-100"
                                    alt="post-image"
                                />
                                <div class="carousel-caption d-none d-md-block">
                                    <h5><?=$pst['title']; ?></h5>
                                    <p>
                                    <?=substr($pst['body'],0,150),'...'; ?>
                                    </p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#carousel"
                            data-bs-slide="prev"
                        >
                            <span class="carousel-control-prev-icon"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button
                            class="carousel-control-next"
                            type="button"
                            data-bs-target="#carousel"
                            data-bs-slide="next"
                        >
                            <span class="carousel-control-next-icon"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </section>

                <!-- Content Section -->
                <section class="mt-4">
                    <div class="row">
                        <!-- Posts Content -->
                        <div class="col-lg-8">
                            <div class="row g-3">
                            <?php 
                            if(isset($_GET['catid'])){
                                $result = $conn->prepare("SELECT * FROM `posts` WHERE `category_id` = :id ORDER BY id DESC");
                                $result->execute(['id'=>$_GET['catid']]);
                            }else{
                                $sql_posts = "SELECT * FROM `posts` ORDER BY `id` DESC";
                                $result = $conn->query($sql_posts);
                            }

                                if($result->rowCount()>0):
                                    foreach($result as $rows):
                                    $catid = $rows['category_id'];
                                    $sql_cat = "SELECT * FROM `categories` WHERE `id` = $catid";
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
                                                        <?= $catresult['title']; ?>
                                                        </span
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
                                                    href="single.php?id=<?=$rows['id']?>"
                                                    class="btn btn-sm btn-dark"
                                                    >مشاهده</a
                                                >

                                                <p class="fs-7 mb-0">
                                                    نویسنده : <?= $rows['author']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                               
                                <?php
                                else:
                                    echo"<span style color:'red'> Error </span>!";
                             endif; ?>
                            </div>
                        </div>

                        <!-- Sidebar Section -->
                        <?php include "layout/sidebar.php"; ?>
                    </div>
                </section>
            </main>

            <!-- Footer Section -->
            <?php include "layout/footer.php"; ?>