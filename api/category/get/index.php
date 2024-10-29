<?php
include '../../../functions/db.php';
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = 'SELECT * FROM `category` WHERE id_category != 0';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute();
    $categories = $dem->fetchAll(PDO::FETCH_ASSOC);
    $response = array('status' => 'success','categories' => $categories);

    echo json_encode($response);
    exit();
    
}


?>