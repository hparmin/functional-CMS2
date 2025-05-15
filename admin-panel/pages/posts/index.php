<?php
include_once "../../include/layout/header.php";
?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Section -->
        <?php
        include_once "../../include/layout/sidebar.php";
        ?>

        <!-- Main Section -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="fs-3 fw-bold">مقالات</h1>

                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="./create.php" class="btn btn-sm btn-dark">
                        ایجاد مقاله
                    </a>
                </div>

            </div>

            <?php
            // if recently deleted post:
            if (isset($_GET['post-delete'])):
                $deleted_id = $_GET['post-delete'];
            ?>
                <div class="text-success">
                    مقاله شماره <?php echo $deleted_id; ?> حذف شد.
                </div>
            <?php endif; ?>

            <!-- Posts -->
            <div class="mt-4">
                <div class="table-responsive small">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>عنوان</th>
                                <th>نویسنده</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = $db->query("SELECT * FROM posts ORDER BY id DESC");
                            $posts = $query->fetchAll(PDO::FETCH_OBJ);
                            if ($posts):
                                foreach ($posts as $post):
                            ?>
                                    <tr>
                                        <th><?php echo $post->id; ?></th>
                                        <td><?php echo $post->title; ?></td>
                                        <td><?php echo $post->author; ?></td>
                                        <td>
                                            <a
                                                href="./edit.html"
                                                class="btn btn-sm btn-outline-dark">ویرایش</a>
                                            <a
                                                href="/functional2/admin-panel/index.php?entity=post&action=delete&reback=posts&id=<?php echo $post->id; ?>"
                                                class="btn btn-sm btn-outline-danger">حذف</a>
                                        </td>
                                    </tr>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
<?php
include_once "../../include/layout/footer.php";
?>