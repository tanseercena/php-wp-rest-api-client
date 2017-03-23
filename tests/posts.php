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
$post = $post_obj->getPost(1734);       // Take post id as parameter
echo "<pre>";
print_r($post);