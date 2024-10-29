<?php
include './functions/db.php';
include './functions/repetead.php';
session_start();

$conn = db_connect();
if (!isset($_SESSION['email']) || empty(trim($_SESSION['email']))) {
    header('location:./signin');
    exit;
}else{
    setcookie('email',$_SESSION['email'],time()+3600);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About us</title>
    <?= csslinks() ?>

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
                                    <a aria-label="Blogs" class="nav-link" href="./blogs">Blogs</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="./profile">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active " aria-current="page" href="./about">About us</a>
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
    <section class="my-5  ">
        <div class="container">
            <div class="row">
                <div class="col-6 mx-auto ">
                    <div class="px-5 my-5 " id="about" data-aos="zoom-in" data-aos-delay="400">

                    </div>
                </div>
                <div class="col-6" data-aos="zoom-in" data-aos-delay="400">
                    <img src="./assets/uploads/view/About.svg" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </section>
    <section class="my-5  ">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <img src="./assets/uploads/view/Mailsent.gif" class="img-fluid" alt="" data-aos="fade-right" data-aos-duration="1000">
                </div>
                <div class="col-6">
                    <form action=""  data-aos="fade-left" data-aos-duration="1000"  method="post" class="d-flex flex-column   rounded-4   justify-content-center w-100 bg-white p-5 shadow-lg  ">
                        <label class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence" for="subject">Subject</label>
                        <input class="form-control mb-3 " type="text" name="subject" id="subject">
                        <label for="message" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">Message</label>
                        <textarea class="form-control mb-3 " name="message" id="message" cols="30" rows="10"></textarea>
                        <input id="mail_form" class="btn mybtn py-2 px-4" type="submit" value="Send mail" >
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php footer_page() ?>
</body>
<script src="./assets/js/about.js"></script>
<?= jslinks() ?>
<script>


</script>
</html>