<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class ARC_Controller
 *
 * @property ARC_Session $session
 * @property User $resource
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 */
class ARC_Controller extends CI_Controller {

    protected $content;
    protected $sources;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @return bool
     */
    public function index()
    {
        return false;
    }

    /**
     * @param $item
     * @param $value
     *
     * @return $this
     */
    protected function set( $item, $value = null )
    {
        if( is_null( $value )):
            if( isset( $this->content[ $item ])) unset( $this->content[ $item ]);
            if( ! is_null( $this->session->userdata( $item ))) $this->session->unset_userdata( $item );
        endif;

        $this->content[ $item ] = $value;
        $this->session->set_userdata( $this->content );

        return $this;
    }

    protected function get( $item = null )
    {
        if( is_null( $item )):
            if( is_null( $this->session->userdata()) && empty( $this->content )) return false;
            if( is_null( $this->session->userdata())) return $this->content;
            if( empty( $this->content )) return $this->session->userdata();
        endif;

        $ses = $this->session->userdata( $item );

        $set = isset( $ses ) ? $ses : false;
        $now = isset( $this->content[ $item ] ) ? $this->content[ $item ] : false;

        return ! $set ? $now : $set;
    }

    protected function resource( $key, $value = null )
    {
        if( ! is_null( $value )) $this->sources[ $key ] = $value;
        else unset( $this->sources[ $key ]);

        return $this;
    }

    /**
     * @param $interface
     * @param $callback
     * @param array $cbParams
     *
     * @return bool
     */
    protected function post( $interface, $callback = 'index', $cbParams = [] )
    {
        if( $this->validation()->fails()) return $this->show( $interface, true );
        if( $this->apply()->fails()) return $this->show( $interface, true );

        say( 'success' );
        return call_user_func_array([ $this, $callback ], $cbParams ); //TODO User Class must set session validity to true
    }

    /**
     * @return $this
     */
    protected function validation()
    {
        $this->load->library( 'form_validation' );

        if( ! $this->form_validation->run()):
            $response = cast( validationAlerts());
            $this->set( 'alerts', $response->alerts );
        endif;

        return $this;
    }

    /**
     * @return $this
     */
    protected function apply()
    {
        $post = $this->sources[ 'post' ];
        $this->load->resource( $post[ 'type' ], $post[ 'name' ] );

        $response = $this->resource->post( $this->posted());
        $response = cast( $response );

        if( isset( $response->alerts )) $this->set( 'alerts', $response->alerts );

        return $this;
    }

    /**
     * @return boolean
     */
    protected function fails()
    {
        return ( isset( $this->content[ 'alerts' ]) && ! empty( $this->content[ 'alerts' ]));
    }

    /**
     * @return mixed
     */
    protected function showErrors()
    {
        $this->set( 'data', false );
        $this->set( 'post', $this->input->post( null, true ));

        return $this->show( 'gui' );
    }

    /**
     * @return array
     */
    protected function posted()
    {
        $input = $this->input->post( null, true );

        if( ! $input ) return $this->content;

        return array_merge( $input, $this->content );
    }

    /**
     * @param $interface
     * @param $failed
     * @return bool
     */
    protected function show( $interface = 'gui', $failed = false )
    {
        if( ! $failed && ! empty( $_POST )) return $this->post( $interface );

        return $this->load->view( $interface, $this->content );
    }
}