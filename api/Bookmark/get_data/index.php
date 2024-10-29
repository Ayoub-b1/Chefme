<?php
include '../../../functions/db.php';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $bookmarked_recipes = isset($_POST['bookmarked_recipes']) ? json_decode($_POST['bookmarked_recipes']) : array();
    $placeholders = rtrim(str_repeat('?,', count($bookmarked_recipes)), ',');
    $sql = "SELECT * FROM `recipe` 
            INNER JOIN `category` ON recipe.id_category = category.id_category 
            INNER JOIN `cuisine` ON recipe.id_cuisine = cuisine.id_cuisine 
            WHERE recipe.id_recipe IN ($placeholders)";
    $conn = db_connect();
    $dem = $conn->prepare($sql);
    $result = $dem->execute($bookmarked_recipes); // Pass the array directly
    $recipes = $dem->fetchAll(PDO::FETCH_ASSOC);
    $response = array('status' => 'success','recipes' => json_encode($recipes));

    echo json_encode($response);
    exit();
}
?>
