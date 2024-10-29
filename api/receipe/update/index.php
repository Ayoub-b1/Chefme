<?php
include '../../../functions/db.php';
include '../../../functions/repetead.php';
session_start();

// Get the recipe ID
if(isset($_POST['recipe_id']) && !empty($_POST['recipe_id'])) {
    $recipe_id = $_POST['recipe_id'];
} else {
    // Echo an error message if recipe ID is not provided
    echo json_encode(array('status' => 'error', 'message' => 'Recipe ID not provided'));
    exit();
}

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

    // Check if file is uploaded
    if(isset($_FILES['recipe_img']) && !empty($_FILES['recipe_img']['tmp_name'])) {
        $recipe_img = $_FILES['recipe_img'];

        // File upload logic
        $uploadDirectory = '../../../uploads/recipes/';
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true); // Creates the directory recursively
        }

        $filename = uniqid() . '_' . basename($recipe_img['name']);
        $destination = $uploadDirectory . $filename;

        if (move_uploaded_file($recipe_img['tmp_name'], $destination)) {
            $uploadDirectory2 = './uploads/recipes/';
            $imagePath = 'uploads/recipes/' . $filename;
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to move the uploaded image'));
            exit();
        }
    }

    // Update existing recipe
    $conn= db_connect();
    if (isset($imagePath)) {
        $sql = 'UPDATE `recipe` SET `title`=?, `description`=?, `Ingredient`=?, `Instructions`=?, `preparation_time`=?, `cooking_time`=?, `total_time`=?, `difficulty_level`=?, `id_category`=?, `id_cuisine`=?, `calories`=?, `servings`=?, `id_creator`=?, `recipe_img`=? WHERE `id_recipe`=?';
        $dem = $conn->prepare($sql);
        $stat = $dem->execute([$title, $description, $ingredients, $instructions, $preparation_time, $Cooking_time, $total_time, $recipe_difficulty, $categorie, $Cuisine, $calories, $servings, $_SESSION['user_id'], $imagePath, $recipe_id]);
    } else {
        $sql = 'UPDATE `recipe` SET `title`=?, `description`=?, `Ingredient`=?, `Instructions`=?, `preparation_time`=?, `cooking_time`=?, `total_time`=?, `difficulty_level`=?, `id_category`=?, `id_cuisine`=?, `calories`=?, `servings`=?, `id_creator`=? WHERE `id_recipe`=?';
        $dem = $conn->prepare($sql);
        $stat = $dem->execute([$title, $description, $ingredients, $instructions, $preparation_time, $Cooking_time, $total_time, $recipe_difficulty, $categorie, $Cuisine, $calories, $servings, $_SESSION['user_id'], $recipe_id]);
    }

    if($stat){
        echo json_encode(array('status' => 'success', 'message' => 'Recipe updated successfully'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to update recipe'));
    }
}
