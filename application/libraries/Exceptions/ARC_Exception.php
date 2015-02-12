<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ARC_Exception extends Exception {

    protected $errors;

    function __construct( $message = "", $code = 0, Exception $previous = null )
    {
        parent::__construct( $message, $code, $previous );
        if( strlen( $message ) > 0 ) $this->errors[ 'error' ] = $message;
    }

    public function errors( $json = true )
    {
        if( $json ) return json_encode( $this->errors );

        return $this->errors;
    }
}