<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
    Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instantiate DB & connect
$database = new Database();
$conn = $database->connect();

//Instantiate Blog post object
$post = new Post($conn);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$post->id = $data->id;

//Delete post
if($post->delete()) {
    echo json_encode(
        array('message' => 'Post deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Post not deleted')
    );
}