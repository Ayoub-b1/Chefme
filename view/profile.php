<?php
include '../functions/db.php';
include '../functions/repetead.php';
session_start();

$conn = db_connect();
if (!isset($_SESSION['email']) || empty(trim($_SESSION['email']))) {
    header('location:./signin');
    exit;
}

$email = $_GET['email'];


$sql = 'SELECT users.id as per_id, users.* , personal_info.* FROM `users` INNER JOIN `personal_info` ON users.id = personal_info.user_id WHERE email = ?';
$dem = $conn->prepare($sql);
$result = $dem->execute([$email]);
$users = $dem->fetch(PDO::FETCH_ASSOC);



$sql2 = 'SELECT recipe.*, users.name, users.lastname, users.email, category.*, cuisine.* 
FROM `recipe` 
INNER JOIN `users` ON recipe.id_creator = users.id  
INNER JOIN `category` ON recipe.id_category = category.id_category 
INNER JOIN `cuisine` ON recipe.id_cuisine = cuisine.id_cuisine 
WHERE recipe.id_creator = ?'
;
$dem2 = $conn->prepare($sql2);
$result2 = $dem2->execute([$users['per_id']]);
$recipes = $dem2->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <?= csslinks2() ?>
    <?= css_caroussel2() ?>
</head>

<body class="">
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
                                    <a class="nav-link  " href="../recipes">Recipes</a>
                                </li>
                                <li class="nav-item">
                                    <a aria-label="Blogs" class="nav-link" href="../blogs">Blogs</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link active" href="../profile">Profile</a>
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
    <section class="h-90 height-90">
        <div class="container-fluid back2  position-relative h-100 mt-lg-0 mt-5 h-100 d-flex align-items-center justify-content-around flex-column ">

            <div data-aos="fade-down" class="row  w-100   pb-5 m-5 ">
                <div data-aos="fade-up" data-aos-delay="400" class="col-12 col-lg-12 col-sm-12 col-md-8  mx-auto mt-5">
                    <div class="d-flex align-items-end justify-content-center  gap-2 mx-auto w-fit  mt-5 ">
                        <h2 class=" w-33 text-capitalize fw-bold ff-ubunto fs-4 align-middle flex-grow-1 text-end  balence mb-4 pb-3" id="name"><?php echo $users['name'] ?></h2>
                        <img src="../<?php echo $users['profile_pic'] ?>" class="img-fluid border w-33   border-5  border-white w-300  rounded-circle " loading="lazy" id="img" alt="">
                        <h2 class="text-capitalize fw-bold ff-ubunto fs-4 align-middle w-33  text-start     balence mb-4 pb-3 " id="lastanme"><?php echo $users['lastname'] ?></h2>
                    </div>
                </div>
                <div class="col-12 mx-auto r mt-3">
                    <div class=" d-flex flex-column justify-content-center text-center  align-items-center ">
                        <h3 class=" fw-bold ff-ubunto fs-6 text-secondary text-center   d-inline  mx-auto  align-middle  balence" id="email"><?php echo $users['email'] ?></h3>
                    </div>
                </div>

            </div>
        </div>
       

        
    </section>
  

    
    <section class="my-5 min-vh-100   ">
        <div class="container">

            <div class="d-flex carousel-nav" data-aos="zoom-in-up" data-aos-delay="200">
                <a href="#" class="col position-relative  active text-decoration-none " data-aos="zoom-in-up" data-aos-delay="200">Personal Info</a>
                <a href="#" class="col position-relative  text-decoration-none " data-aos="zoom-in-up" data-aos-delay="600">Created Recipes</a>
                <a href="#" class="col position-relative  text-decoration-none " data-aos="zoom-in-up" data-aos-delay="800">Social Links</a>
            </div>


            <div data-aos="zoom-in-up" data-aos-delay="200" class="owl-carousel owl-1">

                <div data-aos="zoom-in-up" data-aos-delay="200" class="media-29101 gap-5 mx-auto ">
                    <div class="flex-column  flex-sm-row  d-flex ">

                        <div class="text ms-auto d-flex flex-column align-items-center justify-content-center text-center">
                            <h2 id="recipe_count" class="m-0"><?php echo $users['recipe_count'] ?></h2>
                            <h2>Recipes</h2>
                        </div>
                        <div class="me-auto text d-flex flex-column align-items-center justify-content-center text-center">
                            <h2 id="active" class="m-0">
                                <?php 
                                    $givenDateStr = $users['active'];
                                    
                                    $givenDate = new DateTime($givenDateStr);
                                    $currentDate = new DateTime();
                                    
                                    $interval = $currentDate->diff($givenDate);
                                    
                                    $daysDifference = $interval->days;
                                    
                                    echo $daysDifference;
                                
                                    
                                ?>
                            </h2>
                            <h2>Active Days</h2>
                        </div>
                    </div>
                        <label for="bio" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">Bio</label>
                        <textarea disabled class="form-control text-start bg-transparent" name="bio" id="bio" cols="20" rows="10"><?= $users['Bio'] ?>
                        </textarea>
                        <div class="d-flex align-items-center gap-3">
                            <div class="w-50">
                                <div class="d-flex flex-column ">
                                    <label for="Cuisine" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">Cuisine</label>
                                    <input disabled type="text" name="Cuisine" id="Cuisine" class="form-control bg-transparent " value="<?= $users['prefered_cuisine'] ?>">

                                </div>
                            </div>
                            <div class="w-50">
                                <div class="d-flex flex-column ">
                                    <label for="allergies" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">allergies</label>
                                    <input disabled type="text" name="allergies" id="allergies" class="form-control bg-transparent " value="<?= $users['allergies'] ?>">
                                </div>
                            </div>
                        </div>
                        <input type="submit" value="Save changes" id="changebtn" class="btn btn-success d-none w-fit ms-auto ">

                    </>
                </div>

                
                <div class="media-29101 d-md-flex w-100">
                    <div class="table-responsive table-responsive-sm w-100  ">
                        <table class="table table-hover align-middle w-100   ">
                            <tbody id="created_recipes">
                                <?php foreach($recipes as $recipe){?>
                                <tr>
                                    <td><img src="../<?php echo $recipe['recipe_img']?>" class="img-fluid table_img" alt=""></td>  
                                    <td><?php echo $recipe['title'] ?></td>
                                    <td><a href="./recipe?id=<?php echo $recipe['id_recipe'] ?>" class="text-decoration-none text-danger fw-bold">View <i class="bi bi-arrow-up-right"></i"></a></td>
                                </tr>
                            <?php } ?> 
                            </tbody>
                        </table>

                    </div>
                </div> <!-- .item -->


                <div class="media-29101 d-md-flex w-100">

                    <div class="text w-100  ">
                        <a class="category d-block mb-4" href="#">Social media</a>
                        <h2><a href="#">Share your accounts</a></h2>
                     
                            <div class="d-flex flex-column w-100   my-4 ">
                                <label for="facebook" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence"><i class="bi bi-facebook"></i> facebook</label>
                                <input value="<?= $users['facebook'] ?>" disabled type="text" name="facebook" id="facebook" class="form-control bg-transparent  w-100 ">
                            </div>
                            <div class="d-flex flex-column w-100  my-4  ">
                                <label for="instagram" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence"><i class="bi bi-instagram"></i> instagram</label>
                                <input value="<?= $users['instagram'] ?>" disabled type="text" name="instagram" id="instagram" class="form-control bg-transparent  w-100 ">
                            </div>
                            <div class="d-flex flex-column w-100  my-4  ">
                                <label for="number" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence"><i class="bi bi-phone"></i> number</label>
                                <input disabled type="text" name="number" id="number" class="form-control w-100 bg-transparent  " value="<?= $users['number'] ?>">
                            </div>
                            <div class="d-flex flex-column w-100 my-4   ">
                                <label for="twitter" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence"><i class="bi bi-twitter-x"></i>-twitter</label>
                                <input disabled type="text" name="twitter" id="twitter" class="form-control bg-transparent  w-100 " value="<?= $users['twitter_x'] ?>">
                            </div>
                            <input type="submit" value="Save changes" id="savebtn" class="btn btn-success d-none w-fit ms-auto ">

                        </form>
                    </div>
                </div> <!-- .item -->



            </div>
        </div>
    </section>
    <?php footer_page2() ?>

</body>
<!-- <script src="./assets/js/profile.js"></script> -->
<?= jslinks2() ?>
<?= caroussel2() ?>

</html>