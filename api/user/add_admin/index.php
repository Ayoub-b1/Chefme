<?php
include '../../../functions/db.php';

session_start();
if (!isset($_SESSION['admin_token']) || empty($_SESSION['admin_token'])) {
    echo json_encode(array('status' => 'error', 'message' => 'Unauthorized'));
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['email']) ? $_POST['email'] : NULL;
    if ($id != NULL) {
        $sql = 'SELECT * FROM users WHERE email = ?';
        $conn = db_connect();
        $dem = $conn->prepare($sql);
        $dem->execute([$id]);
        if ($dem->rowCount() > 0) {
            $prep2 = $conn->prepare('UPDATE users SET role = 1 WHERE email = ?');
            $stat = $prep2->execute([$id]);
            if ($stat) {
                $response = array('status' => 'success', 'message' => 'User set to admin successfully');
                echo json_encode($response);
                exit();
            }
        } else {
            $response = array('status' => 'error', 'message' => "User not don't existe");
            echo json_encode($response);
            exit();
        }
    } else {
        $response = array('status' => 'error', 'message' => 'invalid id or user not found');
        echo json_encode($response);
        exit();
    }
}
