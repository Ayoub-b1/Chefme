<?php
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $file_content = file_get_contents(__DIR__ . '/about.txt'); 

    // Prepare the response
    $response = array(
        'status' => 'success',
        'privacy' => html_entity_decode($file_content) // Add the file content to the response
    );

    echo json_encode($response);
    exit();
    
}else   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['privacy'])) {
        // Get the new content from the form
        $new_content = $_POST['privacy'];

        // Write the new content to the file
        file_put_contents(__DIR__ . '/about.txt', $new_content);

        // Prepare success response
        $response = array(
            'status' => 'success',
            'message' => 'File content has been updated successfully'
        );
    } else {
        // Prepare error response if form data is not present
        $response = array(
            'status' => 'error',
            'message' => 'Form data not provided'
        );
    }
echo json_encode($response);
exit();
}


?>