<?php
include '../../../functions/db.php';
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = 'SELECT * FROM `recipe` INNER JOIN `category` ON recipe.id_category = category.id_category INNER JOIN `cuisine` ON recipe.id_cuisine = cuisine.id_cuisine ';
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute();
    $recipes = $dem->fetchAll(PDO::FETCH_ASSOC);
    $response = array('status' => 'success','recipes' => $recipes);

    echo json_encode($response);
    exit();
    
}


 

?>