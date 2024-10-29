<?php
include '../../../functions/db.php';




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id_recipe']) ? $_POST['id_recipe'] : NULL;
    if ($id != NULL) {
        $sql = 'DELETE FROM recipe WHERE id_recipe = ?';
        $conn = db_connect();
        $dem = $conn->prepare($sql);
        if($dem->execute([$id])){
            $response = array('status' => 'success', 'message' => 'recipe deleted successfully');
            echo json_encode($response);
            exit();
        } else {
            $response = array('status' => 'error', 'message' => 'recipe not deleted');
            echo json_encode($response);
            exit(); 
        }

       

       
    } else {
        $response = array('status'=> 'error','message'=> 'invalid id or recipe not found');
        echo json_encode($response);
        exit();
    }
}
?>
