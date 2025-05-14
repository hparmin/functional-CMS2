<?php
include_once "include/layout/header.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = $db -> prepare("SELECT * FROM posts WHERE `id` = :id ");
    $query -> execute(['id' => $id]);
    // $query = $db->query("SELECT * FROM posts WHERE id = $id ");
    // $query->execute();

    $post = $query->fetch(PDO::FETCH_OBJ);
}
?>
<main>
    <!-- Content -->
    <section class="mt-4">
        <div class="row">
            <!-- Posts & Comments Content -->
            <div class="col-lg-8">
                <?php if ($post):
                    // get the category of post from db:
                    $query = $db->query("SELECT * FROM categories WHERE id = $post->category_id");
                    $cat = $query->fetch(PDO::FETCH_OBJ);

                    // get the comments of post from db:
                    $query = $db->query("SELECT * FROM comments WHERE post_id = $post->id AND status = 1");
                    $comments = $query->fetchALL(PDO::FETCH_OBJ);
                ?>
                    <div class="row justify-content-center">
                        <!-- Post Section -->
                        <div class="col">
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
                                                class="badge text-bg-secondary"><?php echo $cat->title; ?></span>
                                        </div>
                                    </div>
                                    <p
                                        class="card-text text-secondary text-justify pt-3">
                                        <?php echo $post->body; ?>
                                    </p>
                                    <div>
                                        <p class="fs-6 mt-5 mb-0">
                                            نویسنده : <?php echo $post->author; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <hr class="mt-4" />

                        <!-- Comment Section -->
                        <div class="col">
                            <!-- Comment Form -->
                            <div class="card">
                                <div class="card-body">
                                    <p class="fw-bold fs-5">
                                        ارسال کامنت
                                    </p>
                                    <?php
                                    $invalidName = '';
                                    $invalidComment = '';
                                    if (isset($_POST['submit'])) {
                                        if (empty($_POST['name'])) {
                                            $invalidName = "لطفا نام خود را وارد کنید. ";
                                        }
                                        if (empty($_POST['comment'])) {
                                            $invalidComment = "لطفا متن کامنت خود را بنویسید. ";
                                        }
                                        if (!empty($_POST['comment']) && !empty($_POST['name'])) {
                                            $name = $_POST['name'];
                                            $comment = $_POST['comment'];

                                            $query = $db->prepare("INSERT INTO comments  (`name`,`comment`,`post_id`) VALUES (:name,:comment,:id)");
                                            $query->execute(['name' => $name, 'comment' => $comment, 'id' => $id]);

                                            $success_comment = " کامنت شما با موفقیت ارسال شد. <br> بعد از تایید ادمین نمایش داده خواهد شد. ";
                                        }
                                    }

                                    ?>
                                    <form method="post">
                                        <div class="mb-3">
                                            <label class="form-label">نام</label>
                                            <div class="form-text text-danger"><?php echo $invalidName ?></div>
                                            <input
                                                name="name"
                                                type="text"
                                                class="form-control" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">متن کامنت</label>
                                            <div class="form-text text-danger"><?php echo $invalidComment ?></div>
                                            <textarea
                                                name="comment"
                                                class="form-control"
                                                rows="3"></textarea>
                                        </div>
                                        <div class="text-success"><?php if (isset($success_comment)) {
                                                                        echo $success_comment;
                                                                    } ?></div>
                                        <button
                                            type="submit"
                                            name="submit"
                                            class="btn btn-dark">
                                            ارسال
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <hr class="mt-4" />
                            <!-- Comment Content -->
                            <p class="fw-bold fs-6">تعداد کامنت : <?php echo count($comments); ?></p>
                            <?php if ($comments): ?>
                                <?php foreach ($comments as $comment): ?>
                                    <div class="card bg-light-subtle mb-3">
                                        <div class="card-body">
                                            <div
                                                class="d-flex align-items-center">
                                                <img
                                                    src="./assets/images/profile.png"
                                                    width="45"
                                                    height="45"
                                                    alt="user-profle" />

                                                <h5
                                                    class="card-title me-2 mb-0">
                                                    <?php echo $comment->name; ?>
                                                </h5>
                                            </div>

                                            <p class="card-text pt-3 pr-3">
                                                <?php echo $comment->comment; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">مقاله مورد نظر یافت نشد. </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar Section -->
            <?php
            include_once "include/layout/sidebar.php";
            ?>
        </div>
    </section>
</main>

<!-- Footer -->
<?php
include_once "./include/layout/footer.php";
?>