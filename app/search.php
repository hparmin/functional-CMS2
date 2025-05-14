<?php
include_once "include/layout/header.php";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $_GET['search'];
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
                        <?php
                        if (isset($search_query) && !empty($search_query)) :
                        ?>
                            <div class="alert alert-secondary">
                                <?php
                                echo ' پست های مرتبط با کلمه ' . $search_query;
                                ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-danger">
                                مقاله مورد نظر پیدا نشد !!!!
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row g-3">
                    <?php
                    if (isset($search_query) && !empty($search_query)) :

                        $query = $db->prepare("SELECT * FROM posts WHERE body LIKE :search OR title LIKE :search;");
                        $query->execute(['search' => "%$search_query%"]);
                        // $query = $db->prepare("SELECT * FROM posts WHERE body LIKE '%$search_query%' OR title LIKE '%$search_query%';");
                        // $query->execute();

                        $search_res = $query->fetchALL(PDO::FETCH_OBJ);
                        if ($search_res):
                            foreach ($search_res as $post):
                    ?>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <img
                                            src="<?php echo PICTURES_PATH . $post->image; ?>"
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
                                                        class="badge text-bg-secondary">طبیعت</span>
                                                </div>
                                            </div>
                                            <p
                                                class="card-text text-secondary pt-3">
                                                <?php echo substr($post->body, 0, 500) . " . . . "; ?>
                                            </p>
                                            <div
                                                class="d-flex justify-content-between align-items-center">
                                                <a
                                                    href="single.html"
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
<footer class="text-center pt-4 my-md-5 pt-md-5 border-top">
    <div class="row flex-column">
        <div>
            <p class="">
                کلیه حقوق محتوا این سایت متعلق به وب سایت webprog.io
                میباشد
            </p>
        </div>
        <div>
            <a href="#"><i
                    class="bi bi-telegram fs-3 text-secondary ms-2"></i></a>
            <a href="#"><i
                    class="bi bi-whatsapp fs-3 text-secondary ms-2"></i></a>
            <a href="#"><i class="bi bi-instagram fs-3 text-secondary"></i></a>
        </div>
    </div>
</footer>
</div>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
</body>

</html>