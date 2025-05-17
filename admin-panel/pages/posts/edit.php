<?php
include_once "../../include/layout/header.php";

$query = $db->query("SELECT * FROM categories");
$categories = $query->fetchAll(PDO::FETCH_OBJ);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = $db->prepare("SELECT * FROM posts WHERE ID = :id");
    $query->execute(["id" => $id]);
    $post = $query->fetch(PDO::FETCH_OBJ);

    if (!$post) {
        die();
    }
}

if (isset($_POST['addPost'])) {

    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $title_error = "";
    $author_error = "";
    $category_id_error = "";
    $body_error = "";
    $file_erro = "";

    if (empty(trim($_POST['title']))) {
        $title_error = " لطفا عنوان پست را مشخص کنید. ";
    }
    if (empty(trim($_POST['author']))) {
        $author_error = " لطفا نویسنده را مشخص کنید. ";
    }
    if (empty(trim($_POST['category_id'])) || !isset($_POST['category_id'])) {
        $category_id_error = " لطفا دسته بندی را مشخص کنید. ";
    }
    if (empty(trim($_POST['body']))) {
        $body_error = " متن خالی است.";
    }
    if (empty($_FILES['image']['tmp_name'])) {
        $file_erro = " لطفا تصویر را بارگزاری کنید. ";
    }

    if (/* !empty($_FILES['image']['tmp_name']) && */!empty(trim($_POST['body'])) && !empty(trim($_POST['author'])) && !empty(trim($_POST['title'])) && !empty(trim($_POST['category_id']))) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $category_id = $_POST['category_id'];
        $body = $_POST['body'];

        // $img_name = time() . "-" . $_FILES['image']['name'];
        // $tmp_name = $_FILES['image']['tmp_name'];
        // if (move_uploaded_file($tmp_name, "../../../uploads/posts/$img_name")) {


        if (!empty($_FILES['image']['tmp_name'])) {
            $img_name = time() . "-" . $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];
            if (move_uploaded_file($tmp_name, "../../../uploads/posts/$img_name")) {
                $query = $db->prepare("UPDATE posts 
                      SET title = :title, 
                          body = :body, 
                          category_id = :category_id, 
                          author = :author, 
                          image = :image
                      WHERE id = :id");

                $query->execute([
                    ':title' => $title,
                    ':body' => $body,
                    ':category_id' => $category_id,
                    ':author' => $author,
                    ':id' => $id,
                    ':image' => $img_name
                ]);
            }
        } else {
            $query = $db->prepare("UPDATE posts 
                      SET title = :title, 
                          body = :body, 
                          category_id = :category_id, 
                          author = :author 
                      WHERE id = :id");

            $query->execute([
                ':title' => $title,
                ':body' => $body,
                ':category_id' => $category_id,
                ':author' => $author,
                ':id' => $id
            ]);
        }

        header("location:edit.php?id=$id");
    } else {
        echo "upload error";
    }
}
//}
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
                <h1 class="fs-3 fw-bold">ایجاد مقاله</h1>
            </div>

            <!-- Posts -->
            <div class="mt-4">
                <form class="row g-4" enctype="multipart/form-data" method="post">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="text-danger">
                            <?php if (!empty($title_error)) {
                                echo $title_error;
                            } ?>
                        </div>
                        <label class="form-label">عنوان مقاله</label>
                        <input type="text" name="title" value="<?php echo $post->title; ?>" class="form-control" />
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="text-danger">
                            <?php if (!empty($author_error)) {
                                echo $author_error;
                            } ?>
                        </div>
                        <label class="form-label">نویسنده مقاله</label>
                        <input type="text" name="author" value="<?php echo $post->author; ?>" class="form-control" />
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">

                        <div class="text-danger">
                            <?php if (!empty($category_id_error)) {
                                echo $category_id_error;
                            } ?>
                        </div>
                        <label class="form-label">دسته بندی مقاله</label>
                        <?php if ($categories): ?>
                            <select class="form-select" name="category_id">
                                <option value="">دسته بندی</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category->id; ?>"
                                        <?php if ($post->category_id == $category->id) {
                                            echo "selected";
                                        } ?>><?php echo $category->title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                    <div>
                        <img style="max-width: 10%;" src="<?php echo UPLOADED_PATH . $post->image; ?>">
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <label for="formFile" class="form-label">تصویر مقاله</label>
                        <input class="form-control" name="image" type="file" />
                    </div>

                    <div class="col-12">
                        <div class="text-danger">
                            <?php if (!empty($body_error)) {
                                echo $body_error;
                            } ?>
                        </div>
                        <label for="formFile" class="form-label">متن مقاله</label>
                        <textarea
                            name="body"
                            class="form-control"
                            rows="6"><?php echo $post->body; ?></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="addPost" class="btn btn-dark">
                            بروزرسانی
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