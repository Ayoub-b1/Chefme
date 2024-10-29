<?php
include '../../../functions/db.php';
session_start();
if (!isset($_SESSION['email']) || empty($_SESSION['email'])){
    http_response_code(401);
    echo json_encode(array('status' => 'error', 'message' => 'Unauthorized'));
    exit;
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $lastname = isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : '';
    $profilepic = isset($_POST['pfp']) ? htmlspecialchars($_POST['pfp']) : '';
    if(empty($name) || empty($lastname) || empty($profilepic)){
        
        echo json_encode(array('status' => 'error', 'message' => 'All fields are required'));
        exit();
        
    }
    else{
        $sql = 'UPDATE `users` SET `name` = ?, `lastname` = ?, `profile_pic` = ? WHERE `email` = ?';
        $conn = db_connect();
        $dem = $conn->prepare($sql);
        $stat = $dem->execute([$name, $lastname, $profilepic, $_SESSION['email']]);
        if($stat){
            echo json_encode(array('status' => 'success', 'message' => 'infos updated successfully'));
            exit();
        }else{
            echo json_encode(array('status' => 'error', 'message' => 'Failed to update infos'));
            exit();
        }
    }
}
else{
    http_response_code(405);
    echo json_encode(array('status' => 'error', 'message' => 'Method not allowed'));
    exit; // Method not allowed
}


?>