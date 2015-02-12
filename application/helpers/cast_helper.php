<?php

/**
 * Will always return as $item CAST to new type or false
 * @param mixed  $item        Data to be cast
 * @param string  $newType     Type to cast $data to
 * @param boolean $recursive   boolean depicting recursive recasting
 * @param string  $key         array/object key to assign to string when recasting
 *
 * @return mixed
 */
function cast( $item, $newType = 'object', $recursive = false, $key = 'data' )
{
    $type = gettype( $item );
    $fail = [ 'NULL', 'resource', 'unknown type' ];
    $wrap = [ 'boolean', 'integer', 'double', 'string' ];

    if( in_array( $type, $fail )) say( 'Cannot "cast" item of type ' . $type );

    if( in_array( $type, $wrap )) $item = array_wrap( $item, $key );

    return recast( $item, $newType, $recursive );
}

/**
 * @param        $item
 * @param string $newType
 * @param bool   $recursive
 *
 * @return array|bool|mixed|\stdClass
 */
function recast( $item, $newType = 'array', $recursive = false )
{
    $canCast = [ 'array', 'object', 'json' ];

    if( ! in_array( $newType, $canCast ) || ! in_array( gettype( $item ), $canCast )) return false;

    switch( $newType ):
        case "array":
            if( is_array( $item )) return $item;
            return array_cast( $item, $recursive );
            break;
        case "object":
            if( is_object( $item )) return $item;
            return object_cast( $item, $recursive );
            break;
        case "json":
            return json_encode( $item );
            break;
    endswitch;

    return false;
}

/**
 * @param        $item
 * @param string $key
 *
 * @return array|mixed
 */
function array_wrap( $item, $key = 'data' )
{
    if( gettype( $item ) == 'string' ) return array_json( $item, $key );

    return [ $key => $item ];
}

/**
 * @param        $item
 * @param string $key
 *
 * @return array|mixed
 */
function array_json( $item, $key = 'data' )
{
    $json = json_decode( $item, true );

    if( is_array( $json )) return $json;

    return [ $key => $item ];
}

/**
 * @param      $object
 * @param bool $recursive
 *
 * @return array|mixed
 */
function array_cast( $object, $recursive = false )
{
    if( $recursive ) return json_decode( json_encode( $object ), true );

    $array = [];

    foreach( $object as $k => $v ) $array[ $k ] = $v;

    return $array;
}

/**
 * @param      $array
 * @param bool $recursive
 *
 * @return mixed|\stdClass
 */
function object_cast( $array, $recursive = false )
{
    if( $recursive ) return json_decode( json_encode( $array ), false );

    $object = new stdClass();

    foreach( $array as $k => $v ) $object->$k = $v;

    return $object;
}