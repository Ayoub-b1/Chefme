<?php
include '../functions/db.php';
include '../functions/repetead.php';
session_start();

$conn = db_connect();

$token = isset($_GET['token']) ? htmlspecialchars($_GET['token']) : '';

if (!isset($_SESSION['email']) || empty(trim($_SESSION['email']))) {
    header('location:../signin');
    exit;
}
if (!isset($_SESSION['admin_token']) || empty($_SESSION['admin_token'])) {
    header('location:../index');
    exit;
} else {
    $token_hash = hash('sha256', $_SESSION['admin_token']);

    if ($token_hash !== $token) {

        header('location:../index');
        exit;
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    <?= csslinks2() ?>
    <?= css_caroussel2() ?>

</head>

<body class="back">
    <header class="height-10">
        <nav class="navbar navbar-expand-lg bg-transparent h-100">
            <div class="container">
                <div class="row justify-content-between w-100">
                    <div class="col-lg-2 d-flex align-items-center justify-content-between  ">

                        <a class="navbar-brand" href="./index"><img src="./assets/uploads/logo/logov2.webp" class="img-fluid logo" alt=""></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="col-lg-10 ">

                        <div class="collapse z-3 text-lg-start text-center  justify-content-end gap-5 navbar-collapse" id="nav">
                            <ul class="navbar-nav  my-2 my-lg-0 fw-bold align-items-center gap-5 ">
                                <li class="nav-item">
                                    <a aria-label="home" class="nav-link active" href="./?token=<?php echo $token_hash ?>">Content</a>
                                </li>
                                <li class="nav-item">
                                    <a aria-label="recipes" class="nav-link " aria-current="page" href="./recipes?token=<?php echo $token_hash ?>">Recipes</a>
                                </li>
                                <li class="nav-item">
                                    <a aria-label="Blogs" class="nav-link  " href="./Posts_control?token=<?php echo $token_hash ?>">Posts control</a>
                                </li>

                                <li class="nav-item">
                                    <a aria-label="Profile" class="nav-link" href="./User_control?token=<?php echo $token_hash ?>">User Control</a>
                                </li>
                                <li class="nav-item">
                                    <a aria-label="Profile" class="nav-link" href="../">User View</a>
                                </li>

                                <li class="nav-item">
                                    <button id="logout" class="btn mybtn py-2 px-4">Logout</button>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="delete_modalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered w-fit">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
                    <button type="button" class="btn-close" id="modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="form-delete">
                    <p>Are you sure you want to delete this?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input value="Delete" type="submit" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="delete_modalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered w-fit">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="to_update_name">Update </h1>
                    <button type="button" class="btn-close" id="update_modal_modal_close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="form-update">
                    <input type="text" class="form-control w-100 my-3" id="to_update_place" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input value="Update" type="submit" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <section class="min-vh-100">
        <div class="container">
        <div class="row my-4 ">
                <div class="col-lg-6 col-12 my-4 my-lg-0 " data-aos="fade-up" data-aos-duration="1200">
                    <h2 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence ">Categorie</h2>
                    <form action="" method="post" id="add_categories" class="d-flex">
                        <input type="text" name="category" id="category" class="form-control w-100 my-3">
                        <button type="submit" class="bg-transparent border-0 "><i class="bi bi-plus-circle-fill text-danger  fs-4"></i></button>
                    </form>
                    <table class="table  bg-transparent ">
                        <tr>
                            <tbody id="categories"></tbody>

                        </tr>
                    </table>
                </div>
                <div class="col-lg-6 col-12 my-4 my-lg-0 " data-aos="fade-up" data-aos-duration="1200">
                    <h2 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence ">Cuisine</h2>
                    <form action="" method="post" id="add_Cuisine" class="d-flex">
                        <input type="text" name="Cuisine" id="Cuisine" class="form-control w-100 my-3">
                        <button type="submit" class="bg-transparent border-0 "><i class="bi bi-plus-circle-fill text-danger  fs-4"></i></button>
                    </form>
                    <table class="table bg-transparent ">
                        <tr>
                            <tbody id="cuisines"></tbody>

                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <section class="my-5  ">
        <div class="container">
            

            <div class="d-flex carousel-nav" data-aos="zoom-in-up" data-aos-delay="200">
                <a href="#" class="col position-relative  active text-decoration-none " data-aos="zoom-in-up" data-aos-delay="200">FAQ</a>
                <a href="#" class="col position-relative  text-decoration-none " data-aos="zoom-in-up" data-aos-delay="400">Privacy</a>
            </div>


            <div data-aos="zoom-in-up" data-aos-delay="200" class="owl-carousel owl-1">

                <div data-aos="zoom-in-up" data-aos-delay="200" class="media-29101 gap-5 mx-auto ">
                    <form action="" method="post" id="faq_form">
                        <div class="row">






                    </form>

                </div>

            </div>
            <div>



                <div class="media-29101 d-md-flex w-100">

                    <div class="text w-100 ">
                        <a class="category d-block mb-4" href="#">Privacy & Policy</a>
                        <form action="" method="post" id="privacy_form" class="d-flex flex-column gap-5 align-items-center  justify-content-center w-100   ">
                            <textarea rows="20" name="privacy_textarea" id="privacy_textarea" class="my-inp w-100 py-3 mx-5  mb-3"></textarea>
                            <input type="submit" value="Update" id="updatebtn" class="btn btn-danger w-50 ms-auto ">
                        </form>
                    </div>
                </div> <!-- .item -->



            </div>
        </div>
    </section>
    <?php footer_page() ?>
</body>
<script src="../assets/js/admin_index.js"></script>
<?= jslinks3() ?>
<?= caroussel2() ?>

</html>