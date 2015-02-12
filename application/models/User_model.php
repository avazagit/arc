<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends ARC_Model {

    function __construct()
    {
        parent::__construct();
        $this->table = 'users';
    }

    /**
     * @param $sent
     *
     * @return mixed
     */
    public function post( $sent )
    {
        if( ! method_exists( $this, $sent[ 'view' ])) say( 'Not a valid POST URI' );

        return call_user_func_array([ $this, $sent[ 'view' ]], [ $sent ] );
    }



/*
    //TODO repair these functions AFTER making new user
    protected function roles()
    {
        return array_shift( array_keys( $this->collection( 'access' )));
    }

    protected function permission( $user, $resource, $action, $value = 0 )
    {


        if( ! in_array( $resource, $permissions[ 'actions' ])) die( $action . ' is not a valid action.');
        $access = $this->collection( 'access' );

        if( ! in_array( $action, $permissions[ 'actions' ])) die( $action . ' is not a valid action.');

        $user->permissions[ $resource ] = array_merge(
            $user->permissions[ $resource ],
            [ $action => $value ]
        );

        return $user;
    }

    protected function resources( $role )
    {
        return $this->collection( 'access' )[ $role ];
    }

    protected function actions()
    {
        return $this->collection( 'access' )[ 'actions' ];
    }*/
}