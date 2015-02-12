<?php

/**
 * @param        $data
 * @param string $key
 */
function say( $data, $key = 'error' )
{
    $data = cast( $data, 'array', true, $key );
    $data = array_merge( $data, get_func() );

    $output = cast( $data, 'json', false, $key );

    if( gettype( $output ) == 'string' ) die( '<pre>' . $output . '</pre>' );

    say( 'Output sent is not of "string" type' );
}

/**
 * @return array
 */
function get_func()
{
    $trace = debug_backtrace()[ '2' ];

    $format = [ 'function' => null, 'class' => null, 'line' => null ];

    return array_intersect_key( $trace, $format );
}