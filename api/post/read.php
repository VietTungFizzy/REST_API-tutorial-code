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

//Blog post query 
$result = $post->read();
//Get row count
$num = $result->rowCount();

//Check if any posts
if($num > 0) {
    //Post array
    $posts_array = array();
    $posts_array['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );

        // Push to "data"
        array_push($posts_array['data'], $post_item);

    }

    // Turn to JSON & output
    echo json_encode($posts_array);
}
else {
    //No Posts
    echo json_encode(
        array('message' => 'No Posts Found')
    );
}