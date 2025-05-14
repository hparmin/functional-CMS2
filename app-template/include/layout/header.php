<?php

include_once "./include/config.php";

include_once "./include/db.php";

$query = $db->query("SELECT * FROM categories");
$categories = $query -> fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Armin's Functional CMS</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
        <link rel="stylesheet" href="./assets/css/style.css" />
    </head>

    <body>
        <div class="container py-3">
            <header
                class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom"
            >
                <a
                    href="index.php"
                    class="fs-4 fw-medium link-body-emphasis text-decoration-none"
                >
                    webprog.io
                </a>

                <nav class="d-inline-flex mt-2 mt-md-0 me-md-auto">
                    <?php if ($categories): 
                        if(isset($_GET['category'])){
                            $category_id = $_GET['category'];
                        }
                        foreach($categories as $category): ?>
                        <a
                            class="<?php if(isset($category_id) && $category_id == $category -> id){echo " fw-bold ";} ?> me-3 py-2 link-body-emphasis text-decoration-none"
                            href="index.php?category=<?php echo $category->id; ?>
                            "><?php echo $category -> title; ?></a
                        ><?php endforeach; ?>
                    <?php endif; ?>
                </nav>
            </header>
