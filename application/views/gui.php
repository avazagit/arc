<?php //GUI INTERFACE JSON LOADER BASE VIEW

$templates = [
    'main' => '/gui',
    'none' => ''
];

$defaults = [
    'guiTemplate' => 'none',
    'pageContent' => 'missing'
];

if( ! isset( $details )) $details = $defaults;

$contents = array_merge( $defaults, $details );

$viewName = $contents[ 'pageContent' ];
$template = $templates[ $contents[ 'guiTemplate' ]];

$this->load->view( 'bootstrap' . $template . '/head', $contents );
$this->load->view( 'content/' . $viewName, $contents );
$this->load->view( 'bootstrap' . $template . '/foot', $contents );