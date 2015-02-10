<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//TODO http://eddmann.com/posts/storing-php-sessions-file-caches-in-memory-using-tmpfs/

/**
 * Class ARC_Session
 *
 */
class ARC_Session extends CI_Session {

    public $valid;

    function __construct()
    {
        parent::__construct();
        $this->valid = false;
    }

    public function setUser( $user )
    {
        $this->set_userdata( compact( 'user' ));
        if( $this->userdata( 'user' ) == $user ) return true;

        return false;
    }

    public function setCuda( $cuda )
    {
        $this->set_userdata( compact( 'cuda' ));
        if( $this->userdata( 'user' ) == $cuda ) return true;

        return false;
    }

    /**
     * Create a new session for a valid CudaTel user
     *
     * @return array
     */
    function create()
    {
        $user = $this->getUser();
        $this->_ci->cudatel->session('create', $user);

        return $creds;
    }

    /**
     * Create a new session for a valid Alvin user
     * @param $user
     * @param $pass
     *
     * @return array
     */
    function refresh($user, $pass)
    {
        $this->_ci->cudatel->session('refresh');
        $user = $this->_ci->user_model->validate($user, $pass);


        return $user;
    }

    /**
     * Destroy the user's sessions
     * @return bool
     */
    function destroy()
    {
        $this->_ci->cudatel->session('destroy');
        $this->sess_destroy();


        return ( ! isset($this->userdata['session_id']));
    }



    /**
     * Destroy the user's CudaTel session
     *
     * return boolean
     */
    function unlink()
    {

        return true;
    }

    /**
     * Get status/credentials for Alvin and CudaTel Systems
     */
    function status()
    {
        $user = $this->user();
        $cuda = $this->cuda($user);

        return $this->_ci->cudatel_model->validate($user);
    }

    public function checkAndRedirect($to = 'home')
    {
        if($this->user->valid)
        {
            redirect($to);
        }

        redirect('auth');
    }

    public function redirectInValid()
    {
        if( ! $this->user->valid)
        {

        }

        return false;
    }

    public function messageInvalid($message)
    {
        $this->sess_destroy();
        $this->set_flashdata('message', $message);
        $invalid = new stdClass();
        $invalid->valid = false;

        return $invalid;
    }


}
    
    