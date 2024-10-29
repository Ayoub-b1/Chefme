<?php
include '../../../functions/db.php';

session_start();
if (!isset($_SESSION['admin_token']) || empty($_SESSION['admin_token'])) {
    echo json_encode(array('status' => 'error', 'message' => 'Unauthorized'));
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id_recipe']) ? $_POST['id_recipe'] : NULL;
    if ($id != NULL) {
        $sql = 'DELETE FROM users WHERE id = ?';
        $conn = db_connect();
        $dem = $conn->prepare($sql);
        if($dem->execute([$id])){
            $response = array('status' => 'success', 'message' => 'User deleted successfully');
            echo json_encode($response);
            exit();
        } else {
            $response = array('status' => 'error', 'message' => 'User not deleted');
            echo json_encode($response);
            exit(); 
        }

       

       
    } else {
        $response = array('status'=> 'error','message'=> 'invalid id or user not found');
        echo json_encode($response);
        exit();
    }
}
?>
