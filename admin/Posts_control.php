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
    <title>Recipes</title>
    <link rel="stylesheet" href="../assets/css/blogs.css">
    <?= csslinks2() ?>
</head>

<body class="back">
    <header class="height-10">
        <nav class="navbar navbar-expand-lg bg-transparent h-100">
            <div class="container">
                <div class="row justify-content-between w-100">
                    <div class="col-lg-2 d-flex align-items-center justify-content-between  ">

                        <a class="navbar-brand" href="./index"><img src="../assets/uploads/logo/logov2.webp" class="img-fluid logo" alt=""></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="col-lg-10 ">

                        <div class="collapse z-3 text-lg-start text-center  justify-content-end gap-5 navbar-collapse" id="nav">
                            <ul class="navbar-nav  my-2 my-lg-0 fw-bold align-items-center gap-5 ">
                                <li class="nav-item">
                                    <a aria-label="home" class="nav-link " href="./?token=<?php echo $token_hash ?>">Content</a>
                                </li>
                                <li class="nav-item">
                                    <a aria-label="recipes" class="nav-link " href="./recipes?token=<?php echo $token_hash ?>">Recipes</a>
                                </li>
                                <li class="nav-item">
                                    <a aria-label="Blogs" class="nav-link active" aria-current="page" href="./Posts_control?token=<?php echo $token_hash ?>">Posts control</a>
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


    <section class="height-90 my-5 anime">
        <div class="container position-relative ">
            <div class="row">
                <div class="col-lg-7 col-xl-8 col-md-12 order-1 order-lg-0 mx-auto mt-5">
                    <div id="blogs_place" class="d-flex w-100 px-3 flex-column gap-5  align-items-center justify-content-center">


                    </div>
                    <div class="w-100 mt-5 px-3   d-flex align-items-center justify-content-center">
                        <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400" id="loading" class="bg-white z-3  position-relative  shadow placeholder-glow  p-4 w-100 d-flex flex-column rounded-4 shadow">
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
                            <header>Delete Post</header>
                            <div class="m-5">
                                <h1 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence">To delete a post</h1>
                                <ol class="gap-3 my-5  d-flex flex-column">
                                    <li>Choose the post you want to delete.</li>
                                    <li>Click on it.</li>
                                    <li>click the x button</li>
                                </ol>
                            </div>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php footer_page() ?>
</body>
<?= jslinks3() ?>
<script src="../assets/js/blogs_admin.js"></script>

</html>