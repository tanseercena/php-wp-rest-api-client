<?php

/**
 * @author Tanseer
 * @copyright 2017
 * WP_POST class
 */

class WP_Post{
    private $req;
    private $wp_client;
    
    public function __construct($wp_client,WP_Request $request){
        $this->wp_client = $wp_client;
        $this->request = $request;   
    }
    
    /**
     * Get All Posts
     * Arg: $params (array/string)
     */
    public function getPosts($params =''){
     $url = "wp-json/wp/v2/posts";
     $method = $this->wp_client->get_method();
     return $this->wp_client->send_request_api($url,$method,$params);   
    }
    
    /**
     * Get Single Post 
     * Arg: $id (integer)
     * 
     */
     public function getPost($id=0){
        if($id == 0){
            throw new Exception( 'Post ID is request.' );
        }
        
        $url = "wp-json/wp/v2/posts/".$id;
        $method = $this->wp_client->get_method();
        return $this->wp_client->send_request_api($url,$method); 
     }
}