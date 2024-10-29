<?php
include '../../../functions/db.php';




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['post_id']) ? $_POST['post_id'] : NULL;
    if ($id != NULL) {
        $sql = 'DELETE FROM posts WHERE post_id = ?';
        $conn = db_connect();
        $dem = $conn->prepare($sql);
        if($dem->execute([$id])){
            $response = array('status' => 'success', 'message' => 'Post deleted successfully');
            echo json_encode($response);
            exit();
        } else {
            $response = array('status' => 'error', 'message' => 'Post not deleted');
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
