<?php
include '../../../functions/db.php';

session_start();

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = 'SELECT *  FROM `profile_picture`';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute();
    $pfp = $dem->fetchAll(PDO::FETCH_ASSOC);
    
    if($result){
        $response = array('status' => 'success','profile_picture' => $pfp);
        echo json_encode($response);
        exit();
    }else{
        $response = array('status' => 'error','message' => 'Something went wrong');
        echo json_encode($response);
        exit();
    }
    
}


?>