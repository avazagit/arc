<?php

require_once( 'bsForm_helper.php' );

function json_form_generate( $resource, $action, $input = [])
{
    $fields = json_form_load( $resource, $action, $input );

    $form = bsForm_open( $resource );

    foreach( $fields as $field ):
        $form .= json_form_field( $field[ 'markup' ] );
    endforeach;

    $form.= bsForm_close( PHP_EOL );

    return $form;
}

function json_form_load( $resource, $action, $input )
{
    $load = get_instance()->load->json( $resource . 'Form');
    if( ! in_array( $action, $load[ 'options' ][ 'modes' ]))
        say( 'cannot load form ' . $resource . 'Form : BAD MODE - ' . $action );

    $fields = $load[ 'fields' ];

    if( isset( $data[ $action ] )) $fields = array_merge( $fields, $data[ $action ]);

    if( ! empty( $input )) $fields = array_merge( $fields, $input );

    return $fields;
}

function json_form_field( $markup )
{
    $custom = [ 'layered_select', 'dependant_select' ];

    $args = func_get_args();
    if( ! in_array( $markup[ 'type' ], $custom )) return call_user_func( 'bsForm_' . $markup[ 'type' ], $args );


}

function form_field( $type, $name, $value = '', $data = [])
{
    $field = extractField( $type, $data );

    if( ! $field )

    $extra = extractExtra( $data );
    switch( $type ):
        case 'text':
            return form_input( $field, $value, $extra );
            break;
        case 'password':
            return form_password( $field, $value, $extra );
            break;
        case 'checkbox':
            $checked = false;
            return form_checkbox( $field, $value, $checked, $extra );
            break;
        case 'radio':
            $checked = false;
            return form_radio( $field, $value, $checked, $extra );
            break;
        case 'select':
            $options = extractSelect( $name, $data );
            $selected = in_array( $value, array_keys( $options )) ? [ $value ] : [];
            return form_dropdown( $field, $options, $selected, $extra );
            break;
        case 'layered_select':
            $parentOptions = extractSelectParent( $name, $data );
            $parentSelected = in_array( $value, array_keys( $parentOptions )) ? [ $value ] : [];
            $html = form_dropdown( $field, $parentOptions, $parentSelected, $extra ) . PHP_EOL;
            $childOptions = extractSelectChildren( $name, $data );
            $childSelected = in_array( $value, array_keys( $childOptions )) ? [ $value ] : [];
            $html.= form_dropdown( $field, $childOptions, $childSelected, $extra ) . PHP_EOL;
            return $html;
            break;
        case 'dependant_select':
            break;
        case 'token':
            $value = strlen( $value ) == 0 ?
                get_instance()->morph->hash( strtotime( 'now' )) :
                get_instance()->morph->hash( $value );
            return form_hidden( $name, $value );
            break;
    endswitch;
}

function extractField( $type, $data )
{
    checkData( $data, 'field' );

    get_instance()->load->json( )

}

function extractExtra( $data )
{
    checkData( $data, 'extra' );
}

function extractSelect( $name, $data )
{
    checkData( $data, 'select' );
}

function extractSelectParent( $name, $data )
{
    checkData( $data, 'select parent' );
}

function extractSelectChildren( $name, $data )
{
    checkData( $data, 'select children' );
}

function checkData( $data = [], $key = 'error' )
{
    cast( $data, 'array' );
    if( is_array( $data ) && ! empty( $data )) say( $data, $key );

    return false;
}