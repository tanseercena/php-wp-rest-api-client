<?php

/**
 * @author Tanseer
 * @copyright 2017
 */

require_once "../autoload.php";

// Creating WP Client 
$wp_client = new WP_Client("http://decentv.com",'decentv','KingKhan$110');

// Get All Posts
$post_obj = $wp_client->wp_post();
/*$params = array(
    'context' =>'view' //embed,edi default view
);
*/

//$all_posts = $post_obj->getPosts(); // we can also pass params

// Get Single Post

//$post = $post_obj->getPost(1734);       // Take post id as parameter

// Create new Post
$post_data = array(
    'title' => 'This is test REST API Post',
    'content' => "This is simple content for REST API Post creation function",
    'status' => 'publish'   // Default Draft
);  // See Wordpress Documentation for more Fields

//$post = $post_obj->createPost($post_data);

// Update Post
$post_id = 1980;
$post_data = array(
    'status' => 'publish',
    'categories' => array(151)      // can take multiple categories 
);// You put any field you want to update see worpdress documentation 

//$post_data = $post_obj->updatePost($post_id,$post_data);

// Delete Post
$post_id = 1980;
$params = array(
    'force' => true
);
//$post_ret = $post_obj->deletPost($post_id);        // Optional Second parameter for permanently deletion



