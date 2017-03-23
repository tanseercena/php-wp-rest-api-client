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
     * Return Posts Array
     */
    public function getPosts($params =''){
     $url = "wp-json/wp/v2/posts";
     $method = $this->wp_client->get_method();
     return $this->wp_client->send_request_api($url,$method,$params);   
    }
    
    /**
     * Get Single Post 
     * Arg: $id (integer)
     * Return Post object
     */
     public function getPost($id=0){
        if($id == 0){
            throw new Exception( 'Post ID is required.' );
        }
        
        $url = "wp-json/wp/v2/posts/".$id;
        $method = $this->wp_client->get_method();
        return $this->wp_client->send_request_api($url,$method); 
     }
     
     /**
      * Create Post
      * Arg: $post_data (array)
      * 
      */
      public function createPost($post_data = array()){
        if(!is_array($post_data)){
            throw new Exception( 'Post Data must contain required fields data.' );
        }
        
        $url = "wp-json/wp/v2/posts/";
        $method = $this->wp_client->post_method();
        return $this->wp_client->send_request_api($url,$method,"",$post_data); 
      }
      
      /**
       * Update Post
       * Arg $post_id (integer), $post_data(array)
       * Return Post Object
       */
       public function updatePost($post_id = 0,$post_data =array()){
        if($post_id == 0){
            throw new Exception( 'Post ID is required.' );
        }
        
        if(!is_array($post_data)){
            throw new Exception( 'Post Data must contain some data' );
        }
        
        $url = "wp-json/wp/v2/posts/".$post_id;
        $method = $this->wp_client->post_method();
        return $this->wp_client->send_request_api($url,$method,"",$post_data);
       }
       
       /**
        * Delete Post
        * Arg: $post_id (integer), $params (array)
        * Return Post Object of trash post 
        */
        public function deletPost($post_id =0,$params = ""){
           if($post_id == 0){
                throw new Exception( 'Post ID is required.' );
           }
           
           $url = "wp-json/wp/v2/posts/".$post_id;
           
           $method = $this->wp_client->delete_method();
           return $this->wp_client->send_request_api($url,$method,$params); 
        }
        
     
}