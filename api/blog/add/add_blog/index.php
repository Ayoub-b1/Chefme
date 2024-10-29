<?php

include '../../../../functions/db.php';
include '../../../../functions/repetead.php';
session_start();

function isImage($file)
{
    $image_info = getimagesize($file);
    return $image_info !== false;
}

function isVideo($file)
{
    $video_types = array(
        'video/mp4',
        'video/mpeg',
        'video/quicktime',
    );

    $file_info = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($file_info, $file);
    finfo_close($file_info);

    return in_array($mime_type, $video_types);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_text = isset($_POST['post_text']) ? htmlspecialchars($_POST['post_text']) : '';
    $images = isset($_FILES['image[]']) ? $_FILES['image[]'] : array();

    $media_urls = array(); // Initialize an array to hold media URLs

    if (!empty($_FILES['image'])) {

        foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {

            if ($_FILES['image']['error'][$key] === UPLOAD_ERR_OK) {

                $file_name = $_FILES['image']['name'][$key];
                $file_tmp = $_FILES['image']['tmp_name'][$key];
                $file_size = $_FILES['image']['size'][$key];

                $file_name = preg_replace("/[^a-zA-Z0-9_.]/", "_", $file_name);
                $unique_name = uniqid() . '_' . $file_name;

                $upload_dir = '../../../../uploads/blogs/';
                $upload_path = $upload_dir . $unique_name;

                if (move_uploaded_file($file_tmp, $upload_path)) {

                    if (isImage($upload_path)) {
                        $type = 'image';
                    } elseif (isVideo($upload_path)) {
                        $type = 'video';
                    } else {
                        $response = array('status' => 'error','message' => 'Invalid file type');
                        echo json_encode($response);
                        exit(); 
                    }
                    $uploaded_media = './uploads/blogs/' . $unique_name;
                    $media_urls[] = array('type' => $type, 'url' => $uploaded_media); // Add media URL to the array

                } else {
                    echo "Failed to move file.";
                }
            } else {
                echo "Upload error: " . $_FILES['image']['error'][$key];
            }
        }

        // Encode media URLs array to JSON
        $media_json = json_encode($media_urls);

        $conn = db_connect();
        $stmt = $conn->prepare("INSERT INTO posts (creator_id, post_text) VALUES (?, ?)");
        $stmt->bindParam(1, $_SESSION['user_id']);
        $stmt->bindParam(2, $post_text);
        $res = $stmt->execute();

        if($res) {
            $post_id = $conn->lastInsertId();

            // Insert post media into post_media table only if media URLs are present
            if (!empty($media_urls)) {
                $stmt = $conn->prepare("INSERT INTO post_media (post_id, url) VALUES (?, ?)");
                $stmt->bindParam(1, $post_id);
                $stmt->bindParam(2, $media_json); // Store media URLs as JSON
                $res2 = $stmt->execute();

                if($res2){
                    $response = array('status' => 'success','message' => 'Post added successfully');
                    echo json_encode($response);
                    exit();
                } else {
                    $response = array('status' => 'error','message' => 'Failed to add post media');
                    echo json_encode($response);
                    exit();
                }
            } else {
                $response = array('status' => 'success','message' => 'Post added successfully');
                echo json_encode($response);
                exit();
            }
        } else {
            $response = array('status' => 'error','message' => 'Failed to add post');
            echo json_encode($response);
            exit();
        }

    } else {
        // No files uploaded, only insert the post text
        $conn = db_connect();
        $stmt = $conn->prepare("INSERT INTO posts (creator_id, post_text) VALUES (?, ?)");
        $stmt->bindParam(1, $_SESSION['user_id']);
        $stmt->bindParam(2, $post_text);
        $res = $stmt->execute();

        if($res) {
            $response = array('status' => 'success','message' => 'Post added successfully');
            echo json_encode($response);
            exit();
        } else {
            $response = array('status' => 'error','message' => 'Failed to add post');
            echo json_encode($response);
            exit();
        }
    }
}
?>
