<?php
include '../../../functions/db.php';

function decodeRecipeFields($recipe)
{
    $decodedRecipe = array();
    foreach ($recipe as $key => $value) {
        $decodedRecipe[$key] = html_entity_decode($value);
    }
    return $decodedRecipe;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : NULL;
    if ($id != NULL) {
        $sql = 'SELECT recipe.*, users.name, users.lastname, users.email, category.*, cuisine.* 
        FROM `recipe` 
        INNER JOIN `users` ON recipe.id_creator = users.id  
        LEFT JOIN `category` ON recipe.id_category = category.id_category 
        INNER JOIN `cuisine` ON recipe.id_cuisine = cuisine.id_cuisine 
        WHERE recipe.id_recipe = ?';

        $conn = db_connect();
        $dem = $conn->prepare($sql);
        $result = $dem->execute([$id]);
        $recipe = $dem->fetch(PDO::FETCH_ASSOC);

        // Decode HTML entities for all recipe fields
        $decodedRecipe = decodeRecipeFields($recipe);

        $response = array('status' => 'success', 'recipe' => $decodedRecipe);

        echo json_encode($response);
        exit();
    } else {
        $response = array('status' => 'error', 'message' => 'invalid id or recipe not found');
        echo json_encode($response);
        exit();
    }
}
