<?php
include './functions/db.php';
include './functions/repetead.php';



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    <?= csslinks() ?>
    <?= css_caroussel() ?>

</head>

<body class="back">
  
    <section class="my-5  ">
        <div class="container">

            <div class="d-flex carousel-nav" data-aos="zoom-in-up" data-aos-delay="200">
                <a href="#" class="col position-relative  active text-decoration-none " data-aos="zoom-in-up" data-aos-delay="200">FAQ</a>
                <a href="#" class="col position-relative  text-decoration-none " data-aos="zoom-in-up" data-aos-delay="400">Privacy</a>
            </div>


            <div data-aos="zoom-in-up" data-aos-delay="200" class="owl-carousel owl-1" >

                <div data-aos="zoom-in-up" data-aos-delay="200" class="media-29101 gap-5 mx-auto "  >
                    <div class="row h-100 my-5 ">
                        <div class=" col-lg-5 flex-column h-100  align-items-center justify-content-center "  >
                            <div class="my-5">
                                <img src="./assets/uploads/view/FAQ.svg"  class="img-fluid" alt="">

                            </div>
                        </div>
                        <div class="col-lg-7 my-5 ">
                            <div class="accordion my-5 "  data-aos="fade-right" data-aos-duration="1000" id="accordionExample">
                               
                            </div>
                        </div>
                    </div>

                </div>




                <div  class="media-29101 d-md-flex w-100">

                    <div class="text w-100 " id="policy">
                       
                    </div>
                </div> <!-- .item -->



            </div>
        </div>
    </section>
</body>
<script src="./assets/js/faq.js"></script>
<?= jslinks() ?>
<?= caroussel() ?>

</html>