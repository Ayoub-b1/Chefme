<?php
include '../../../functions/db.php';
include '../../../functions/repetead.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = htmlspecialchars(simpleverife('category'));
    $id = htmlspecialchars(simpleverife('id'));
    $sql = 'SELECT * FROM `category` WHERE id_category = ?';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute([$id]);
    $categories = $dem->fetchAll(PDO::FETCH_ASSOC);

    // echo json_encode($categories);
    // exit();

    if (count($categories) > 0) {
        $sql = 'UPDATE `category` SET `Category` = ? WHERE `id_category` = ?';
        $dem = $conn->prepare($sql);
        $result = $dem->execute([$category,$id]);
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
