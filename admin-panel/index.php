<?php
include_once "./include/layout/header.php";

$query = $db->query("SELECT * FROM posts ORDER BY id DESC LIMIT 5");
$posts = $query->fetchAll(PDO::FETCH_OBJ);

$query = $db->query("SELECT * FROM comments ORDER BY id DESC LIMIT 5");
$comments = $query->fetchAll(PDO::FETCH_OBJ);

$query = $db->query("SELECT * FROM categories ORDER BY id DESC");
$categories = $query->fetchAll(PDO::FETCH_OBJ);

?>

<!-- <pre style="direction: ltr;">
<?php // var_dump($posts); 
?>
</pre> -->


<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Section -->
        <?php include_once "./include/layout/sidebar.php"; ?>

        <!-- Main Section -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="fs-3 fw-bold">داشبورد</h1>
            </div>

            <!-- Recently Posts -->
            <div class="mt-4">
                <h4 class="text-secondary fw-bold">مقالات اخیر</h4>
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
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <th><?php echo $post->id; ?></th>
                                    <td><?php echo $post->title; ?></td>
                                    <td><?php echo $post->author; ?></td>
                                    <td>
                                        <a
                                            href="#"
                                            class="btn btn-sm btn-outline-dark">ویرایش</a>
                                        <a
                                            href="#"
                                            class="btn btn-sm btn-outline-danger">حذف</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recently Comments -->
            <div class="mt-4">
                <h4 class="text-secondary fw-bold">کامنت های اخیر</h4>
                <div class="table-responsive small">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>نام</th>
                                <th>متن کامنت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($comments as $comment): ?>
                            <tr>
                                <th><?php echo $comment -> id; ?></th>
                                <td><?php echo $comment->name; ?></td>
                                <td>
                                    <?php echo $comment->comment; ?>
                                </td>
                                <td>
                                    <a
                                        href="#"
                                        class="btn btn-sm btn-outline-dark disabled">تایید شده</a>
                                    <a
                                        href="#"
                                        class="btn btn-sm btn-outline-danger">حذف</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Categories -->
            <div class="mt-4">
                <h4 class="text-secondary fw-bold">دسته بندی</h4>
                <div class="table-responsive small">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>عنوان</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($categories as $category): ?>
                            <tr>
                                <th><?php echo $category -> id; ?></th>
                                <td><?php echo $category -> title; ?></td>
                                <td>
                                    <a
                                        href="#"
                                        class="btn btn-sm btn-outline-dark">ویرایش</a>
                                    <a
                                        href="#"
                                        class="btn btn-sm btn-outline-danger">حذف</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
<?php include_once "./include/layout/footer.php"; ?>