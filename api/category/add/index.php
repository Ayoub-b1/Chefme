<?php
include '../../../functions/db.php';
include '../../../functions/repetead.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = htmlspecialchars(simpleverife('category'));

    $sql = 'SELECT * FROM `category` WHERE Category = ?';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute([$category]);
    $categories = $dem->fetchAll(PDO::FETCH_ASSOC);

    // echo json_encode($categories);
    // exit();

    if (count($categories) > 0) {
        $response = array('status' => 'error', 'message' => 'Category already exists');
    } else {
        $sql = 'INSERT INTO `category` (`Category`) VALUES (?)';
        $dem = $conn->prepare($sql);
        $result = $dem->execute([$category]);
        if ($result) {
            $response = array('status' => 'success', 'message' => 'Category added successfully');
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to add Category');
        }
    }
    
    echo json_encode($response);
    exit();
}
