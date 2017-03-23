<?php

/**
 * @author Tanseer
 * @copyright 2017
 * WP_Request Class
 */

class WP_Request {
    private $url;
    private $method;
    private $headers = array();
    private $params = array();
    private $post_data = array();
    private $multi_part = false;
    
    public function __construct($url = '',$method = '',$headers = array(),$params = array(),$post_data = array(),$multi_part = false){
        $this->url = $url;
        $this->method = $method;
        $this->set_headers($headers);
        $this->set_post_data($post_data);
        $this->set_is_multipart($multi_part);
    }
    
    public function set_headers( $headers ) {
		$this->headers = array();
		foreach ( (array) $headers as $name => $content ) {
			$this->add_header( $name, $content );
		}
	}
    
    public function add_header( $name, $content ) {
		$this->headers[ $name ] = $content;
	}
    
    public function get_headers() {
		return $this->headers;
	}
    
    public function get_processed_headers() {
		$processed_headers = array();
		foreach ( $this->headers as $name => $content ) {
			$processed_headers[] = sprintf( '%s: %s', $name, $content );
		}
		return $processed_headers;
	}
    
    public function set_post_data($post_data){
        $this->post_data = $post_data;
    }
    
    public function has_post_data() {
		return ! empty( $this->post_data );
	}
    
	public function get_post_data() {
		return $this->post_data;
	}
    
    public function set_is_multipart( $is_multipart ) {
		$this->multi_part = $is_multipart;
        if($this->is_multipart()){      // If set true multipart
            $this->add_header( 'Content-Type', 'multipart/form-data' );
        }
		
	}
    
	public function is_multipart() {
		return $this->multi_part;
	}
    
    public function set_url($url){
        $this->url = $url;
    }
    public function get_url(){
        return $this->url;
    }
    
    public function set_method($method){
        $this->method = $method;
    }
    public function get_method(){
        return $this->method;
    }
    
    
    function build_url( $url, $path, $params ) {
		if ( $path ) {
			$url = sprintf( '%s/%s', rtrim( $url, '/\\' ), ltrim( $path, '/\\' ) );
		}
		if ( ! parse_url( $url, PHP_URL_QUERY ) && ! empty( $params ) ) {
			$url .= '?';
		}
		if ( ! empty( $params ) ) {
			$url .= http_build_query( $params );
		}
		return $url; 
	}
    
}