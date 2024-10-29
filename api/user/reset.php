<?php
include '../../functions/db.php';
include '../../functions/repetead.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = db_connect();
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $sql = 'SELECT * FROM `users` WHERE `email` = ?';
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {

        $token = bin2hex(random_bytes(16));
        $token_hash = hash('sha256', $token);
        $expire = date('Y-m-d H:i:s', time() + 60 * 10);
        $sql = 'UPDATE `users` SET `resetToken` = ?, `reset_token_expiration` = ? WHERE `email` = ?';

        $dem = $conn->prepare($sql);

        $res = $dem->execute([$token_hash, $expire, $email]);
        if ($res) {
            $to = $email;
            $subject = 'Password Reset';
            $link =  '/reset.php?token=' . $token;
            if (send_mail_link($to, $subject, $link)) {
                http_response_code(200);
                echo json_encode(array('status' => 'success', 'message' => 'Reset link sent to your email'));
                exit;
            } else {
                http_response_code(500);
                echo json_encode(array('status' => 'error', 'message' => 'Failed to send reset link'));
                exit;
            }
        }
    } else {
        http_response_code(200);
        echo json_encode(array('status' => 'error', 'message' => 'Email does not exist'));
        exit;
    }
} else {
    http_response_code(405);
    echo json_encode(array('status' => 'error', 'message' => 'Method not allowed'));
    exit;
}
