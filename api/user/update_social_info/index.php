<?php
include '../../../functions/db.php';
include '../../../functions/repetead.php';

session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $facebook = isset($_POST['facebook']) ? htmlspecialchars($_POST['facebook']) : '';
    $instagram = isset($_POST['instagram']) ? htmlspecialchars($_POST['instagram']) : '';
    $number = isset($_POST['number']) ? htmlspecialchars($_POST['number']) : '';
    $twitter = isset($_POST['twitter']) ? htmlspecialchars($_POST['twitter']) : '';

    $sql = 'UPDATE `personal_info` SET  facebook=? ,instagram= ? , number = ? , twitter_x = ? WHERE user_id = ?';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute( [$facebook, $instagram, $number, $twitter, $_SESSION['user_id']]);
    
    
    if($result){
        $response = array('status' => 'success','message' => 'Personal info updated successfully');
        echo json_encode($response);
        exit();
    }else{
        $response = array('status' => 'error','message' => 'Something went wrong');
        echo json_encode($response);
        exit();
    }
    
}


?>