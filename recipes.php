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
    <title>Recipes</title>
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
                                    <a class="nav-link active " href="./recipes">Recipes</a>
                                </li>
                                <li class="nav-item">
                                    <a aria-label="Blogs" class="nav-link" href="./blogs">Blogs</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="./profile">Profile</a>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog mx-3  mx-lg-7 max-auto">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">New Recipe</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" id="modal-close" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="post" id="add_recipes">
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
                                                                    <div class="d-flex align-items-center gap-3">
                                                                        <input type="text" name="ingrediants" id="" class="form-control ingrediants">
                                                                        <i class="bi bi-x-lg fw-bold p-2 mini-card-i "></i>
                                                                    </div>
                                                                    <i class="bi bi-plus-lg p-2 mini-card-i " id="add-ingrediant"></i>
                                                                </div>
                                                                <label for="instructions" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">instructions</label>
                                                                <div id="instructions-place" class="d-flex align-items-start gap-4 flex-column   ">
                                                                    <div class="d-flex align-items-center gap-3 w-100 ">
                                                                        <input type="text" name="instructions" id="" class="form-control instructions">
                                                                        <i class="bi bi-x-lg fw-bold p-2 mini-card-i "></i>
                                                                    </div>
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
                                                                            <option value="" disabled selected>Select</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="w-50">
                                                                        <h2 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence ">Cuisine</h2>
                                                                        <select name="Cuisine" id="Cuisine" class="form-select w-100 cuisine_place">
                                                                            <option value="" disabled selected>Select</option>
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
    <section class="height-90">
        <div class="container-fluid mt-lg-0 mt-5 h-100 d-flex align-items-center justify-content-center">
            <button id="menu-toggle" class="position-fixed border border-1 border-white  start-50 translate-middle-x bottom-0 bg-dark rounded-3 my-2 text-white px-3 d-flex align-items-center justify-content-center d-lg-none py-2 gap-3 z-3 ">
                menu
                <i class="bi bi-three-dots"></i>
            </button>
            <div class="row w-100  ">
                <div class="col-lg-3 d-none d-lg-flex h-fit  " id="menu">

                    <div data-aos="flip-right" data-aos-duration="1000" data-aos-delay="400" class=" shadow rounded-5 w-100  my-5 bg-white   ">
                        <div class="d-flex flex-column justify-content-center gap-2 align-items-start px-4 py-3 ">
                            <!-- Button trigger modal -->
                            <button id="add_recipe" type="button" class="btn btn-danger text-center  w-100 text-uppercase fw-medium fs-4 my-2   text-start balence " data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="me-2 bi bi-plus-circle"></i>
                                Share Recipe
                            </button>

                            <!-- Modal -->
                            
                            <p class="text-danger text-uppercase  fw-bold fs-6 ">Filters <i class="bi bi-funnel-fill"></i></p>
                            <form action="" method="get" class="w-100 d-flex flex-column gap-4">
                                <div>
                                    <h2 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence ">title</h2>
                                    <div class="d-flex align-items-center    position-relative " role="search">
                                        <label for="search" class="s-label"><i class="bi bi-search"></i></label>
                                        <input id="search" name="search" class="input" type="search" placeholder="Search">
                                    </div>
                                </div>
                                <div>
                                    <h2 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence ">difficulty</h2>
                                    <div class="d-flex align-items-center justify-content-start gap-2 w-100  ">
                                        <input type="radio" id="easy" name="difficulty" value="easy" class="d-none">
                                        <label class="radio-label" for="easy">easy</label>
                                        <input type="radio" id="medium" name="difficulty" value="medium" class="d-none">
                                        <label class="radio-label" for="medium">medium</label>
                                        <input type="radio" id="hard" name="difficulty" value="hard" class="d-none">
                                        <label class="radio-label" for="hard">hard</label>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence ">Total Time</h2>
                                    <div class="d-flex align-items-center justify-content-start gap-2 w-100">
                                        <input type="radio" id="-10min" name="totaletime_filter" value="-10min" class="d-none">
                                        <label class="radio-label fs-7 fw-medium" for="-10min">- 10 min</label>

                                        <input type="radio" id="+10min" name="totaletime_filter" value="+10min" class="d-none">
                                        <label class="radio-label fs-7 fw-medium" for="+10min">10min-30min</label>

                                        <input type="radio" id="+30min" name="totaletime_filter" value="+30min" class="d-none">
                                        <label class="radio-label fs-7 fw-medium" for="+30min">+ 30 min</label>
                                    </div>

                                </div>

                                <div>
                                    <h2 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence ">Serving</h2>
                                    <div class="d-flex align-items-center justify-content-start gap-2 w-100  ">
                                        <input type="number" name="serving_filter" id="serving" class="form-control w-25" min="1" max="10">
                                        <label for="serving" class="fs-6 fw-medium  ">Personne(s)</label>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence ">Categorie</h2>
                                    <select name="categorie_filter" id="categorie" class="form-select w-100 category_place">
                                        <option value="" disabled selected>Select</option>
                                    </select>
                                </div>
                                <div>
                                    <h2 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence ">Cuisine</h2>
                                    <select name="Cuisine_filter" id="Cuisine" class="form-select w-100 cuisine_place">
                                        <option value="" disabled selected>Select</option>
                                    </select>
                                </div>

                            </form>
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
<script src="./assets/js/recipes.js"></script>
<?= jslinks() ?>

</html>