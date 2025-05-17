<?php
include_once "include/layout/header.php";
?>
<main>
    <!-- Slider Section -->
    <?php
    include_once "include/layout/slider.php";
    ?>

    <!-- Content Section -->
    <section class="mt-4">
        <div class="row">
            <!-- Posts Content -->
            <div class="col-lg-8">
                <div class="row g-3">
                    <?php
                    if (isset($_GET['category'])) {
                        // if category is set:
                        $category_id = $_GET['category'];
                        $query = $db->prepare("SELECT * FROM posts WHERE category_id = $category_id ORDER BY id DESC");
                        $query->execute();
                        $posts = $query->fetchAll(PDO::FETCH_OBJ);
                    } else {
                        // if category is not set show all posts:
                        $query = $db->query("SELECT * FROM posts ORDER BY id DESC");
                        $posts = $query->fetchAll(PDO::FETCH_OBJ);
                    }
                    if ($posts):

                        foreach ($posts as $post):
                            // if(isset($category_id) && $category_id != $post->category_id){
                            //     continue;
                            // }
                    ?>
                            <div class="col-sm-6">
                                <div class="card">
                                    <img
                                        src="<?php echo UPLOADED_PIC_PATH . $post->image; ?>"
                                        class="card-img-top"
                                        alt="post-image" />
                                    <div class="card-body">
                                        <div
                                            class="d-flex justify-content-between">
                                            <h5 class="card-title fw-bold">
                                                <?php echo $post->title; ?>
                                            </h5>
                                            <div>
                                                <span
                                                    class="badge text-bg-secondary"><?php
                                                                                    $query = $db->query("SELECT * FROM categories WHERE id=$post->category_id");
                                                                                    $cat = $query->fetch(PDO::FETCH_OBJ);
                                                                                    echo $cat->title;
                                                                                    ?></span>
                                            </div>
                                        </div>
                                        <p
                                            class="card-text text-secondary pt-3">
                                            <?php
                                            echo substr($post->body, 0, 500) . " . . . ";
                                            ?>
                                        </p>
                                        <div
                                            class="d-flex justify-content-between align-items-center">
                                            <a
                                                href="single.php?id=<?php echo $post->id; ?>"
                                                class="btn btn-sm btn-dark">مشاهده</a>

                                            <p class="fs-7 mb-0">
                                                نویسنده : <?php echo $post->author; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sidebar Section -->
            <?php
            include_once "include/layout/sidebar.php";
            ?>


        </div>
    </section>
</main>

<!-- Footer Section -->
<?php
include_once "./include/layout/footer.php";
?>