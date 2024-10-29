<?php
session_start();

include './functions/db.php';
include './functions/repetead.php';

if (isset($_SESSION['email']) || !empty($_SESSION['email'])) {
    header('location:./index');
    exit;
}
$conn = db_connect();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $lname = isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';

    if (empty(trim($name)) || empty(trim($lname)) || empty(trim($email)) || empty(trim($password))) {
        $response = array('status' => 'error', 'message' => 'Please fill in all fields');
        echo json_encode($response);
        exit;
    } else {
        $dem = $conn->prepare('SELECT * FROM users WHERE email = ?');
        $dem->execute([$email]);
        $result = $dem->fetch();
        if ($result) {
            $response = array('status' => 'error', 'message' => 'Email already exists');
            echo json_encode($response);
            exit;
        } else {

            $ins = $conn->prepare('INSERT INTO users( `name`, `lastname`, `email`, `password` , `bookmarked_recipes`) VALUES(?,?,?,?,?)');
            $statue = $ins->execute([$name, $lname, $email, password_hash($password, PASSWORD_DEFAULT), '[]']);
            if ($statue) {
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $name;
                $_SESSION['lastname'] = $lname;
                $_SESSION['user_id'] = $conn->lastInsertId();
                $response = array('status' => 'success','redirectUrl' => './verification');
                echo json_encode($response);
                exit;
            }else{
                $response = array('status' => 'error', 'message' => 'Something went wrong');
                echo json_encode($response);
                exit;
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <?= csslinks() ?>
</head>

<body class="blob">
    <section class="h-100vh my-md-0 my-5 ">
        <div class="container-fluid h-100 d-flex  align-items-center">
            <div class="row w-100 mx-auto ">
                <div class="col-md-6 me-auto ">
                    <div class="d-flex flex-column align-items-center  justify-content-center w-100 gap-3   ">
                        <img src="./assets/uploads/logov2.webp" class="img-fluid logo-sm my-2" alt="">
                        <h1>Create an Account</h1>
                        <form action="" id="form-signup" class="d-flex flex-column align-items-center  justify-content-center w-100   ">
                            <div class="row w-75  ">
                                <div class="col-6  p-0 mt-2">
                                    <div class="d-flex flex-column text-center  me-3">
                                        <label for="name" class="mb-2">Name</label>
                                        <input type="text" name="name" id="name" class="my-inp w-100 rounded-5 py-3  text-center" placeholder="Your Name">
                                    </div>
                                </div>
                                <div class="col-6  p-0  mt-2">
                                    <div class="d-flex flex-column text-center  ms-3">
                                        <label for="lastname" class="mb-2">Last name</label>
                                        <input type="text" name="lastname" id="lastname" class="my-inp w-100 rounded-5 py-3 text-center " placeholder="Your lastname">
                                    </div>
                                </div>

                            </div>
                            <label for="email" class="mb-2  mt-2">Email</label>
                            <input type="email" name="email" id="email" class="my-inp w-75 rounded-5 py-3 mx-5 text-center mb-3" placeholder="name@company.com">
                            <label for="password" class="mb-2 mt-2 ">Password</label>
                            <input type="password" name="password" class="my-inp w-75 rounded-5 py-3 mx-5 text-center mb-3  " id="password" placeholder="Min 8 characters">
                            <label for="Confirmpassword" class="mb-2 mt-2 ">Confirm password</label>
                            <input type="password" name="Confirmpassword" class="my-inp w-75 rounded-5 py-3 mx-5 text-center mb-3  " id="Confirmpassword" placeholder="Min 8 characters">

                            <input type="submit" value="Sign up" class="btn btn-danger px-5 py-3 mt-2  rounded-5">
                        </form>
                        <p>By signing up you agree to our <a class="text-danger text-decoration-none " href="/faq">terms</a> of service.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="signup w-100 h-100  rounded-5 text-white d-flex flex-column align-items-center justify-content-center gap-4 ">
                        <h2>Welcome Back</h2>
                        <p>Already signed up, enter your details and start cooking your first meal today</p>
                        <a href="./signin" class="btn btn-light px-5 py-3 rounded-5">Sign in</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="./assets/js/signup.js"></script>
<?= jslinks() ?>

</html>