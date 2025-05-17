<?php
include_once "../../include/layout/header.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $query = $db->prepare("SELECT * FROM categories WHERE id = :id");
    $query->execute(["id" => $id]);
    $category = $query->fetch(PDO::FETCH_OBJ);

    if (!$category) {
        die();
    }
}

if (isset($_POST['update'])) {
    if (isset($_POST['title']) && !empty($_POST['title'])) {
        $title = $_POST['title'];

        $query = $db->prepare("UPDATE categories 
            SET title = :title
            WHERE id = :id");

        $query->execute([
            ':title' => $title,
            ':id' => $id
        ]);
        //header("Refresh:0");
        header("location:edit.php?id=$id");
    }
}
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
                <h1 class="fs-3 fw-bold">ویرایش دسته بندی</h1>
            </div>

            <!-- Posts -->
            <div class="mt-4">
                <form class="row g-4" method="post">
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">عنوان دسته بندی</label>
                        <input type="text" name="title" class="form-control" value="<?php echo $category->title; ?>" />
                    </div>

                    <div class="col-12">
                        <button type="submit" name="update" class="btn btn-dark">
                            ویرایش
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<?php
include_once "../../include/layout/footer.php";
?>