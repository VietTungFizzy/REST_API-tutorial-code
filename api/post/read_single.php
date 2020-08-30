<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instantiate DB & connect
$database = new Database();
$conn = $database->connect();

//Instantiate Blog post object
$post = new Post($conn);

//Get ID
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get post
$post->read_single();

$post_array = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name
);

//Make JSON
print_r(json_encode($post_array));