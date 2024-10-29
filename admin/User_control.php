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
                                    <a aria-label="home" class="nav-link"  href="./?token=<?php echo $token_hash ?>">Content</a>
                                </li>
                                <li class="nav-item">
                                    <a aria-label="recipes" class="nav-link " href="./recipes?token=<?php echo $token_hash ?>">Recipes</a>
                                </li>
                                <li class="nav-item">
                                    <a aria-label="Blogs" class="nav-link" href="./Posts_control?token=<?php echo $token_hash ?>">Posts control</a>
                                </li>

                                <li class="nav-item">
                                    <a aria-label="Profile" class="nav-link active " aria-current="page" href="./User_control?token=<?php echo $token_hash ?>">User Control</a>
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
 

    <!-- Modal -->
    <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="delete_modalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered w-fit">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
                    <button type="button" class="btn-close" id="modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="form-delete">
                    <p>Are you sure you want to delete this recipe?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input value="Delete" type="submit" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <section class="height-90">
        <div class="container-fluid mt-lg-0 mt-5 h-100 d-flex align-items-center justify-content-center">
            <button id="menu-toggle" class="position-fixed border border-1 border-white  start-50 translate-middle-x bottom-0 bg-dark rounded-3 my-2 text-white px-3 d-flex align-items-center justify-content-center d-lg-none py-2 gap-3 z-3 ">
                menu
                <i class="bi bi-three-dots"></i>
            </button>
            <div class="row w-100  ">
                <div class="col-lg-3 d-none d-lg-flex flex-column  h-fit  " id="menu">

                    <div data-aos="flip-right" data-aos-duration="1000" data-aos-delay="400" class=" shadow rounded-5 w-100  my-5 bg-white   ">
                        <div class="d-flex flex-column justify-content-center gap-2 align-items-start px-4 py-3 ">


                            <p class="text-danger text-uppercase  fw-bold fs-6 ">Filters <i class="bi bi-funnel-fill"></i></p>
                                <div>
                                    <h2 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence ">title</h2>
                                    <div class="d-flex align-items-center    position-relative " role="search">
                                        <label for="search" class="s-label"><i class="bi bi-search"></i></label>
                                        <input id="search" name="search" class="input" type="search" placeholder="Search">
                                    </div>
                                </div>
                        </div>

                    </div>
                    <div data-aos="flip-right" data-aos-duration="1000" data-aos-delay="400" class=" shadow rounded-5 w-100  my-5 bg-white   ">
                        <div class="d-flex flex-column justify-content-center gap-2 align-items-start px-4 py-3 ">


                            <p class="text-danger text-uppercase  fw-bold fs-6 ">ADD Admin <i class="bi bi-person"></i></p>
                                <div>
                                    <form action="" method="post" id="add_admin">

                                        <h2 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence ">Email</h2>
                                        <div class="d-flex align-items-center justify-content-between     position-relative " role="search">
                                            <label for="email" class="s-label"><i class="bi bi-plus"></i></label>
                                            <input id="email" name="email" class="input" type="text" placeholder="Email">
                                            <input type="submit" class="btn btn-primary rounded-5 " value="ADD">
                                        </div>
                                    </form>
                                </div>
                        </div>

                    </div>

                </div>
                <div class="col-lg-9 my-5 ">
                    <div class=" shadow rounded-5 w-100   bg-white  ">
                        <div class="d-flex flex-column justify-content-center gap-2 align-items-start px-4 py-4 d-none ">
                            <div id="filters">


                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="recipes row mt-2 ">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php footer_page() ?>
</body>
<?= jslinks3() ?>
<script src="../assets/js/users_admin.js"></script>

</html>