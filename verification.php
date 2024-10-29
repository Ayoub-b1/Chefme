<?php
include './functions/db.php';
include './functions/repetead.php';
session_start();

$conn = db_connect();
if (isset($_SESSION['email']) && !empty(trim($_SESSION['email']))) {
    $stmt = $conn->prepare("SELECT verified FROM users WHERE email = ?");
    $stmt->execute([$_SESSION['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && $user['verified'] == 1) {
        header('location:./index');
        exit;
    }
} else {
    header('location:./signin');
    exit;
}
if (!isset($_SESSION['tries']) || empty($_SESSION['tries']) || isset($_SESSION['exceeded_time']) && strtotime($_SESSION['exceeded_time']) <= time()) {
    $_SESSION['tries'] = 0;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['sendcode'])) {
        if ($_SESSION['tries'] <= 5) {
            $expirationTime = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            $token = generateToken();
            $insert = $conn->prepare("UPDATE users SET tokenVefication = ? ,expiration = ? WHERE email = ?");
            $insert->execute([$token, $expirationTime, $_SESSION['email']]);
            if ($insert) {
                send_mail($_SESSION['email'], 'Email verification', $token) ?
                    $response = array('status' => 'success', 'message' => 'Code sent to your email') :
                    $response = array('status' => 'error', 'message' => 'Failed to send verification code. Please try again');;
                echo json_encode($response);
                exit;
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to send verification code. Please try again');
                echo json_encode($response);
                exit;
            }
        } else {
            $response = array('status' => 'error', 'message' => 'You have reached the maximum number of attempts retry after a few minutes');
            echo json_encode($response);
            exit;
        }
    } else if (isset($_POST['verifycode'])) {
        $code = isset($_POST['verifycode']) ? htmlspecialchars($_POST['verifycode']) : '';

        if (empty($code)) {
            $response = array('status' => 'error', 'message' => 'Code is required');
            echo json_encode($response);
            exit;
        } else {
            if ($_SESSION['tries'] <= 5) {
                $dem = $conn->prepare("SELECT * FROM users WHERE email = ?");
                $dem->execute([$_SESSION['email']]);
                $row = $dem->fetch(PDO::FETCH_ASSOC);
                if ($row['tokenVefication'] == $code && strtotime($row['expiration']) >= time()) {
                    $update = $conn->prepare("UPDATE users SET verified = 1 AND tokenVefication = NULL AND expiration = NULL WHERE email = ?");
                    $update->execute([$_SESSION['email']]);
                    $response = array('status' => 'success', 'message' => 'Account verified Succesfully', 'redirectUrl' => './index');
                    echo json_encode($response);
                    $_SESSION['verified'] = 1;
                    exit;
                } else {
                    $response = array('status' => 'error', 'message' => 'Wrong code or expired');
                    echo json_encode($response);
                    $_SESSION['tries']++;
                    if ($_SESSION['tries'] == 5) {
                        $_SESSION['exceeded_time'] = date('Y-m-d H:i:s', time() + 1200);
                    }
                    exit;
                }
            } else {
                $response = array('status' => 'error', 'message' => 'You have reached the maximum number of attempts retry after a few minutes');
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
    <title>Verification</title>
    <?= csslinks() ?>
</head>

<body class="blob">
    <section class="h-100vh rand">
        <div class="container-fluid h-100 d-flex  align-items-center">
            <div class="row w-100">
                <div class="col-md-6 me-auto ">
                    <div class="d-flex flex-column align-items-center  justify-content-center w-100 gap-3  my-5 ">
                        <img src="./assets/uploads/logov2.webp" class="img-fluid w-25 my-3" alt="">
                        <h1>Account created Succesfully</h1>
                        <h2>one more step to complete your registration</h2>
                        <p class="text-center">Please verify your email address to continue We have sent a verification code to <?= $_SESSION['email'] ?> </p>
                        <form action="" method="post" id="form-sendcode" class="d-flex flex-column align-items-center  justify-content-center w-100  ">
                            <div class="hover-under d-flex flex-column  ">
                                <input type="submit" value="Send code" name="sendcode" class="r text-danger px-5 py-1 bg-transparent  border-0 rounded-5">

                            </div>
                        </form>
                        <form action="" method="post" id="submit-code" class="d-flex flex-column align-items-center  justify-content-center w-100   ">
                            <label for="verifycode" class="mb-2">Code</label>
                            <input maxlength="6" type="number" name="verifycode" id="verifycode" class=" my-inp w-75 rounded-5 py-3 mx-5 text-center mb-3" placeholder="Enter your code">
                            <input type="submit" value="Submit" class="btn btn-danger px-5 py-3 rounded-5">
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="verif w-100 h-100  rounded-5 text-white d-flex flex-column align-items-center justify-content-center gap-4">

                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="./assets/js/verification.js"></script>
<?= jslinks() ?>

</html>