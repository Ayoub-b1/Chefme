<?php
include '../../../functions/db.php';

session_start();

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = 'SELECT verified  FROM `users` where email = ?';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute([$_SESSION['email']]);
    $verified = $dem->fetch(PDO::FETCH_ASSOC);
    
    if($result){
        $response = array('status' => 'success','verified' => $verified);
        echo json_encode($response);
        exit();
    }else{
        $response = array('status' => 'error','message' => 'Something went wrong');
        echo json_encode($response);
        exit();
    }
    
}


?>