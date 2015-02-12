<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FormValidationException extends ARC_Exception {

    function __construct()
    {
        parent::__construct($message = '', $code = '0');
    }
}