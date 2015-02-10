<?php
/*
 * * Messages Helper * *
 *
 * * Functions for html markup and layout of messages when sent/sending to any view
 *
 * * To print all messages within the view simple call printMessages();
 */

/**
 * @param null  $messages
 * @return bool
 */
function printMessages( $messages = null )
{
    if( is_null( $messages )) return false;

    foreach( $messages as $message ):
        echo $message['opens'] . $message['message'] . $message['close'];
    endforeach;

    return false;
}

/**
 * @param null  $message - Message string to display
 * @param string $class - Short version of css class
 * @param array $object - Object to attach message to
 * @param array $markup - Custom markup options
 *
 * @return array|object
 */
function message( $message = null, $class = 'fail', $object = [], $markup = [] )
{
    $object = cast( $object );

    if( is_null( $message )) die( 'Please include a message when calling message()' );

    $messages = isset( $object->messages ) ? $object->messages : [];
    $object->messages = addMessage( $messages, $message, $class, $markup );

    return $object;
}

function css( $short )
{
    $classes = [
        /*'valid' => 'alert-valid',
        'invalid' => 'alert-invalid',*/
        'warn' => 'alert-warning',
        'info' => 'alert-info',
        'good' => 'alert-success',
        'fail' => 'alert-danger'
    ];

    return $classes[ $short ] OR false;
}

/**
 * @param        $messages
 * @param        $newMessage
 * @param string $class
 * @param        $markup
 * @return array
 */
function addMessage( $messages, $newMessage, $class, $markup )
{
    $newMessage = wrapMessage( $newMessage, $class, $markup );

    if( ! empty( $newMessage )) $messages[] = $newMessage;

    return $messages;
}

/**
 * @param $message
 * @param $class
 * @param $markup
 * @return array
 */
function wrapMessage( $message, $class, $markup )
{
    $cssClass = "alert " . css( $class );
    $layout = [ 'tag' => 'div', 'class' => $cssClass, 'closeable' => true, ];
    $design = array_merge( $layout, $markup );

    $markup = getMarkup( $design );

    return array_merge( compact( 'message' ), $markup );
}

/**
 * @param $design
 * @return array
 */
function getMarkup( $design )
{
    extract( $design );

    if( ! isset( $tag, $class, $closeable )) return [];

    $opens = "<{$tag} class=\"{$class}\">\n";
    $opens.= $closeable ? "<button class=\"close\" data-dismiss=\"alert\">&times;</button>\n" : '';
    $close = "\n</{$tag}>\n";

    return compact( 'opens', 'close' );
}

/**
 * @return array|object
 */
function validationMessages()
{
    $errors = [];
    $string = validation_errors();
    $tags = [ '<p>', '</p>' ];
    $messages = multiExplode( $string, $tags );

    $validation = [];

    foreach( $messages as $message ):
        $validation[] = cast( message( $message, $errors ), 'array');
    endforeach;

    return $validation['messages'];
}

/**
 * @param null  $string
 * @param array $delimiters
 * @return array|bool
 */
function multiExplode( $string = null, $delimiters = [] )
{
    if( is_null( $string ) || ! is_array( $delimiters ) || empty( $delimiters )) return false;

    $strLimit = '';

    foreach( $delimiters as $i => $delimiter ):
        $strLimit .= preg_quote( $delimiter ) . '|';
    endforeach;

    $strLimit .= "\\n";

    return preg_split(":({$strLimit}):", trim( $string ), 0, PREG_SPLIT_NO_EMPTY);
}

