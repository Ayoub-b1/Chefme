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
    <title>Blogs</title>
    <?= csslinks() ?>
    <link rel="stylesheet" href="./assets/css/blogs.css">
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
                                    <a class="nav-link " aria-current="page" href="./">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  " href="./recipes">Recipes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="./blogs">Blogs</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link " href="./profile">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./about">About us</a>
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
    <section  class="height-90 my-5 anime">
        <div class="container position-relative ">
            <div class="row">
                <div class="col-lg-7 col-xl-8 col-md-12 order-1 order-lg-0 mx-auto mt-5">
                    <div id="blogs_place" class="d-flex w-100 px-3 flex-column gap-5  align-items-center justify-content-center">
                        

                    </div>
                    <div class="w-100 mt-5 px-3   d-flex align-items-center justify-content-center">
                        <div data-aos="fade-up" data-aos-duration="1000"  data-aos-delay="400"  id="loading" class="bg-white z-3  position-relative  shadow placeholder-glow  p-4 w-100 d-flex flex-column rounded-4 shadow">
                            <div class="d-flex align-items-center gap-3  justify-content-between w-100">
                                <img class="img-fluid rounded-circle  placeholder  img_post" alt="">
                                <div class="d-flex flex-column gap-2 w-100">
                                    <p class="mb-0 placeholder  rounded-3  w-50"></p>
                                    <div class=" placeholder rounded-3  w-75  ">
                                        <span>csdd</span>
                                    </div>
                                </div>
                            </div>
                            <p class="placeholder rounded-3 p-5   w-100 mt-3"></p>
                        </div>
                    </div>

                </div>
                <div id="post_div" class="col-lg-5 col-xl-4 col-md-12 mt-5 ">
                    <div data-aos="flip-up" data-aos-duration="1000" data-aos-delay="400" id="" class="wrapper bg-white rounded-4  mx-1 mx-lg-0 shadow position-sticky top-0 ">
                        <section class="post py-4 ">
                            <header>Create Post</header>
                            <form action="#" method="post" id="form-post" enctype="multipart/form-data">
                                <div class="content">
                                    <img id="addpostlabel" class="img-fluid rounded-circle border border-1  " alt="logo">
                                    <div class="details">
                                        <p id="name_post" class="mb-0 "></p>
                                        <div class="privacy">
                                            <span id="email_post"></span>
                                        </div>
                                    </div>
                                </div>
                                <textarea id="post" name="post_text" spellcheck="false" required></textarea>
                                <div class="options">
                                    <p class="mb-0">Add to Your Post</p>
                                    <ul class="list mb-0 ">
                                        <li class="">
                                            <input type="file" name="image" id="post_image" class="d-none" multiple>
                                            <label for="post_image" class="w-100 h-100 d-flex justify-content-center align-items-center">
                                                <i class="bi bi-image"></i>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                                <div id="preview" class=" d-grid gap-4 mb-3 grid-template-3"></div>
                                <input type="submit" value="Post" id="post">
                            </form>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php footer_page() ?>

</body>
<script src="./assets/js/blogs.js"></script>
<?= jslinks() ?>

</html>