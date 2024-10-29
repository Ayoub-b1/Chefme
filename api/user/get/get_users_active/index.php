<?php
include '../../../../functions/db.php';

session_start();

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = 'SELECT COUNT(id) as id  FROM `users` WHERE verified = 1 ';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute();
    $pfp = $dem->fetchColumn();
    
    if($result){
        $response = array('status' => 'success','users' => $pfp);
        echo json_encode($response);
        exit();
    }else{
        $response = array('status' => 'error','message' => 'Something went wrong');
        echo json_encode($response);
        exit();
    }
    
}


?>