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
    <title>Profile</title>
    <?= csslinks() ?>
    <?= css_caroussel() ?>
</head>

<body class="">
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
                                    <a class="nav-link active" href="./profile">Profile</a>
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
    <section class="h-90 height-90">
        <div class="container-fluid back2  position-relative h-100 mt-lg-0 mt-5 h-100 d-flex align-items-center justify-content-around flex-column ">

            <div data-aos="fade-down" class="row  w-100   pb-5 m-5 ">
                <div data-aos="fade-up" data-aos-delay="400" class="col-12 col-lg-12 col-sm-12 col-md-8  mx-auto mt-5">
                    <div class="d-flex align-items-end justify-content-center  gap-2 mx-auto w-fit  mt-5 ">
                        <h2 class=" w-33 text-capitalize fw-bold ff-ubunto fs-4 align-middle flex-grow-1 text-end  balence mb-4 pb-3" id="name"></h2>
                        <img src="./uploads/pfp/default.png" class="img-fluid border w-33   border-5  border-white w-300  rounded-circle " loading="lazy" id="img" alt="">
                        <h2 class="text-capitalize fw-bold ff-ubunto fs-4 align-middle w-33  text-start     balence mb-4 pb-3 " id="lastanme"></h2>
                    </div>
                </div>
                <div class="col-12 mx-auto r mt-3">
                    <div class=" d-flex flex-column justify-content-center text-center  align-items-center ">
                        <h3 class=" fw-bold ff-ubunto fs-6 text-secondary text-center   d-inline  mx-auto  align-middle  balence" id="email"></h3>
                    </div>
                </div>

            </div>
        </div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger  position-absolute bottom-0 end-0 m-3 d-inline w-auto   " id="edit" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="bi bi-pencil-square fs-4"></i>
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog mx-3  mx-lg-7 max-auto">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="form-update" class="w-100 d-flex flex-column gap-3">

                            <h2 for="title" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence mx-5 ">Profile Picture</h2>
                            <div class="radios_pfp d-flex gap-4 flex-wrap justify-content-center align-items-center  ">

                            </div>
                            <div class="d-flex gap-2 gap-lg-5  mx-5">
                                <div class="w-50">

                                    <label for="name" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence  ">First Name</label>
                                    <input type="text" name="name" id="update_name" class="form-control  w-100" placeholder="Enter First Name">
                                </div>
                                <div class="w-50">

                                    <label for="title" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence  w50 ">Last Name</label>
                                    <input type="text" name="lastname" id="update_lastname" class="form-control  w-100" placeholder="Enter Last Name">
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer align-items-center justify-content-center gap-2 gap-lg-4 ">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="Save changes" class="btn btn-success">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog mx-3 w-50 mx-auto     max-auto">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel2"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="modal-close2" aria-label="Close"></button>
                </div>
                <div class="modal-body py-5" id="recipe_preview">
                <form action="" method="post" id="delete_recipe">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-danger" id="delete-spec-recipe" value="Delete">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog mx-3  mx-lg-7 max-auto">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel1"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="modal-close1" aria-label="Close"></button>
                </div>
                <form action="" method="post" id="updae_recipes">
                    <div class="modal-body overflow-y-scroll max-h-80 ">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="position-sticky top-0  ">
                                        <label for="image-file" id="custum-file-upload" class="custum-file-upload">
                                            <div class="icon">
                                                <svg viewBox="0 0 24 24" fill="" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" fill=""></path>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="text">
                                                <span>Click to upload image</span>
                                            </div>
                                            <input id="image-file" type="file" name="recipe_img" accept="image/*">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="d-flex flex-column gap-4">
                                        <label for="title" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">Title</label>
                                        <input type="text" name="title" id="title" class="form-control">
                                        <label for="description" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">description</label>
                                        <textarea name="description" id="description" cols="30" rows="4" class=" form-control" placeholder="short description (min 60)"></textarea>

                                        <label for="ingrediant" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">ingrediant</label>
                                        <div id="ingrediant-place" class="d-flex align-items-center gap-3 flex-wrap ">

                                            <i class="bi bi-plus-lg p-2 mini-card-i " id="add-ingrediant"></i>
                                        </div>
                                        <label for="instructions" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">instructions</label>
                                        <div id="instructions-place" class="d-flex align-items-start gap-4 flex-column   ">

                                            <i class="bi bi-plus-lg p-2 mini-card-i " id="add-instructions"></i>
                                        </div>
                                        <div class="time d-flex align-items-center gap-3 flex-wrap  ">
                                            <div class="d-flex flex-column ">
                                                <label for="preparation-time" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">preparation-time <span class="text-secondary fw-light ">(minutes)</span></label>
                                                <input max="99" type="number" name="preparation_time" id="preparation-time" class="form-control">
                                            </div>
                                            <div class="d-flex flex-column ">
                                                <label for="Cooking-time" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">Cooking-time <span class="text-secondary fw-light ">(minutes)</span></label>
                                                <input max="180" type="number" name="Cooking_time" id="Cooking-time" class="form-control  ">
                                            </div>
                                            <div class="d-flex flex-column ">
                                                <label for="total-time" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">total-time <span class="text-secondary fw-light ">(minutes)</span></label>
                                                <input max="99" type="number" name="total_time" id="total-time" class="form-control disabled" disabled>
                                            </div>
                                        </div>
                                        <div>
                                            <h2 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence ">difficulty</h2>
                                            <div class="d-flex align-items-center justify-content-start gap-2 w-100  ">
                                                <input type="radio" id="diff_easy" name="recipe_difficulty" value="easy" class="d-none">
                                                <label class="radio-label" for="diff_easy">easy</label>
                                                <input type="radio" id="diff_medium" name="recipe_difficulty" checked value="medium" class="d-none">
                                                <label class="radio-label" for="diff_medium">medium</label>
                                                <input type="radio" id="diff_hard" name="recipe_difficulty" value="hard" class="d-none">
                                                <label class="radio-label" for="diff_hard">hard</label>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="w-50">
                                                <h2 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence ">Categorie</h2>
                                                <select name="categorie" id="categorie" class="form-select w-100 category_place">
                                                    <option value="" disabled>Select</option>
                                                </select>
                                            </div>
                                            <div class="w-50">
                                                <h2 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence ">Cuisine</h2>
                                                <select name="Cuisine" id="Cuisine" class="form-select w-100 cuisine_place">
                                                    <option value="" disabled>Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="w-50">
                                                <div class="d-flex flex-column ">
                                                    <label for="calories" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">Calories <span class="text-secondary fw-light ">(kcal)</span></label>
                                                    <input step=".01" type="number" name="calories" id="calories" class="form-control">
                                                </div>
                                            </div>
                                            <div class="w-50">
                                                <div class="d-flex flex-column ">
                                                    <label for="servings" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">servings <span class="text-secondary fw-light ">(persones)</span></label>
                                                    <input value="1" max="10" type="number" name="servings" id="servings" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="Save changes" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <section class="my-5  ">
        <div class="container">

            <div class="d-flex carousel-nav" data-aos="zoom-in-up" data-aos-delay="200">
                <a href="#" class="col position-relative  active text-decoration-none " data-aos="zoom-in-up" data-aos-delay="200">Personal Info</a>
                <a href="#" class="col position-relative  text-decoration-none " data-aos="zoom-in-up" data-aos-delay="400">Bookmarked Recipes</a>
                <a href="#" class="col position-relative  text-decoration-none " data-aos="zoom-in-up" data-aos-delay="600">Created Recipes</a>
                <a href="#" class="col position-relative  text-decoration-none " data-aos="zoom-in-up" data-aos-delay="800">Social Links</a>
            </div>


            <div data-aos="zoom-in-up" data-aos-delay="200" class="owl-carousel owl-1">

                <div data-aos="zoom-in-up" data-aos-delay="200" class="media-29101 gap-5 mx-auto ">
                    <div class="flex-column  flex-sm-row  d-flex ">

                        <div class="text ms-auto d-flex flex-column align-items-center justify-content-center text-center">
                            <h2 id="recipe_count" class="m-0"></h2>
                            <h2>Recipes</h2>
                        </div>
                        <div class="me-auto text d-flex flex-column align-items-center justify-content-center text-center">
                            <h2 id="active" class="m-0"></h2>
                            <h2>Active Days</h2>
                        </div>
                    </div>
                    <h4 class="text-capitalize fw-bold ff-ubunto fs-6 text-end w-75 mx-auto cur-pointer balence text-danger "><i id="edit-toggle" class="bi bi-pen"></i></h4>
                    <form action="" id="pers_form" method="post" class="d-flex flex-column gap-4 text-start   justify-content-center w-75 mx-auto   ">
                        <label for="bio" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">Bio</label>
                        <textarea disabled class="form-control" name="bio" id="bio" cols="20" rows="10">

                        </textarea>
                        <div class="d-flex align-items-center gap-3">
                            <div class="w-50">
                                <div class="d-flex flex-column ">
                                    <label for="Cuisine" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">Cuisine</label>
                                    <input disabled type="text" name="Cuisine" id="Cuisine" class="form-control">

                                </div>
                            </div>
                            <div class="w-50">
                                <div class="d-flex flex-column ">
                                    <label for="allergies" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">allergies</label>
                                    <input disabled type="text" name="allergies" id="allergies" class="form-control">
                                </div>
                            </div>
                        </div>
                        <input type="submit" value="Save changes" id="changebtn" class="btn btn-success d-none w-fit ms-auto ">

                    </form>
                </div>

                <div class="media-29101 d-md-flex w-100">
                    <div class="table-responsive table-responsive-sm w-100  ">
                        <table class="table table-hover align-middle w-100   ">
                            <tbody id="bookmarks_table"></tbody>
                        </table>

                    </div>
                </div> <!-- .item -->
                <div class="media-29101 d-md-flex w-100">
                    <div class="table-responsive table-responsive-sm w-100  ">
                        <table class="table table-hover align-middle w-100   ">
                            <tbody id="created_recipes">

                            </tbody>
                        </table>

                    </div>
                </div> <!-- .item -->


                <div class="media-29101 d-md-flex w-100">

                    <div class="text w-100 ">
                        <a class="category d-block mb-4" href="#">Social media</a>
                        <h2><a href="#">Share your accounts</a></h2>
                        <form action="" method="post" class="d-flex flex-column gap-5 align-items-center  justify-content-center w-100   ">
                            <h4 class="text-capitalize fw-bold ff-ubunto fs-6 text-end w-100 mx-auto cur-pointer balence text-danger "><i id="edit-social-toggle" class="bi bi-pen"></i></h4>

                            <div class="d-flex flex-column w-100  ">
                                <label for="facebook" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence"><i class="bi bi-facebook"></i> facebook</label>
                                <input disabled type="text" name="facebook" id="facebook" class="form-control w-100 ">
                            </div>
                            <div class="d-flex flex-column w-100  ">
                                <label for="instagram" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence"><i class="bi bi-instagram"></i> instagram</label>
                                <input disabled type="text" name="instagram" id="instagram" class="form-control w-100 ">
                            </div>
                            <div class="d-flex flex-column w-100  ">
                                <label for="number" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence"><i class="bi bi-phone"></i> number</label>
                                <input disabled type="text" name="number" id="number" class="form-control w-100 ">
                            </div>
                            <div class="d-flex flex-column w-100  ">
                                <label for="twitter" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence"><i class="bi bi-twitter-x"></i>-twitter</label>
                                <input disabled type="text" name="twitter" id="twitter" class="form-control w-100 ">
                            </div>
                            <input type="submit" value="Save changes" id="savebtn" class="btn btn-success d-none w-fit ms-auto ">

                        </form>
                    </div>
                </div> <!-- .item -->



            </div>
        </div>
    </section>
    <?php footer_page() ?>

</body>
<script src="./assets/js/profile.js"></script>
<?= jslinks() ?>
<?= caroussel() ?>

</html>