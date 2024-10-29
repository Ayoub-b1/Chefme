<?php
// Database connection parameters
include '../../../functions/db.php';
session_start();
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    http_response_code(401);
    echo json_encode(array('status' => 'error', 'message' => 'Unauthorized'));
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = db_connect();
        
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : '';
        
        if (empty($post_id)) {
            $response = array('status' => 'error', 'message' => 'Missing required parameters');
            echo json_encode($response);
        }else{
            $check = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
            $check->execute([$_SESSION['user_id'], $post_id]);
            if($check->rowCount() > 0){
                $stmt = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
                $stat = $stmt->execute([$_SESSION['user_id'], $post_id]);
                if($stat){
                    $response = array('status' => 'success', 'message' => 'Like removed successfully');
                }else{
                    $response = array('status' => 'error', 'message' => 'Something went wrong');
                }
                echo json_encode($response);
                exit;
            }else{
                $check = $conn->prepare("SELECT * FROM dislikes WHERE user_id = ? AND post_id = ?");
                $check->execute([$_SESSION['user_id'], $post_id]);
                if ($check->rowCount() > 0) {
                
                    $stmt = $conn->prepare("DELETE FROM dislikes WHERE user_id = ? AND post_id = ?");
                    $stat = $stmt->execute([$_SESSION['user_id'], $post_id]);
                }
               
                $stmt2 = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
                $stat2 = $stmt2->execute([$_SESSION['user_id'], $post_id]);
                if($stat2){
                    $response = array('status' => 'success', 'message' => 'Like added successfully');
                }else{
                    $response = array('status' => 'error', 'message' => 'Something went wrong');
                }
                echo json_encode($response);
                exit;
            }
        }
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo "Connection failed: " . $e->getMessage();
    }
}else{
    http_response_code(405);
}

// Close connection
$conn = null;
