<?php
include '../../../functions/db.php';

session_start();

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = 'SELECT *  FROM `personal_info` where user_id = ?';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute([$_SESSION['user_id']]);
    $info = $dem->fetch(PDO::FETCH_ASSOC);
    
    if($result){
        $response = array('status' => 'success','info' => $info);
        echo json_encode($response);
        exit();
    }else{
        $response = array('status' => 'error','message' => 'Something went wrong');
        echo json_encode($response);
        exit();
    }
    
}


?>