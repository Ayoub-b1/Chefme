<?php
include '../../../functions/db.php';
include '../../../functions/repetead.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cuisine = htmlspecialchars(simpleverife('Cuisine'));

    $sql = 'SELECT * FROM `cuisine` WHERE Cuisine = ?';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute([$cuisine]);
    $categories = $dem->fetchAll(PDO::FETCH_ASSOC);

    // echo json_encode($categories);
    // exit();

    if (count($categories) > 0) {
        $response = array('status' => 'error', 'message' => 'Cuisine already exists');
    } else {
        $sql = 'INSERT INTO `cuisine` (`Cuisine`) VALUES (?)';
        $dem = $conn->prepare($sql);
        $result = $dem->execute([$cuisine]);
        if ($result) {
            $response = array('status' => 'success', 'message' => 'Cuisine added successfully');
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to add Cuisine');
        }
    }
    
    echo json_encode($response);
    exit();
}
