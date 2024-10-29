<?php
session_start();
include './functions/db.php';
include './functions/repetead.php';


if (isset($_SESSION['email']) || !empty($_SESSION['email'])) {
    header('location:./index');
    exit;
}
if (!isset($_SESSION['tries']) || empty($_SESSION['tries']) || isset($_SESSION['exceeded_time']) && strtotime($_SESSION['exceeded_time']) <= time()) {
    $_SESSION['tries'] = 0;
}
$conn = db_connect();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';


    if (empty(trim($email)) || empty(trim($password))) {
        $response = array('status' => 'error','message' => 'Please fill in all fields');
        echo json_encode($response);
        exit;
    } else {
        if ($_SESSION['tries'] <= 3) {

            $dem = $conn->prepare('SELECT * FROM users WHERE email = ?');
            $dem->execute([$email]);
            $result = $dem->fetch();
            if ($result) {
                if (password_verify($password, $result['password'])) {
                    $_SESSION['email'] = $result['email'];
                    $_SESSION['name'] = $result['name'];
                    $_SESSION['lastname'] = $result['lastname'];
                    $_SESSION['user_id'] = $result['id'];
                    $bookmarked_recipes = json_encode($result['bookmarked_recipes']);
                    $response = array('status' => 'success','bookmarked_recipes' => $bookmarked_recipes,'redirectUrl' => './index');
                    echo json_encode($response);
                    exit;
                } else {
                    $_SESSION['tries']++;
                    
                    if ($_SESSION['tries'] == 3) {
                        $_SESSION['exceeded_time'] = date('Y-m-d H:i:s', time() + 1200);
                    }
                    $response = array('status' => 'error','message' => 'Wrong password');
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response = array('status' => 'error','message' => 'Wrong email');
                echo json_encode($response);
                exit;
            }
        } else {
            $response = array('status' => 'error','message' => 'You have reached the maximum number of attempts retry after a few minutes');
                echo json_encode($response);
                exit;
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <?= csslinks() ?>
</head>

<body class="blob">
    <section class="h-100vh my-md-0 my-5 rand">
        <div class="container-fluid h-100 d-flex  align-items-center">
            <div class="row w-100   mx-auto">
                <div class="col-md-6 me-auto  ">
                    <div class="d-flex flex-column align-items-center  justify-content-center w-100 gap-3  my-5 ">
                        <img src="./assets/uploads/logo/logov2.webp" class="img-fluid w-25 my-3" alt="">
                        <h1>Sign In to Chef me</h1>
                        <form action="" method="post" id="form-signin" class="d-flex flex-column align-items-center  justify-content-center w-100   ">
                            <label for="email" class="mb-2">Email</label>
                            <input type="email" name="email" id="email" class="my-inp w-75 rounded-5 py-3 mx-5 text-center mb-3" placeholder="name@company.com">
                            <label for="password" class="mb-2">Password</label>
                            <input type="password" name="password" class="my-inp w-75 rounded-5 py-3 mx-5 text-center  " id="password" placeholder="Min 8 characters">
                            <a href="./forgotpassword" class="text-decoration-none  text-secondary my-4">Forgot your password?</a>
                            <input type="submit" value="Sign In" class="btn btn-danger px-5 py-3 rounded-5">
                        </form>
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="signin w-100 h-100  rounded-5 text-white d-flex flex-column align-items-center justify-content-center gap-4 ">
                        <h2>Hello There, Join Us</h2>
                        <p>Enter your personal details and join the cooking community</p>
                        <a href="./signup" class="btn btn-light px-5 py-3 rounded-5">Signup</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="./assets/js/signin.js"></script>
<?= jslinks() ?>
</html>