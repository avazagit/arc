<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Mock
 * This controller provides testing routes for to mock the CudaTel System
 * (EXCLUDE FROM PRODUCTION)
 *
 * @author Josh Murray
 */

class Mock extends ARC_Controller{

    protected $details;

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->gui();
    }

    function gui()
    {
        $this->set( 'template', 'main');
        $this->set( 'view', 'mock' );

        $this->show();
    }
}
