<?php
include '../../../functions/db.php';
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = 'SELECT id , name , lastname , email , profile_pic FROM users ';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute();
    $recipes = $dem->fetchAll(PDO::FETCH_ASSOC);
    $response = array('status' => 'success','users' => $recipes);

    echo json_encode($response);
    exit();
    
}


 

?>