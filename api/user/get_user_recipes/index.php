<?php
include '../../../functions/db.php';

session_start();

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    
    $sql = 'SELECT recipe.*, users.name, users.lastname, users.email, category.*, cuisine.* 
    FROM `recipe` 
    INNER JOIN `users` ON recipe.id_creator = users.id  
    INNER JOIN `category` ON recipe.id_category = category.id_category 
    INNER JOIN `cuisine` ON recipe.id_cuisine = cuisine.id_cuisine 
    WHERE recipe.id_creator = ?';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute([$_SESSION['user_id']]);
    $recipes = $dem->fetchAll(PDO::FETCH_ASSOC);
    
    if($result){
        $response = array('status' => 'success','recipes' => json_encode($recipes));
        echo json_encode($response);
        exit();
    }else{
        $response = array('status' => 'error','message' => 'Something went wrong');
        echo json_encode($response);
        exit();
    }
    
}


?>