<?php
include '../../../functions/db.php';
include '../../../functions/repetead.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cuisine = htmlspecialchars(simpleverife('cuisine'));
    $id = htmlspecialchars(simpleverife('id'));
    $sql = 'SELECT * FROM `cuisine` WHERE id_Cuisine = ?';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute([$id]);
    $categories = $dem->fetchAll(PDO::FETCH_ASSOC);

    // echo json_encode($categories);
    // exit();

    if (count($categories) > 0) {
        $sql = 'UPDATE `cuisine` SET `cuisine` = ? WHERE `id_Cuisine` = ?';
        $dem = $conn->prepare($sql);
        $result = $dem->execute([$cuisine,$id]);
        if ($result) {
            $response = array('status' => 'success', 'message' => 'Category updated successfully');
        }else{
            $response = array('status' => 'error', 'message' => 'Something went wrong');
        }
    } else {
            $response = array('status' => 'success', 'message' => 'Category do not exist');
        }
    
    
    echo json_encode($response);
    exit();
}
