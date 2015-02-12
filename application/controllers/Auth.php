<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Auth
 *
 * @property ARC_Session $session
 * @property User $user
 */
class Auth extends ARC_Controller {

    function __construct()
    {
        parent::__construct();

        $this->resource( 'post', [ 'type' => 'library', 'name' => 'user' ]);
        $this->set( 'view', 'login' )->set( 'data', null )->set( 'messages', [] );
    }

    /**
     * URI - Site-wide entry point
     * NO AUTH redirect Location
     *
     * @return mixed
     */
    public function index()
    {
        if( $this->session->valid ) redirect( 'home' );

        return $this->login();
    }

    /**
     * URI - POST Location for system login
     *
     * @return mixed
     */
    public function login()
    {
        $this->set( 'view', 'login' );

        return $this->show();
    }

    /**
     * URI - POST Location for password reset
     *
     * @return mixed
     */
    public function reset()
    {
        $this->set( 'view', 'reset' );

        return $this->show();
    }

    /**
     * URI - Location for logout redirect
     *
     * @return mixed
     */
    public function logout()
    {
        $this->set( 'view', 'login' );

        return $this->show();
    }
}