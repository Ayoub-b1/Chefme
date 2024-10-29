<?php


include '../../../../functions/db.php';
include '../../../../functions/repetead.php';
session_start();


$conn = db_connect();
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $question1 = $_POST['question1'];
    $answer1 = $_POST['Answer1'];
    $question2 = $_POST['question2'];
    $answer2 = $_POST['Answer2'];
    $question3 = $_POST['question3'];
    $answer3 = $_POST['Answer3'];
    
    $sql = "UPDATE content_faq
    SET
        question = ?,
        answer = ?
    WHERE
        id = 1;
    
    UPDATE your_table_name
    SET
        question = ?,
        answer = ?
    WHERE
        id = 2;
    
    UPDATE your_table_name
    SET
        question = ?,
        answer = ?
    WHERE
        id = 3;
    ";
    $prep = $conn->prepare($sql);
    $result = $prep->execute([$question1, $answer1, $question2, $answer2, $question3, $answer3]);

    
    if($result){
        $response = array('status' => 'success','message' => 'FAQ updated successfully');

        echo json_encode($response);
        exit();
        
    }else{
        $response = array('status' => 'error','message' => 'Failed to update FAQ');
        
        echo json_encode($response);
        exit();
}
}


?>