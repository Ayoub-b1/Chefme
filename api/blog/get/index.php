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
        function fetchItems($conn, $page, $perPage)
        {
            $start = ($page - 1) * $perPage;
            $stmt = $conn->prepare("SELECT posts.*, users.name, users.lastname, users.email, users.profile_pic, post_media.media_id , post_media.url , post_media.post_id AS media_postid
            FROM posts
            LEFT JOIN users ON posts.creator_id = users.id
            LEFT JOIN post_media ON posts.post_id = post_media.post_id
            ORDER BY posts.post_date DESC LIMIT :start, :perPage");
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $items;
        }

        if (isset($_GET['page']) && isset($_GET['perPage'])) {
            $page = intval($_GET['page']);
            $perPage = intval($_GET['perPage']);

            $items = fetchItems($conn, $page, $perPage);

            $response = array('status' => 'success', 'items' => $items);
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
