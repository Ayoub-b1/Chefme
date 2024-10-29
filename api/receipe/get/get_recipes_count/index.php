<?php
include '../../../../functions/db.php';

session_start();

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = 'SELECT COUNT(id_recipe) as id  FROM `recipe`  ';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute();
    $pfp = $dem->fetchColumn();
    
    if($result){
        $response = array('status' => 'success','receipe' => $pfp);
        echo json_encode($response);
        exit();
    }else{
        $response = array('status' => 'error','message' => 'Something went wrong');
        echo json_encode($response);
        exit();
    }
    
}


?>