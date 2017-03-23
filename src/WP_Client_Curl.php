<?php

/**
 * @author Tanseer
 * @copyright 2017
 * WP_Client_Curl Class
 */

class WP_Client_Curl{
    private $response_codes = array( 200, 201, 301, 302 );
    
    public function __construct(){
        
    }
    
    public function send_api_request(WP_Request $request){
        
        $curl = curl_init($request->get_url());
        
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_FAILONERROR, false );
		curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, $request->get_method() );
        
        if ( $request->has_post_data() ) {
			curl_setopt( $curl, CURLOPT_POSTFIELDS, $request->get_post_data() );
		}
        
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $request->get_processed_headers() );
        
        $response = curl_exec( $curl );
        $info     = curl_getinfo( $curl );
		$error    = curl_error( $curl );
		curl_close( $curl );
        
        $response_code = $this->get_response_code_from_request( $info );
		if ( ! $this->is_valid_response_code( $response_code ) ) {
			return $this->handle_error( sprintf( 'HTTP error for request; response: %s', $response ), $response_code );
		} elseif ( ! $response ) {
			return $this->handle_error( sprintf( 'Curl error: %s; info: %s', $error, var_export( $info, true ) ), 'curl-error' );
		}
        
        return $this->handle_success( $response );
    }
    
    private function get_response_code_from_request( $info ) {
		if ( is_array( $info ) && isset( $info['http_code'] ) ) {
			return $info['http_code'];
		}
		return null;
	}
    
    protected function handle_error( $message, $code ) {
		throw new Exception( $message, $code );
	}
    
    protected function is_valid_response_code( $response_code ) {
		return in_array( $response_code, $this->response_codes );
	}
    
    
    protected function handle_success( $body ) {
		$decoded_body = json_decode( $body );
		if ( ! $decoded_body ) {
			throw new Exception( 'Failed to decode data from endpoint', 'invalid-json' );
		}
		if ( isset( $decoded->error ) ) {
			if ( isset( $decoded_body->error_description ) ) {
				$error_message = $decoded_body->error_description;
			} elseif ( isset( $decoded_body->message ) ) {
				$error_message = $decoded_body->message;
			} else {
				$error_message = '';
			}
	
			return $this->handle_error( $error_message, $decoded_body->error );
		}
		return $decoded_body;
	}
    
}

