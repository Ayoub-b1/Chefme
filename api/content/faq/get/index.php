<?php
include '../../../../functions/db.php';
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = 'SELECT * FROM `content_faq`';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute();
    $faq = $dem->fetchAll(PDO::FETCH_ASSOC);
    $response = array('status' => 'success','faq' => $faq);

    echo json_encode($response);
    exit();
    
}


?>