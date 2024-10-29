<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (file_exists('./vendor/phpmailer/phpmailer/src/Exception.php')) {
    require_once './vendor/phpmailer/phpmailer/src/Exception.php';
    require_once './vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require_once './vendor/phpmailer/phpmailer/src/SMTP.php';
} elseif (file_exists('../vendor/phpmailer/phpmailer/src/Exception.php')) {
    require_once '../vendor/phpmailer/phpmailer/src/Exception.php';
    require_once '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require_once '../vendor/phpmailer/phpmailer/src/SMTP.php';
} elseif (file_exists('../../vendor/phpmailer/phpmailer/src/Exception.php')) {
    require_once '../../vendor/phpmailer/phpmailer/src/Exception.php';
    require_once '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require_once '../../vendor/phpmailer/phpmailer/src/SMTP.php';
}

function csslinks()
{

    echo '
            <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
            <link  rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
            <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="./assets/css/style.css">
            <link rel="icon" type="image/x-icon" href="./assets/uploads/logo/logo.webp">
            ';
}
function css_caroussel()
{
    echo '
        <link rel="stylesheet" href="./assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="./assets/css/animate.css">
    ';
}

function css_caroussel2()
{
    echo '
        <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href=".,/assets/css/animate.css">
    ';
}
function csslinks2()
{

    echo '<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
            <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
            <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="../assets/css/style.css">
            <link rel="icon" type="image/x-icon" href="../assets/uploads/logo/logo.webp">
            ';
}

function jslinks()
{
    echo '<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
            <script defer src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
            <script defer src="./assets/js/script.js"></script>
            
    ';
}
function caroussel()
{
    echo '
    <script defer src="./assets/js/main.js"></script>
    <script defer src="./assets/js/owl.carousel.min.js"></script>
    <script defer src="./assets/js/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    ';
}
function caroussel2()
{
    echo '
    <script defer src="../assets/js/main.js"></script>
    <script defer src="../assets/js/owl.carousel.min.js"></script>
    <script defer src="../assets/js/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    ';
}
function jslinks2()
{
    echo '<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
            <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
            <script src="../assets/js/script.js"></script>
    ';
}
function jslinks3()
{
    echo '<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
            <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
            <script src="../assets/js/script_admin.js"></script>
    ';
}
function footer_page()
{

    echo '<footer class=" bg-dark">
    <div class="container-fluid pt-lg-0 pt-5 h-100 d-flex   align-items-center justify-content-center">
        <div class="row w-100 ">
            <div class="col-lg-3 d-flex  justify-content-center align-items-center">
                <div class="bg-white p-5 rounded-4 m-5 w-100 ">
                    <img src="./assets/uploads/logo/logov1.webp" class="img-fluid " alt="">
                </div>
                <hr class="d-none d-lg-block  separate">
            </div>
            <div class="col-lg-3 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start  ">

                <div class="d-flex flex-column justify-content-center gap-2 m-4 ">
                    <p class="text-primary text-uppercase  fw-bold fs-6">Support</p>
                    <ul class="list-unstyled gap-4 d-flex flex-column ">
                        <li><a href="./faq" class="text-decoration-none ff-ubunto text-secondary">FAQ</a></li>
                        <li><a href="./faq" class="text-decoration-none ff-ubunto text-secondary">privacy policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start ">

                <div class="d-flex flex-column justify-content-center gap-2 m-4 ">
                    <p class="text-primary text-uppercase  fw-bold fs-6">Contact</p>
                    <ul class="list-unstyled gap-4 d-flex flex-column ">
                        <li><a href="./about" class="text-decoration-none ff-ubunto text-secondary">Contact us</a></li>
                        <li><a href="./about" class="text-decoration-none ff-ubunto text-secondary">About us</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start  ">

                <div class="d-flex flex-column justify-content-center gap-2 m-4 ">
                    <p class="text-primary text-uppercase  fw-bold fs-6">Recomand us</p>
                    <ul class="list-unstyled gap-4 d-flex flex-column ">
                        <li> <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fchefme.com&amp;quote=Check%20out%20this%20awesome%20website%3A%20ChefMe.com" class="text-decoration-none ff-ubunto text-secondary" target="_blank">
                                <i class="me-2 bi bi-facebook"></i>Facebook
                            </a></li>
                        <li><a href="whatsapp://send?text=Check out this website: https%3A%2F%2Fchefme.com" class="text-decoration-none ff-ubunto text-secondary">
                                <i class="me-2 bi bi-whatsapp"></i>Whatsapp
                            </a></li>
                        <li><a href="https://twitter.com/intent/tweet?url=https%3A%2F%2Fchefme.com&amp;text=Check%20out%20this%20website" class="text-decoration-none ff-ubunto text-secondary" target="_blank">
                                <i class="me-2 bi bi-twitter-x"></i>Twitter x
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</footer>';
}
function footer_page2()
{

    echo '<footer class=" bg-dark">
    <div class="container-fluid mt-lg-0 mt-5 h-100 d-flex   align-items-center justify-content-center">
        <div class="row w-100 ">
            <div class="col-lg-3 d-flex  justify-content-center align-items-center">
                <div class="bg-white p-5 rounded-4 m-5 w-100 ">
                    <img src="../assets/uploads/logo/logov1.webp" class="img-fluid " alt="">
                </div>
                <hr class="d-none d-lg-block  separate">
            </div>
            <div class="col-lg-3 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start  ">

                <div class="d-flex flex-column justify-content-center gap-2 m-4 ">
                    <p class="text-primary text-uppercase  fw-bold fs-6">Support</p>
                    <ul class="list-unstyled gap-4 d-flex flex-column ">
                        <li><a href="../faq" class="text-decoration-none ff-ubunto text-secondary">FAQ</a></li>
                        <li><a href="../faq" class="text-decoration-none ff-ubunto text-secondary">privacy policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start ">

                <div class="d-flex flex-column justify-content-center gap-2 m-4 ">
                    <p class="text-primary text-uppercase  fw-bold fs-6">Contact</p>
                    <ul class="list-unstyled gap-4 d-flex flex-column ">
                        <li><a href="../about" class="text-decoration-none ff-ubunto text-secondary">Contact us</a></li>
                        <li><a href="../about" class="text-decoration-none ff-ubunto text-secondary">About us</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start  ">

                <div class="d-flex flex-column justify-content-center gap-2 m-4 ">
                    <p class="text-primary text-uppercase  fw-bold fs-6">Recomand us</p>
                    <ul class="list-unstyled gap-4 d-flex flex-column ">
                        <li> <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fchefme.com&amp;quote=Check%20out%20this%20awesome%20website%3A%20ChefMe.com" class="text-decoration-none ff-ubunto text-secondary" target="_blank">
                                <i class="me-2 bi bi-facebook"></i>Facebook
                            </a></li>
                        <li><a href="whatsapp://send?text=Check out this website: https%3A%2F%2Fchefme.com" class="text-decoration-none ff-ubunto text-secondary">
                                <i class="me-2 bi bi-whatsapp"></i>Whatsapp
                            </a></li>
                        <li><a href="https://twitter.com/intent/tweet?url=https%3A%2F%2Fchefme.com&amp;text=Check%20out%20this%20website" class="text-decoration-none ff-ubunto text-secondary" target="_blank">
                                <i class="me-2 bi bi-twitter-x"></i>Twitter x
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</footer>';
}
function alert_diss_abs($message)
{
    echo '<div data-bs-theme="dark" class="alert alert-danger alert-dismissible px-3 rounded-2  position-absolute bottom-0 mb-5 translate-middle-x start-50 border-0   fade show  mx-auto mt-5 text-white fs-6 py-2 d-flex   " role="alert">
            <p class="me-5 mb-0">' . $message . '</p>
    <button type="button" class="btn-close top-50  translate-middle-y text-white "  data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}

function generateToken()
{
    return mt_rand(100000, 999999);
}

function send_mail_link($to, $subject, $link)
{
    $mail = new PHPMailer();

    // SMTP settings for Gmail
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = ''; // Your Gmail address
    $mail->Password = ''; // Your Gmail password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587 ;
    $mail->SMTPDebug = 0;

    // Email content
    $mail->setFrom('', 'Chefme');
    $mail->addAddress($to);
    $template_path = __DIR__ . '/../templates/reset.html';
    $template = file_get_contents($template_path);
    $message = str_replace('{{RESET_LINK}}', $link, $template);
    $mail->Subject = $subject;
    $mail->Body = $message;

    // Additional headers
    $mail->isHTML(true); // Set email format to HTML
    $mail->CharSet = 'UTF-8'; // Set character encoding
    $mail->Encoding = 'base64'; // Set encoding type

    return $mail->send() ? true : false;
}
function send_mail($to, $subject, $code)
{
    $mail = new PHPMailer();

    // SMTP settings for Gmail
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = ''; // Your Gmail address
    $mail->Password = ''; // Your Gmail password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->SMTPDebug = 0;
    // Email content
    $mail->setFrom('', 'Chefme');
    $mail->addAddress($to);
    $template_path = __DIR__ . '/../templates/verif.html';
    $template = file_get_contents($template_path);
    $message = str_replace('{{VERIFICATION_CODE}}', $code, $template);
    $mail->Subject = $subject;
    $mail->Body = $message;

    // Additional headers
    $mail->isHTML(true); // Set email format to HTML
    $mail->CharSet = 'UTF-8'; // Set character encoding
    $mail->Encoding = 'base64'; // Set encoding type

    return $mail->send() ? true : false;
}

function simpleverife($x)
{
    return isset($_POST[$x]) ? $_POST[$x] : '';
}
function loading()
{
    echo '<div class="lds-dual-ring" bis_skin_checked="1"></div>';
}
