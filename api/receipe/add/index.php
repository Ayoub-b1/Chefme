<?php
include '../../../functions/db.php';
include '../../../functions/repetead.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars(simpleverife('title'));
    $description = htmlspecialchars(simpleverife('description'));
    $preparation_time = htmlspecialchars(simpleverife('preparation_time'));
    $Cooking_time = htmlspecialchars(simpleverife('Cooking_time'));
    $total_time = htmlspecialchars(simpleverife('total_time'));
    $recipe_difficulty = htmlspecialchars(simpleverife('recipe_difficulty'));
    $categorie = htmlspecialchars(simpleverife('categorie'));
    $Cuisine = htmlspecialchars(simpleverife('Cuisine'));
    $calories = htmlspecialchars(simpleverife('calories'));
    $servings = htmlspecialchars(simpleverife('servings'));

    $ingredients = isset($_POST['ingrediants']) ? json_encode($_POST['ingrediants']) : array();
    $instructions = isset($_POST['instructions']) ? json_encode($_POST['instructions']) : array();

    $recipe_img = isset($_FILES['recipe_img']) ? $_FILES['recipe_img'] : array();

    if (
        empty($title) || empty($description) || empty($preparation_time) ||
        empty($Cooking_time) || empty($total_time) || empty($recipe_difficulty) ||
        empty($categorie) || empty($Cuisine) || empty($calories) || empty($servings) ||
        empty($ingredients) || empty($instructions) || empty($recipe_img)
    ) {
        // Echo an error message
        echo json_encode(array('status' => 'error', 'message' => 'Some required fields are empty'));
        exit();
    }else{
        $conn= db_connect();
        if (!empty($recipe_img['tmp_name']) && is_uploaded_file($recipe_img['tmp_name'])) {
            $uploadDirectory = '../../../uploads/recipes/'; 
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true); // Creates the directory recursively
            }
            
            $filename = uniqid() . '_' . basename($recipe_img['name']);
            $destination = $uploadDirectory . $filename;
            
            if (move_uploaded_file($recipe_img['tmp_name'], $destination)) {
                $uploadDirectory2 = './uploads/recipes/'; 
                $imagePath = 'uploads/recipes/' . $filename;
                $sql = 'INSERT INTO `recipe`( `title`, `description`, `Ingredient`, `Instructions`, `preparation_time`, `cooking_time`, `total_time`, `difficulty_level`, `id_category`, `id_cuisine`, `calories`, `servings`, `id_creator`, `recipe_img`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
                $dem = $conn->prepare($sql);
                $stat = $dem->execute([$title, $description, $ingredients, $instructions, $preparation_time, $Cooking_time, $total_time, $recipe_difficulty, $categorie, $Cuisine, $calories, $servings, $_SESSION['user_id'], $imagePath]);
                if($stat){
                    echo json_encode(array('status' => 'success', 'message' => 'Recipe added successfully'));
                }else{
                    echo json_encode(array('status' => 'error', 'message' => 'Failed to add recipe'));
                }
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Failed to move the uploaded image'));
                exit();
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No image uploaded or an error occurred'));
            exit();
        }
    }

}

