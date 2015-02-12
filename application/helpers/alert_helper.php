<?php
/*
 * * alerts Helper * *
 *
 * * Functions for html markup and layout of alerts when sent/sending to any view
 *
 * * To print all alerts within a view simply call alerts();
 */

/**
 * @param array  $alerts
 *
 * @return bool
 */
function alerts( $alerts = [] )
{
    if( ! empty( $alerts )) foreach( $alerts as $alert ) echo $alert[ 'html' ];

    return false;
}

/**
 * @param null   $message - alert string to display
 * @param array  $class - properties of html wrapper tag
 * @param array  $item - Item to attach alert to
 * @param array  $markup - Tag Property names and values
 *
 * @return array|object
 */
function alert( $message = null, $class = null, $item = [], $markup = [])
{
    if( is_null( $message )) say( 'Please include an alert message when returning alert()' );

    $props = [ 'class' => tagWrite( 'class', $class )];
    $props = array_merge( $markup, $props);

    $defaults = [ 'class' => 'fail', 'tag' => 'div', 'close' => true ];
    $properties = array_merge( $defaults, $props );
    $original_type = gettype( $item );

    $array = $item;
    if( ! is_array( $item )) $array = cast( $item, 'array' );

    $item = addAlert( $array, $message, $properties );

    return cast( $item, $original_type );
}

/**
 * @param        $array
 * @param        $message
 * @param        $properties
 *
 * @return array
 */
function addAlert( $array, $message, $properties )
{
    if( ! isset( $array[ 'alerts' ] )) $array[ 'alerts' ] = [];

    $array[ 'alerts' ][] = wrapAlert( $message, $properties );

    return $array;
}

/**
 * @param $message
 * @param $properties
 *
 * @return array
 */
function wrapAlert( $message, $properties = [] )
{
    $default = [ 'tag' => 'div', 'close' => true ];

    $layout = array_merge( $default, $properties );
    $props = array_diff_key( $properties, $default );

    $html = tagStart( $layout[ 'tag' ], $props);
    $html.= tagClick( $layout[ 'close' ]);
    $html.= $message . PHP_EOL;
    $html.= tagClose( $layout[ 'tag' ]);

    return compact( 'message', 'html');
}

/**
 * @param $tag
 * @param $props
 * @return string
 */
function tagStart( $tag, $props )
{
    return '<' . $tag . tagProps( $props ) . '>' . PHP_EOL;
}

/**
 * @param bool $html
 * @return string
 */
function tagClick( $html = true )
{
    return $html ? '<button class="close" data-dismiss="alert">&times;</button>' . PHP_EOL : '';
}

/**
 * @param $tag
 * @return string
 */
function tagClose( $tag )
{
    return '</' . $tag . '>' . PHP_EOL;
}

/**
 * @param array  $props
 * @param string $str
 * @return string
 */
function tagProps( $props = [], $str = '' )
{
    foreach( $props as $item => $val ) $str .= ' ' . $item . '="' . $val . '"';

    return $str;
}

/**
 * @param $propName
 * @param $propData
 * @return string
 */
function tagWrite( $propName = 'class', $propData )
{
    if( is_null( $propData )) say( 'Cannot add an empty class property, please include the class when calling alert()');
    $rewrite = get_instance()->load->json( 'alerts', 'collection' );
    $propNames = array_keys( $rewrite );

    if( in_array( $propName, $propNames )) $propData = $rewrite[ $propName ][ $propData ];

    return $propData;
}

/**
 * @param $alerts
 *
 * @return array|object
 */
function validationAlerts( $alerts = [])
{
    $errors = tagExplode( validation_errors());

    foreach( $errors as $message ) $alerts = alert( $message, 'invalid', $alerts );

    return $alerts;
}

/**
 * returns an array exploded on ALL html tags ( also trims line breaks )
 * @param string $string
 * @param array $exploded
 *
 * @return array|bool
 */
function tagExplode( $string, $exploded = [] )
{
    $array = array_merge( $exploded, preg_split( '/<[^>]*>/', trim( $string ), 0, PREG_SPLIT_NO_EMPTY ));

    foreach( $array as $key => $value ) $exploded[ $key ] = get_instance()->security->xss_clean( $value );

    return $exploded;
}

