<?php
include_once "../../include/layout/header.php";

if (isset($_POST['submit'])) {
    $titleerror = "";
    if (isset($_POST['title']) && !empty($_POST['title'])) {
        $title = $_POST['title'];

        $query = $db->prepare("INSERT INTO categories (title) VALUES (:title) ");
        $query->execute(['title' => $title]);
    } else {
        $titleerror = " لطفا عنوان را وارد کنید. ";
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
                <h1 class="fs-3 fw-bold">ایجاد دسته بندی</h1>
            </div>

            <!-- Posts -->
            <div class="mt-4">
                <form class="row g-4" method="post">
                    <div class="text-danger">
                        <?php if (!empty($titleerror)) {
                            echo $titleerror;
                        } ?>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">عنوان دسته بندی</label>
                        <input type="text" name="title" class="form-control" />
                    </div>

                    <div class="col-12">
                        <button type="submit" name="submit" class="btn btn-dark">
                            ایجاد
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