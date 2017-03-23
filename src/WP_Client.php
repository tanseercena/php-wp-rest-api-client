<?php

/**
 * @author Tanseer
 * @copyright 2017
 * WP_Client Class
 */

class WP_Client{
    
    const METHOD_GET = "GET";
    const METHOD_POST = "POST";
    const METHOD_HEAD = "HEAD";
    const METHOD_PUT = "PUT";
    const METHOD_DELETE = "DELETE";
    const METHOD_PATCH = "PATCH";
    
    private $username;
    private $password;
    private $end_url;
    protected $request_methods = array(
		self::METHOD_GET,
		self::METHOD_POST,
		self::METHOD_HEAD,
		self::METHOD_PUT,
		self::METHOD_DELETE,
		self::METHOD_PATCH
	);
    
    private $request;
    private $curl_req;
    
    /**
    *  WP_CLIENT Constructor
    *  Args: $end_url (string), $username (string), $password(string)
    */
    public function __construct($end_url,$username,$password){
        $this->end_url = $end_url;
        $this->username = $username;
        $this->password = $password;
        
        $this->request = new WP_Request($this->end_url);   
        $this->curl_req = new WP_Client_Curl();  
    }
    
    private function authenticate_request(){
        if($this->username && $this->password){
            $auth_str = sprintf( 'Basic %s', base64_encode( $this->username . ':' . $this->password ) );
            $this->request->add_header('Authorization',$auth_str);
        }
    }
    
    private function send_request(){
        $json_data = json_encode($this->request->get_post_data());
        
        $this->request->add_header( 'Content-Type', 'application/json' );
		$this->request->add_header( 'Content-Length', strlen( $json_data ) );
        
        $this->request->set_post_data($json_data);        // Update array data with json
        
        $method = $this->request->get_method(); 
		if ( ! $this->is_valid_request_method( $method ) ) {
			throw new Exception( sprintf( 'Invalid request $method: %s; should be one of %s', $method, implode( ',', $this->get_valid_request_methods() ) ) );
		}
        
        return $this->curl_req->send_api_request($this->request);
    }
    
     function send_request_api($path,$method,$params ='',$post_data = array(), $headers = array(), $is_multipart = false){
        $url = $this->request->build_url( $this->end_url, $path, $params );
        
        $this->request->set_url($url);
        $this->request->set_method($method);
        $this->request->set_headers($headers);
        $this->request->set_post_data($post_data);
        $this->request->set_is_multipart($is_multipart);
        
        $this->authenticate_request();
        return $this->send_request();
    }
    
    protected function is_valid_request_method( $method ) {
		return in_array( $method, $this->get_valid_request_methods() );
	}
	protected function get_valid_request_methods() {
		return $this->request_methods;
	}
    
    function get_method(){
        return self::METHOD_GET;
    }
    
    function post_method(){
        return self::METHOD_POST;
    }
    function head_method(){
        return self::METHOD_HEAD;
    }
    function put_method(){
        return self::METHOD_PUT;
    }
    function delete_method(){
        return self::METHOD_DELETE;
    }
    function patch_method(){
        return self::METHOD_PATCH;
    }
    
    
    /**
     * WP_Post Class Object Creation
     * return WP_POST instance
     * 
     */
    function wp_post(){
        return new WP_Post($this,$this->request);
    }
    
    
    
}

