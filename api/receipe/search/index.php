<?php
include '../../../functions/db.php';
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    $conn = db_connect();
    $searchQuery = htmlspecialchars($_GET['query']);

    $sql = "SELECT * FROM `recipe` INNER JOIN `category` ON recipe.id_category = category.id_category INNER JOIN `cuisine` ON recipe.id_cuisine = cuisine.id_cuisine WHERE title LIKE :query OR description LIKE :query OR Ingredient LIKE :query OR difficulty_level LIKE :query OR cuisine LIKE :query OR category LIKE :query";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':query', '%' . $searchQuery . '%');

    $etat = $stmt->execute();

    if($etat){
        if($stmt->rowCount() === 0) {
            echo json_encode(array('status' => 'empty', 'message' => 'No results found'));
            exit();
        }else{
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('status' => 'success', 'results' => $results));
            exit();
        }
    }else{
        echo json_encode(array('status' => 'error', 'message' => 'Something went wrong'));
        exit();
    }
}
?>
