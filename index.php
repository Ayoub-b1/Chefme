<?php
include './functions/db.php';
include './functions/repetead.php';
session_start();

$conn = db_connect();
if (!isset($_SESSION['email']) || empty(trim($_SESSION['email']))) {
    header('location:./signin');
    exit;
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explore a world of culinary delights with our collection of mouthwatering recipes. From comforting classics to exotic creations, discover endless inspiration for every mealtime. Let our step-by-step guides and expert tips elevate your cooking experience. Start your flavorful journey today!">
    <title>Home</title>
    <?= csslinks() ?>
</head>

<body class="back">
    <header class="height-10">
        <nav class="navbar navbar-expand-lg bg-transparent h-100">
            <div class="container">
                <div class="row justify-content-between w-100">
                    <div class="col-lg-2 d-flex align-items-center justify-content-between  ">

                        <a aria-label="home" class="navbar-brand" href="./index"><img src="./assets/uploads/logo/logov2.webp" class="img-fluid logo" alt=""></a>
                        <button role="button" aria-label="menu-toggle" id="menu-toggle" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="col-lg-10 ">

                        <div class="collapse z-3 text-lg-start text-center  justify-content-end gap-5 navbar-collapse" id="nav">
                            <ul class="navbar-nav  my-2 my-lg-0 fw-bold align-items-center gap-5 ">
                                <li class="nav-item">
                                    <a aria-label="home" class="nav-link active" aria-current="page" href="./">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a aria-label="recipes" class="nav-link " href="./recipes">Recipes</a>
                                </li>
                                <li class="nav-item">
                                    <a aria-label="Blogs" class="nav-link" href="./blogs">Blogs</a>
                                </li>

                                <li class="nav-item">
                                    <a aria-label="Profile" class="nav-link" href="./profile">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a aria-label="About us" class="nav-link" href="./about">About us</a>
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
    <section class="h-90">
        <div class="container mt-lg-0 mt-5 h-100 d-flex align-items-center justify-content-center">
            <div class="row w-100  ">
                <div class="col-lg-7" data-aos="zoom-in-right" data-aos-delay="600" data-aos-duration="1000">
                    <div class="d-flex flex-column gap-2 align-items-start ">
                        <p class="text-danger text-uppercase  fw-bold fs-6">#1 Cooking recipe</p>
                        <h1 class="text-capitalize fw-bold ff-ubunto fs-my-1 text-start balence ">Best way <br>To find Sweet <br>Recipes</h1>
                        <p class="text-secondary fw-semibold pe-5 fs-6 ">Always take care of your health starting from the food menu that you consume every day</p>
                        <a aria-label="Start" href="./recipes" class=" btn mybtn px-5 py-3 mb-5  ">Start now</a>
                        <div class=" d-flex justify-content-between  w-100 align-items-center pe-5 ">
                            <h2 class="fs-my-2"><span id="active-users"></span> <span class="fs-6 fw-bold  align-middle ">active users</span></h2>
                            <h2 class="fs-my-2"><span id="avg-ratings"></span> <span class="fs-6 fw-bold  align-middle ">Recipes</span></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 tt" data-aos="zoom-in-left" data-aos-delay="600" data-aos-duration="1000">
                    <img src="./assets/uploads/view/pan.webp" class="img-fluid z-1 position-relative object-fit-contain   end-25  h-100 w-100" alt="">
                </div>
            </div>
        </div>
    </section>
    <section class="height-100 my-5 my-lg-0">
        <div class="container mt-lg-0 mt-5 h-100 d-flex align-items-center justify-content-center" data-aos="fade-up" data-aos-duration="1000" data-aos-anchor-placement="center-bottom">
            <div class="row w-100  ">
                <div class="col-lg-5">
                    <img src="./assets/uploads/view/bookmark.svg" loading="lazy" class="img-fluid z-1 position-relative  end-25  h-100 w-100" alt="">
                </div>
                <div class="col-lg-7 d-flex flex-column justify-content-center">
                    <div class="d-flex flex-column justify-content-center gap-2 align-items-start ">
                        <p class="text-danger text-uppercase  fw-bold fs-6">Bookmark system</p>
                        <div class="d-flex flex-column gap-2 align-items-start ">
                            <h1 class="text-capitalize fw-bold ff-ubunto fs-my-1 text-start balence ">Recipes with<br>Bookmark system </h1>
                            <p class="text-secondary fw-semibold pe-5 fs-6 ">Recipe saving system enhances your culinary journey by providing a place where you can find all your saved recipes</p>
                            <a href="./recipes" class=" btn mybtn px-5 py-3 mb-5  ">Explore</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="  my-5 my-lg-0  bg-primary-subtle ">
        <div class="container mt-lg-0 mt-5 h-100 d-flex align-items-center justify-content-center" data-aos="fade-down" data-aos-duration="1000" data-aos-anchor-placement="center-bottom">
            <div class="row w-100  ">
                <div class="col-lg-5">
                    <img src="./assets/uploads/view/blog.svg" loading="lazy" class="img-fluid z-1 position-relative  end-25  h-100 w-100" alt="">
                </div>
                <div class="col-lg-7 d-flex flex-column justify-content-center">
                    <div class="d-flex flex-column justify-content-center gap-2 align-items-start ">
                        <p class="text-danger text-uppercase  fw-bold fs-6">blog System</p>
                        <div class="d-flex flex-column gap-2 align-items-start ">
                            <h1 class="text-capitalize fw-bold ff-ubunto fs-my-1 text-start balence ">Explore What others think </h1>
                            <p class="text-secondary fw-semibold pe-5 fs-6 ">experiences shared by users from around the globe. From home cooks and food bloggers to passionate foodies and amateur chefs</p>
                            <a href="./blogs" class=" btn mybtn px-5 py-3 mb-5  ">Discover</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- <section class=" height-100 my-5 my-lg-0 ">
        <div class="container mt-lg-0 mt-5 h-100 d-flex   align-items-center justify-content-center">
            <div class="row w-100 ">
                <div class="col-lg-12 d-flex flex-column justify-content-center align-items-center " data-aos="fade-left" data-aos-duration="1000">
                    <div class="d-flex flex-column justify-content-center gap-2 align-items-center  text-center ">
                        <p class="text-danger text-uppercase  fw-bold fs-6">Special Receipes</p>
                        <div class="d-flex flex-column gap-2 align-items-center ">
                            <h1 class="text-capitalize fw-bold ff-ubunto fs-my-1 text-center balence text-xl-start ">Share and Discover Special Receipes</h1>
                            <p class="text-secondary fw-semibold pe-5 fs-6 ">Discover and share the best recipes from around the world</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" data-aos="fade-right" data-aos-duration="1000">
                    <div class="row my-5" id="bookmerked_recipes">

                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <section class=" height-100   ">
        <div class="container mt-lg-0 mt-5 h-100 d-flex py-5 py-lg-0    align-items-center justify-content-center">
            <div class="row w-100 ">
                <div class="col-lg-12 d-flex flex-column justify-content-center align-items-center " data-aos="fade-right" data-aos-duration="1000">
                    <div class="d-flex flex-column justify-content-center gap-2 align-items-center  text-center ">
                        <p class="text-danger text-uppercase  fw-bold fs-6">Last Receipes</p>
                        <div class="d-flex flex-column gap-2 align-items-center text-center  ">
                            <h1 class="text-capitalize fw-bold ff-ubunto fs-my-1 text-center balence   ">Get last Receipes shared by others</h1>
                            <p class="text-secondary fw-semibold pe-5 fs-6 ">Receips updated in real time , Discover them</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" data-aos="fade-left" data-aos-duration="1000">
                    <div class="row my-5" id="last_recipes">

                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php footer_page(); ?>
</body>
<script src="./assets/js/index.js"></script>
<?= jslinks() ?>

</html>