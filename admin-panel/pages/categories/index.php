<?php
include_once "../../include/layout/header.php";

$query = $db->query("SELECT * FROM categories ORDER BY id DESC");
$categories = $query->fetchAll(PDO::FETCH_OBJ);
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
                <h1 class="fs-3 fw-bold">دسته بندی ها</h1>

                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="./create.php" class="btn btn-sm btn-dark">
                        ایجاد دسته بندی
                    </a>
                </div>
            </div>
            
            
            <?php
            // if recently deleted category:
            if (isset($_GET['category-delete'])):
                $deleted_id = $_GET['category-delete'];
            ?>
                <div class="text-success">
                    دسته بندی با آیدی <?php echo $deleted_id; ?> حذف شد.
                </div>
            <?php endif; ?>
            <!-- Categories -->
            <div class="mt-4">
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
                                            href="./edit.php?id=<?php echo $category->id; ?>"
                                            class="btn btn-sm btn-outline-dark">ویرایش</a>
                                        <a
                                            href="/functional2/admin-panel/index.php?entity=category&action=delete&reback=categories&id=<?php echo $category->id; ?>"
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