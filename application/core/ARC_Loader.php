<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class ARC_Loader
 */
class ARC_Loader extends CI_Loader {

    /**
     * @var array
     */
    protected $interfaces;

    /**
     *
     */
    function __construct()
    {
        parent::__construct();
        $this->interfaces = [ 'gui', 'api' ];
    }

    /**
     * @param       $view
     * @param array $vars
     * @param bool  $return
     * @param array $load
     *
     * @return mixed
     */
    public function view( $view, $vars = [], $return = false, $load = [] )
    {
        if( in_array( $view, $this->interfaces )) $load = $this->content( $view, $vars );

        $default_load = [ '_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array( $vars ), '_ci_return' => $return ];

        $loadArray = array_merge( $default_load, $load );

        return $this->_ci_load( $loadArray );
    }

    /**
     * @param        $interface
     * @param  array $content
     *
     * @return array
     */
    protected function content( $interface, $content = [])
    {
        if( ! is_array( $content )) $content = cast( $content, 'array', true );

        if( ! $content ) say( 'Content is undefined or invalid : ' . json_encode( $content ));

        if( empty( $content )) say( 'No content sent to loader : ' . json_encode( $content ));

        $parts = $this->prepare( $content );

        return $this->assemble( $interface, $parts );
    }

    /**
     * @param array $parts
     * @return array
     */
    protected function prepare( $parts = [] )
    {
        $critical = [ 'view' ];

        foreach( $critical as $key ):
            if( ! isset( $parts[ $key ])) say( 'Critical element undefined :' . $key );
        endforeach;

        return $parts;
    }

    /**
     * @param $interface
     * @param $parts
     * @return array
     */
    protected function assemble( $interface, $parts )
    {
        $toolbox = $this->json( $interface . 'Loader' );
        $details = $toolbox[ $parts[ 'view' ]];

        $details[ 'alerts' ] = isset( $parts[ 'alerts' ] ) ? $parts[ 'alerts' ] : [];

        return [ '_ci_vars' => $this->_ci_object_to_array( $details )];
    }

    /**
     * @param        $name
     * @param string $type
     * @param string $cast
     * @return mixed
     */
    public function json( $name, $type = 'view', $cast = 'array' )
    {
        $contents = $this->jsonFile( $name, $type );

        return cast( $contents, $cast );
    }

    /**
     * @param      $name
     * @param      $pathKey
     * @param bool $decode
     * @return mixed|string
     */
    public function jsonFile( $name, $pathKey, $decode = false )
    {
        $paths = [ 'view' => 'viewLoaderPath', 'collection' => 'collectionPath' ];

        if( ! in_array( $pathKey, array_keys( $paths ))) say( $pathKey . ' is not a valid json file location key.' );

        $dir = config_item( $paths[ $pathKey ]);
        $file = $dir . $name . '.json';
        $contents = file_get_contents( $file );

        if( ! $contents ) say( 'Failed to read file : ' . $file );
        if( ! file_exists( $file )) say( 'Cannot locate json file : ' . $file );
        if( ! is_array( json_decode( $contents, true ))) say( 'Cannot read json data from file : ' . $file);

        if( $decode ) return json_decode( $contents );

        return $contents;
    }

    /**
     * @param        $type
     * @param        $name
     * @param string $setAs
     * @param null   $options
     * @return $this
     */
    public function resource( $type, $name, $setAs = 'resource', $options = null )
    {
        if( ! in_array( $type, [ 'library', 'model' ])) say( 'Cannot LOAD ' . $type . ' as resource.' );

        switch( $type ):
            case 'library':
                $this->library( $name, $options, $setAs );
                break;

            case 'model':
                $this->model( $name, $setAs, is_null( $options ));
                break;
        endswitch;

        return $this;
    }
}