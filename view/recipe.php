<?php
include '../functions/db.php';
include '../functions/repetead.php';
session_start();

$conn = db_connect();
if (!isset($_SESSION['email']) || empty(trim($_SESSION['email']))) {
    header('location:../signin');
    exit;
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe</title>
    <?= csslinks2() ?>
</head>

<body class="back">
    <header class="height-10">
        <nav class="navbar navbar-expand-lg bg-transparent h-100">
            <div class="container">
                <div class="row justify-content-between w-100">
                    <div class="col-lg-2 d-flex align-items-center justify-content-between  ">

                        <a class="navbar-brand" href="../index"><img src="../assets/uploads/logo/logov2.webp" class="img-fluid logo" alt=""></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="col-lg-10 ">

                        <div class="collapse z-3 text-lg-start text-center  justify-content-end gap-5 navbar-collapse" id="nav">
                            <ul class="navbar-nav  my-2 my-lg-0 fw-bold align-items-center gap-5 ">
                                <li class="nav-item">
                                    <a class="nav-link " aria-current="page" href="../">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active " href="../recipes">Recipes</a>
                                </li>
                                <li class="nav-item">
                                    <a aria-label="Blogs" class="nav-link" href="../blogs">Blogs</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="../profile">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../about">About us</a>
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
    <section class="height-90 d-flex flex-column align-items-center justify-content-center  ">
        <div class="container mt-lg-0 h-100   ">
            <div class="row w-100  mx-auto">
                <div class="col-12   ">
                    <div class="container-fluid p-0  ">
                        <div class="row mx-auto w-100  bg-white my-5  rounded-5 shadow-lg   h-fit   ">
                            <div class="col-md-12  h-fit position-relative    ">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <a href="../recipes"  class="text-danger text-decoration-none gap-2 d-flex flex-row align-items-center w-fit  pt-5 ps-5  pb-0 "><i class="bi bi-arrow-left"></i>go back</a>
                                        <div class="mt-3 p-5 p-lg-5 pt-lg-3  pt-0">
                                            <figure class='recipe_view rounded-5 border  border-5 border-danger w-100       shadow' id="fig_placeholder">

                                                <img src='' id="img_placeholder" />

                                            </figure>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="d-flex flex-column gap-2 align-items-start justify-content-center mt-5 px-5 p-lg-0  ">
                                            <button class="  bg-transparent  position-absolute border-0  top-0 end-0 m-5 fs-4 text-danger" id="bookmark"><i class="bi bi-bookmark"></i></button>
                                            <h2 id="title_place" class="text-capitalize fw-bold fs-1 text-start balence pt-5  "></h2>
                                            <p id="desc_place" class="text-secondary fw-semibold pe-5 fs-5 text-start balence mt-4  "></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row w-100 mx-auto  ">
                                    <div class="col-lg-4 ">
                                        <div class="d-flex gap-4 gap-lg-3   w-100 flex-column flex-lg-row text-center text-lg-start    my-5">
                                            <div class="d-flex gap-2 flex-lg-column text-start  justify-content-between  text-secondary   align-items-center w-100  ">
                                                <h6 class="mb-0"><i class="bi bi-person-fill me-2 "></i>Creator:</h6>
                                                <h6 class="ms-4 ms-lg-0 mb-0 text-capitalize  " id="creator_place"></h6>
                                            </div>

                                        </div>
                                        <div class="d-flex gap-4 gap-lg-3   w-100 flex-column flex-lg-row text-center text-lg-start    my-5">
                                            <div class="d-flex gap-2 flex-lg-column text-start  justify-content-between  text-secondary   align-items-center w-100  ">
                                                <h6 class="mb-0"><i class="bi bi-hourglass-split me-2 "></i>Published at:</h6>
                                                <h6 class="ms-4 ms-lg-0 mb-0 " id="creation_place"></h6>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-4 gap-lg-3   w-100 flex-column flex-lg-row text-center text-lg-start    my-5">
                                            <div class="d-flex gap-2 flex-lg-column text-start  justify-content-between  text-secondary   align-items-center w-100  ">
                                                <h6 class="mb-0"><i class="bi bi-gear-fill me-2 "></i>Difficulty:</h6>
                                                <h6 class="ms-4 ms-lg-0 mb-0 " id="difficulty_place"></h6>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-4 gap-lg-3   w-100 flex-column flex-lg-row text-center text-lg-start    my-5">
                                            <div class="d-flex gap-2 flex-lg-column text-start  justify-content-between  text-secondary   align-items-center w-100  ">
                                                <h6 class="mb-0"><i class="bi bi-person-fill me-2 "></i>Serving:</h6>
                                                <h6 class="ms-4 ms-lg-0 mb-0 " id="serving_place"></h6>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex gap-4 gap-lg-3   w-100 flex-column flex-lg-row text-center text-lg-start    my-5">
                                            <div class="d-flex gap-2 flex-lg-column text-start  justify-content-between  text-secondary   align-items-center w-100  ">
                                                <h6 class="mb-0 text-center "><i class="bi bi-person-fill me-2 "></i>Calories:</h6>
                                                <h6 class="ms-4 ms-lg-0  mb-0 " id="calories_place"></h6>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-4 gap-lg-3   w-100 flex-column flex-lg-row text-center text-lg-start    my-5">
                                            <div class="d-flex gap-2 flex-lg-column text-start  justify-content-between  text-secondary   align-items-center w-100  ">
                                                <h6 class="mb-0 text-center "><i class="bi bi-flag-fill me-2 "></i>Cuisine:</h6>
                                                <h6 class="ms-4 ms-lg-0  mb-0 " id="cuisine_place"></h6>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-4 gap-lg-3   w-100 flex-column flex-lg-row text-center text-lg-start    my-5">
                                            <div class="d-flex gap-2 flex-lg-column text-start  justify-content-between  text-secondary   align-items-center w-100  ">
                                                <h6 class="mb-0 text-center "><i class="bi bi-tag-fill me-2 "></i>Categorie:</h6>
                                                <h6 class="ms-4 ms-lg-0  mb-0 " id="categorie_place"></h6>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-8 mx-auto ">
                                        <div class="d-flex flex-column gap-2 align-items-start justify-content-center px-2 px-lg-5  p-lg-0  ">
                                            <h5 class="text-capitalize fw-bold fs-4 text-start balence text-primary text-shadow">Ingredients</h5>
                                            <div id="ingredients_place" class="d-flex flex-column gap-4 align-items-start justify-content-center">

                                            </div>
                                            <h5 class="text-capitalize fw-bold fs-4 text-start balence text-primary text-shadow">Instructions</h5>
                                            <div id="instructions_place" class="d-flex flex-column gap-4 align-items-start justify-content-center">

                                            </div>
                                            <div class="d-flex gap-4 gap-lg-3   w-100 flex-column flex-lg-row text-center   my-5">
                                                <div class="d-flex gap-2 flex-lg-column text-start  justify-content-between  text-secondary  align-items-center w-100  ">
                                                    <h6 class="mb-0"><i class="bi bi-clock me-2 "></i>Preparaion time:</h6>
                                                    <h6 class="ms-4 ms-lg-0 mb-0 " id="preparationtime_place"></h6>
                                                </div>
                                                <div class="d-flex gap-2 flex-lg-column text-start justify-content-between   text-secondary  align-items-center w-100  ">
                                                    <h6 class="mb-0"><i class="bi bi-speedometer2 me-2   "></i>Cooking time:</h6>
                                                    <h6 class="ms-4 ms-lg-0 mb-0 " id="cookingtime_place"></h6>
                                                </div>
                                                <div class="d-flex gap-2 flex-lg-column text-start justify-content-between   text-secondary  align-items-center w-100  ">
                                                    <h6 class="mb-0"><i class="bi bi-hourglass-split me-2  "></i>Total time:</h6>
                                                    <h6 class="ms-4 ms-lg-0 mb-0 " id="totaltime_place"></h6>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-4 gap-lg-3   w-100 flex-column flex-lg-row text-center text-lg-start    my-5">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php footer_page2() ?>
</body>
<script src="../assets/js/recipe.js"></script>
<?= jslinks2() ?>

</html>