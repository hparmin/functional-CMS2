<?php

$query = $db -> prepare("SELECT * FROM posts_slider INNER JOIN posts WHERE
                                                posts_slider.post_id = posts.id");
$query -> execute();
$sliders = $query ->fetchAll(PDO::FETCH_OBJ);;

//echo "<pre style='direction: ltr;'>";
//print_r($res);
//echo "</pre>";

//foreach ($res as $re){
//    echo $re -> author . "<br>";
//    echo  "<img src='".PICTURES_PATH . $re -> image . "'/>";
//}
?>

<section>
    <div id="carousel" class="carousel slide">
        <div class="carousel-indicators">
            <button
                type="button"
                data-bs-target="#carousel"
                data-bs-slide-to="0"
                class="active"
            ></button>
            <button
                type="button"
                data-bs-target="#carousel"
                data-bs-slide-to="1"
            ></button>
            <button
                type="button"
                data-bs-target="#carousel"
                data-bs-slide-to="2"
            ></button>
        </div>
        <div class="carousel-inner rounded">
            <?php if ($sliders): ?>
                <?php foreach ($sliders as $slider): ?>
                <div class="carousel-item overlay carousel-height <?php if($slider->active == 1){ echo 'active'; }?>" >
                    <img
                        src="<?php echo PICTURES_PATH.$slider -> image ; ?>"
                        class="d-block w-100"
                        alt="post-image"
                    />
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?php echo $slider -> title ;?></h5>
                        <p>
                            <?php echo substr($slider -> body,0 , 200)." . . . " ; ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#carousel"
            data-bs-slide="prev"
        >
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#carousel"
            data-bs-slide="next"
        >
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>