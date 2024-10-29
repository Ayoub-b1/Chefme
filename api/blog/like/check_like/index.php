<?php
// Database connection parameters
include '../../../functions/db.php';
session_start();
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    http_response_code(401);
    echo json_encode(array('status' => 'error', 'message' => 'Unauthorized'));
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $conn = db_connect();
        
        if (isset($_GET['post_id']) ) {
            
            $post_id = $_GET['post_id'];
            $user_id = $_SESSION['user_id'];
            
            // Check if user has already liked the post
            $stmt = $conn->prepare("SELECT  * FROM like WHERE post_id = :post_id AND user_id = :user_id");
            $stmt->bindParam(':post_id', $post_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $response = array('status' => 'success', 'like' => 'true');
            }
            else{
                $response = array('status' => 'success', 'like' => 'false');
            }
            echo json_encode($response);
        } else {
           
            $response = array('status' => 'error', 'message' => 'Invalid request');
            echo json_encode($response);
        }
    } catch (PDOException $e) {
        $response = array('status' => 'error', 'message' => 'Database error: ' . $e->getMessage());
        echo json_encode($response);
    }
}else{
    http_response_code(405);
}

// Close connection
$conn = null;
