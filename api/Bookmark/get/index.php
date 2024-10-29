<?php
include '../../../functions/db.php';
session_start();
if (!isset($_SESSION['email']) || empty($_SESSION['email'])){
    http_response_code(401);
    echo json_encode(array('status' => 'error', 'message' => 'Unauthorized'));
    exit;
}
if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $sql = 'SELECT bookmarked_recipes FROM `users` WHERE email = ?';
        $conn = db_connect();
        $dem = $conn->prepare($sql);
        $result = $dem->execute([$_SESSION['email']]);
        $bookmarked_recipes = $dem->fetch(PDO::FETCH_ASSOC);
        $response = array('status' => 'success','bookmarked_recipes' => json_encode($bookmarked_recipes));
    
        echo json_encode($response);
        exit();
        
}
else{
    http_response_code(405);
    echo json_encode(array('status' => 'error', 'message' => 'Method not allowed'));
    exit; // Method not allowed
}



?>