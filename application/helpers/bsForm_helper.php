<?php

function bsForm_open( $action = '', $attributes = [], $hidden = [])
{
    return form_open( $action, $attributes, $hidden );
}

function bsForm_open_multipart( $action = '', $attributes = [], $hidden = [])
{
    return form_open_multipart( $action, $attributes, $hidden );
}

function bsForm_close( $extra = '' )
{
    return form_close( $extra );
}

function bsForm_fieldset( $legend_text = '', $attributes = [])
{
    return form_fieldset( $legend_text, $attributes );
}

function bsForm_fieldset_close( $extra = '' )
{
    return form_fieldset_close( $extra );
}

function bsForm_hidden( $name, $value = '', $recurse = FALSE )
{
    return form_hidden( $name, $value, $recurse );
}

function bsForm_token( $name, $value = null, $recurse = FALSE )
{
    $token = token_cast( $value );

    return form_hidden( $name, $token, $recurse );
}

function bsForm_text( $data = '', $value = '', $extra = '' )
{
    return form_input( $data, $value, $extra );
}

function bsForm_password( $data = '', $value = '', $extra = '' )
{
    return form_password( $data, $value, $extra );
}

function bsForm_search( $data = '', $value = '', $extra = '' )
{
    return form_password( $data, $value, $extra );
}

function bsForm_textArea( $data = '', $value = '', $extra = '' )
{
    return form_textarea( $data, $value, $extra );
}

function bsForm_upload( $data = '', $value = '', $extra = '' )
{
    return form_upload( $data, $value, $extra );
}

function bsForm_checkbox( $data = '', $value = '', $checked = FALSE, $extra = '' )
{
    return form_checkbox( $data, $value, $checked, $extra );
}

function bsForm_radio( $data = '', $value = '', $checked = FALSE, $extra = '' )
{
    return form_radio( $data, $value, $checked, $extra );
}

function bsForm_select( $data = '', $options = [], $selected = [], $extra = '' )
{
    return form_dropdown( $data, $options, $selected, $extra );
}

function bsForm_multiSelect( $name = '', $options = [], $selected = [], $extra = '' )
{
    return form_multiselect( $name, $options, $selected, $extra );
}

function bsForm_layerSelect( $name = '', $options = [], $selected = [], $extra = '' )
{
    return form_multiselect( $name, $options, $selected, $extra );
}

function bsForm_seriesSelect( $name = '', $options = [], $selected = [], $extra = '' )
{
    return form_multiselect( $name, $options, $selected, $extra );
}

function bsForm_button( $data = '', $content = '', $extra = '' )
{
    return form_button( $data, $content, $extra );
}

function bsForm_submit( $data = '', $value = '', $extra = '' )
{
    return form_submit( $data, $value, $extra );
}

function bsForm_reset(  $data = '', $value = '', $extra = '' )
{
    return form_reset( $data, $value, $extra );
}

function bsForm_error( $field = '', $prefix = '', $suffix = '' )
{
    return form_error( $field, $prefix, $suffix );
}

function bsForm_label( $label_text = '', $id = '', $attributes = [] )
{
    return form_label( $label_text, $id, $attributes );
}














