<?php
include '../../../functions/db.php';

session_start();

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = 'SELECT name, lastname , email, profile_pic  FROM `users` where email = ?';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute([$_SESSION['email']]);
    $cuisines = $dem->fetchAll(PDO::FETCH_ASSOC);
    
    if($result){
        $response = array('status' => 'success','info' => $cuisines);
        echo json_encode($response);
        exit();
    }else{
        $response = array('status' => 'error','message' => 'Something went wrong');
        echo json_encode($response);
        exit();
    }
    
}


?>