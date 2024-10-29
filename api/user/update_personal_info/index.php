<?php
include '../../../functions/db.php';
include '../../../functions/repetead.php';

session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $bio = isset($_POST['bio']) ? htmlspecialchars($_POST['bio']) : '';
    $cuisine = isset($_POST['cuisine']) ? htmlspecialchars($_POST['cuisine']) : '';
    $allergies = isset($_POST['allergies']) ? htmlspecialchars($_POST['allergies']) : '';

    $sql = 'UPDATE `personal_info` SET Bio = ? , prefered_cuisine=? ,allergies= ? WHERE user_id = ?';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute( [$bio, $cuisine, $allergies, $_SESSION['user_id']]);
    
    
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