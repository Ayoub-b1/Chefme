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
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
    $token = isset($_POST['token']) ? htmlspecialchars($_POST['token']) : '';


    if (empty(trim($token)) || empty(trim($password))) {
        $response = array('status' => 'error', 'message' => 'Please fill in all fields');
        echo json_encode($response);
        exit;
    } else {
            $token_hash = hash('sha256', $token);
            $dem = $conn->prepare('SELECT * FROM users WHERE resetToken = ?');
            $dem->execute([$token_hash]);
            $result = $dem->fetch();
            if ($result) {
                if(strtotime($result['reset_token_expiration']) >= time()){
                    $update = $conn->prepare("UPDATE users SET password = ?, resetToken  = NULL, reset_token_expiration = NULL WHERE resetToken = ?");
                    $update->execute([password_hash($password, PASSWORD_DEFAULT), $token_hash]);
                    $response = array('status' => 'success', 'message' => 'Password reset successfully', 'redirectUrl' => './signin');
                    echo json_encode($response);
                    exit;
                }else{
                    $response = array('status' => 'error', 'message' => 'Token expired');
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response = array('status' => 'error', 'message' => 'Wrong token');
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
    <title>Reset</title>
    <?= csslinks() ?>
</head>

<body class="blob">
    <section class="h-100vh rand">
        <div class="container-fluid h-100 d-flex  align-items-center">
            <div class="row w-100">
                <div class="col-md-6">
                    <div class="resetpass w-100 h-100  rounded-5 text-white d-flex flex-column align-items-center justify-content-center gap-4">

                    </div>
                </div>
                <div class="col-md-6 me-auto ">
                    <div class="d-flex flex-column align-items-center  justify-content-center w-100 gap-3  my-5 ">
                        <img src="./assets/uploads/logo/logov2.webp" class="img-fluid w-25 my-3" alt="">
                        <h1>Set new password</h1>
                        <form action="" method="post" id="form-reset" class="d-flex flex-column align-items-center  justify-content-center w-100   ">
                            <label for="password" class="mb-2">New Password</label>
                            <input type="password" name="password" class="my-inp w-75 rounded-5 py-3 mx-5 text-center  " id="password" placeholder="Min 8 characters">
                            <label for="co_password" class="mb-2">Confirm new password</label>
                            <input type="password" name="co_password" id="co_password" class="my-inp w-75 rounded-5 py-3 mx-5 text-center mb-3" placeholder="Min 8 charactes">
                            <input type="submit" value="Update" class="btn btn-danger px-5 py-3 rounded-5">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="./assets/js/resetpass.js"></script>

</html>