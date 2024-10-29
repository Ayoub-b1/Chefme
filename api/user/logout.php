<?php

session_start();

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    session_destroy();
    $response = array('status' => 'success','message' => 'Logged out successfully');
    echo json_encode($response);
    exit();
}
else{
    http_response_code(400);
    $response = array('status' => 'error','message' => 'Invalid request');
    echo json_encode($response);
    exit();
}


