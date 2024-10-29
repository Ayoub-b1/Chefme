<?php
include '../../../functions/db.php';
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = 'SELECT * FROM `cuisine` WHERE id_Cuisine != 0';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute();
    $cuisines = $dem->fetchAll(PDO::FETCH_ASSOC);
    $response = array('status' => 'success','cuisines' => $cuisines);

    echo json_encode($response);
    exit();
    
}


?>