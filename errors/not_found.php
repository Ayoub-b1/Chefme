<?php
include '../functions/db.php';
include '../functions/repetead.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <?= csslinks2() ?>
</head>

<body class="blob">
   
    <section class="height-90 d-flex  align-items-center flex-column justify-content-center  rand">
        <div class="container h-100 d-flex  align-items-center">
            <div class="row w-100">
                <div class="col-lg-6 col-12 mx-auto ">
                    <div class="d-flex flex-column align-items-center justify-content-center h-100">
                        <h1 class="text-capitalize fw-bold ff-ubunto fs-my-1 text-center balence ">Page Not Found</h1>
                        <img src="../assets/uploads/view/404.svg" class="img-fluid  w-100 px-5" width="500" height="500"
                            srcset=""
                            loading="lazy"
                            decoding="async"
                            data-nimg="responsive"
                            data-n-image-id="04482166-9653-4394-937d-844360778940"alt="error">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php footer_page2(); ?>
</body>
<?= jslinks2() ?>
<script src="./assets/js/verification.js"></script>

</html>