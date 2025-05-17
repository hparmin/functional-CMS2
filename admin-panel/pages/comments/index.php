<?php
include_once "../../include/layout/header.php";

// receive last 5 comments information from db:
$query = $db->query("SELECT * FROM comments ORDER BY id DESC");
$comments = $query->fetchAll(PDO::FETCH_OBJ);
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
                <h1 class="fs-3 fw-bold">کامنت ها</h1>
            </div>
            <?php
            // if recently approved a comment:
            if (isset($_GET['comment-approve'])):
                $approved_comment = $_GET['comment-approve'];
            ?>
                <div class="text-success">
                    کامنت شماره <?php echo $approved_comment; ?> تایید شد.
                </div>
            <?php endif; ?>

            <?php
            // if recently deleted a comment:
            if (isset($_GET['deleted-comment'])):
                $deleted_comment = $_GET['deleted-comment'];
            ?>
                <div class="text-danger">
                    کامنت شماره <?php echo $deleted_comment; ?> حذف شد.
                </div>
            <?php endif; ?>

            <!-- Comments -->
            <div class="mt-4">
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
                                            <a href="/functional2/admin-panel/index.php?entity=comment&action=approve&reback=comments-approve&id=<?php echo $comment->id; ?>" class="btn btn-sm btn-outline-info">در انتظار تایید</a>
                                        <?php endif; ?>
                                        <a
                                            href="/functional2/admin-panel/index.php?entity=comment&action=delete&reback=comments-delete&id=<?php echo $comment->id; ?>"
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

<?php
include_once "../../include/layout/footer.php";
?>