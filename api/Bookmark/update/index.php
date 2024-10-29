<?php
include '../../../functions/db.php';
session_start();
if (!isset($_SESSION['email']) || empty($_SESSION['email'])){
    http_response_code(401);
    echo json_encode(array('status' => 'error', 'message' => 'Unauthorized'));
    exit;
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $bookmarked_recipes = isset($_POST['bookmarked_recipes']) ? json_encode($_POST['bookmarked_recipes']) : array();
    $sql = 'UPDATE `users` SET `bookmarked_recipes` = ? WHERE `email` = ?';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $stat = $dem->execute([$bookmarked_recipes, $_SESSION['email']]);
    if($stat){
        echo json_encode(array('status' => 'success', 'message' => 'Bookmark updated successfully'));
        exit();
    }else{
        echo json_encode(array('status' => 'error', 'message' => 'Failed to update bookmark'));
        exit();
    }
}
else{
    http_response_code(405);
    echo json_encode(array('status' => 'error', 'message' => 'Method not allowed'));
    exit; // Method not allowed
}


?>