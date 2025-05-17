<?php
include_once "./include/layout/header.php";

// receive last 5 posts information from db:
$query = $db->query("SELECT * FROM posts ORDER BY id DESC LIMIT 5");
$posts = $query->fetchAll(PDO::FETCH_OBJ);

// receive last 5 comments information from db:
$query = $db->query("SELECT * FROM comments ORDER BY id DESC LIMIT 5");
$comments = $query->fetchAll(PDO::FETCH_OBJ);

// receive categories information from db:
$query = $db->query("SELECT * FROM categories ORDER BY id DESC");
$categories = $query->fetchAll(PDO::FETCH_OBJ);


// check url query for actions:
if (isset($_GET['entity']) && isset($_GET['action']) && isset($_GET['id'])) {
    // check if it's post:
    if ($_GET['entity'] == 'post') {
        //check the action (DELETE):
        if ($_GET['action'] == 'delete') {
            $id = $_GET['id'];
            $query = $db->prepare("DELETE FROM posts WHERE id = :id");
            $query->execute(['id' => $id]);
            if ($_GET['reback'] == "posts") {
                header("location:/functional2/admin-panel/pages/posts/index.php?post-delete=$id");
            } else {
                header("location:index.php?post-delete=$id");
            }
        }
    }



    // check if it's comment:
    if ($_GET['entity'] == 'comment') {
        //check the action (DELETE):
        if ($_GET['action'] == 'delete') {
            $id = $_GET['id'];
            $query = $db->prepare("DELETE FROM comments WHERE id = :id");
            $query->execute(['id' => $id]);


            if(($_GET['reback'] == "comments-delete")){
                header("location:/functional2/admin-panel/pages/comments/index.php?deleted-comment=$id");
            }else{
                header("location:index.php?comment-delete=$id");
            }
            
        }

        //check the action (APPROVE):
        if ($_GET['action'] == 'approve') {
            $id = $_GET['id'];
            $query = $db->prepare("UPDATE comments SET status = '1' WHERE id = :id");
            $query->execute(['id' => $id]);



            if ($_GET['reback'] == "comments-approve") {
                header("location:/functional2/admin-panel/pages/comments/index.php?comment-approve=$id");
            }else {
                header("location:index.php?comment-approve=$id");
            }
        }
    }


    // check if it's category:
    if ($_GET['entity'] == 'category') {
        // check the action:
        if ($_GET['action'] == 'delete') {
            $id = $_GET['id'];
            $query = $db->prepare("DELETE FROM categories WHERE id = :id");
            $query->execute(['id' => $id]);

            if ($_GET['reback'] == "categories") {
                header("location:/functional2/admin-panel/pages/categories/index.php?category-delete=$id");
            } else {
                header("location:index.php?category-delete=$id");
            }
        }
    }
}







?>



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
                <div class="text-success">
                    <?php
                    if (isset($_GET['post-delete'])) {
                        $delete_post_id = $_GET['post-delete'];
                        echo "پست شماره $delete_post_id با موفقیت حذف شد.";
                    }
                    ?>
                </div>
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
                                        <a href="/functional2/admin-panel/pages/posts/edit.php?id=<?php echo $post->id; ?>" class="btn btn-sm btn-outline-dark">ویرایش</a>
                                        <a href="index.php?entity=post&action=delete&id=<?php echo $post->id; ?>"
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
                <div class="text-success">
                    <?php
                    if (isset($_GET['comment-delete'])) {
                        $delete_comment_id = $_GET['comment-delete'];
                        echo "کامنت شماره $delete_comment_id با موفقیت حذف شد.";
                    }
                    if (isset($_GET['comment-approve'])) {
                        $approve_comment_id = $_GET['comment-approve'];
                        echo "کامنت شماره $approve_comment_id با موفقیت تایید شد.";
                    }
                    ?>
                </div>
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
                            <?php foreach ($comments as $comment): ?>
                                <tr>
                                    <th><?php echo $comment->id; ?></th>
                                    <td><?php echo $comment->name; ?></td>
                                    <td>
                                        <?php echo $comment->comment; ?>
                                    </td>
                                    <td>
                                        <?php if ($comment->status): ?>
                                            <a href="#" class="btn btn-sm btn-outline-dark disabled">تایید شده</a>
                                        <?php else: ?>
                                            <a href="index.php?entity=comment&action=approve&id=<?php echo $comment->id; ?>" class="btn btn-sm btn-outline-info">در انتظار تایید</a>
                                        <?php endif; ?>
                                        <a
                                            href="index.php?entity=comment&action=delete&id=<?php echo $comment->id; ?>"
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
                <div class="text-success">
                    <?php
                    if (isset($_GET['category-delete'])) {
                        $delete_category_id = $_GET['category-delete'];
                        echo "دسته بندی شماره $delete_category_id با موفقیت حذف شد.";
                    }
                    ?>
                </div>
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
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <th><?php echo $category->id; ?></th>
                                    <td><?php echo $category->title; ?></td>
                                    <td>
                                        <a
                                            href="#"
                                            class="btn btn-sm btn-outline-dark">ویرایش</a>
                                        <a
                                            href="index.php?entity=category&action=delete&id=<?php echo $category->id; ?>"
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