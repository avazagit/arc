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
    protected function set( $item, $value )
    {
        $this->content[ $item ] = $value;

        return $this;
    }

    /**
     * @param $interface
     *
     * @return bool
     */
    protected function post( $interface )
    {
        if( $this->validation()->fails() || $this->complete()->fails()) return $this->show( $interface, true );

        return $this->index();//TODO User Class must set session validity to true
    }

    /**
     * @return $this
     */
    protected function validation()
    {
        $this->load->library( 'form_validation' );
        if( ! $this->form_validation->run()) $this->set( 'messages', validationMessages());

        return $this;
    }

    /**
     * @return $this
     */
    protected function complete()
    {
        $post = $this->sources[ 'post' ];
        $this->loadSource( $post[ 'type' ], $post[ 'name' ] );

        $response = cast( $this->resource->post( $this->posted()));
        if( isset( $response->messages )) $this->set( 'messages', $response->messages );

        return $this;
    }

    /**
     * @return boolean
     */
    protected function fails()
    {
        return isset( $this->content[ 'messages' ]) && ! empty( $this->content[ 'messages' ]);
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
     * @param $type
     * @param $name
     *
     * @return $this
     */
    protected function loadSource( $type, $name )
    {
        $this->load->$type( $name, [], 'resource' );

        return $this;
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