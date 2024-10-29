<?php
include '../../../functions/db.php';
include '../../../functions/repetead.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = htmlspecialchars(simpleverife('id'));

    $sql = 'SELECT * FROM `cuisine` WHERE id_Cuisine = ?';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute([$id]);
    $categories = $dem->fetchAll(PDO::FETCH_ASSOC);

    // echo json_encode($categories);
    // exit();

    if (count($categories) > 0) {
        $sql = 'DELETE FROM `cuisine` WHERE id_Cuisine = ?';
        $dem = $conn->prepare($sql);
        $result = $dem->execute([$id]);
        if ($result) {
            $response = array('status' => 'success', 'message' => 'Category deleted successfully');
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to delete Category');
        }
    } else {
        $response = array('status' => 'error', 'message' => 'Category not found');
        
    }
    
    echo json_encode($response);
    exit();
}
