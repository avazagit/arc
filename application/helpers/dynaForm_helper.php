<?php

function form_generate( $resource, $action, $input = [])
{
    get_instance()->load->json( $resource . 'Form');
}