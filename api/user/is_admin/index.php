<?php
include '../../../functions/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = 'SELECT role  FROM `users` where email = ?';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute([$_SESSION['email']]);
    $role = $dem->fetchColumn(); // Fetch the role directly
    if ($result) {
        if ($role == 1) {
            $token = bin2hex(random_bytes(16));
            $_SESSION['admin_token'] = $token;
            $token_hash = hash('sha256', $token);
            $response = array('status' => 'success', 'is_admin' => $role, 'token' => $token_hash);
        } else {
            $response = array('status' => 'success', 'is_admin' => $role);
        }
        echo json_encode($response);
        exit();
    } else {
        $response = array('status' => 'error', 'message' => 'Something went wrong');
        echo json_encode($response);
        exit();
    }
}
