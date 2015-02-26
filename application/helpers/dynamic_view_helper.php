<?php

function insertDynamic( $item, $navigation, $page )
{
    $nav = $navigation[ $item ];
    switch( $item ):
        case 'sidebar':
            $sidebar = sidebarShortcuts( $nav[ 'shortcuts' ]);
            $sidebar.= sidebarMarkup( $nav[ 'items' ], $page );
            echo $sidebar;
            break;
        case 'sidebar-shortcuts':
            echo sidebarShortcuts( $nav, $page );
            break;
    endswitch;

}

function sidebarMarkup( $items, $page )
{
    $html = PHP_EOL . PHP_EOL . '<ul class="nav nav-list">' . PHP_EOL;
    $html.= sidebarSection( $items, $page );
    $html.= '</ul>' . PHP_EOL . PHP_EOL;

    return $html;
}

function sidebarSection( $items, $page )
{
    $html = '';

    foreach( $items as $item => $settings ):
        $settings = sidebarStructure( $settings );
        $class = activeCheck( $page, $item, $settings[ 'class' ]);

        $html.= '    <li class="' . $class . '">' . PHP_EOL;
        $html.= '        <a href="' . $settings[ 'link' ] . '">' . PHP_EOL;
        $html.= '            <i class="' . $settings[ 'menu_icon' ] . '"></i>' . PHP_EOL;
        $html.= '            <span class="menu-text"> ' . $settings[ 'menu_text' ] . ' </span>' . PHP_EOL;
        $html.= '        </a>' . PHP_EOL;
        $html.= '        <b class="arrow"></b>' . PHP_EOL;

        if( ! empty( $settings[ 'sub' ])):
            $html.= '        <ul class="submenu">' . PHP_EOL .
                                 sidebarSection( $settings[ 'sub' ], $page ) .
                    '        </ul>' . PHP_EOL;
        endif;

        $html.= '    </li>' . PHP_EOL;
    endforeach;

    return $html;
}

function sidebarStructure( $items )
{
    $match = [
        'class' => '',
        'link' => '',
        'menu_icon' => '',
        'menu_text' => 'NO NAME GIVEN',
        'sub' => []
    ];

    return array_merge( $match, $items );
}

function activeCheck( $currentPage, $navigateItem, $navClass )
{
    if( $currentPage == $navigateItem ) return 'active';

    $itemParent = explode( '-', $navigateItem )['0'];
    $pageParent = explode( '-', $currentPage )['0'];


    if( $pageParent == $itemParent ) return 'active';

    return $navClass;
}

function sidebarShortcuts( $shortcuts )
{
    $html = '<div class="sidebar-shortcuts" id="sidebar-shortcuts">' . PHP_EOL;
    $lrge = '    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">' . PHP_EOL;
    $mini = '    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">' . PHP_EOL;

    foreach( $shortcuts as $shortcut ):
        $lrge.= '        <a href="' . $shortcut[ 'link' ] . '" class="' . $shortcut[ 'class' ] . '"><i class="' . $shortcut[ 'menu_icon' ] . '"></i></a>' . PHP_EOL;
        $mini.= '        <a href="' . $shortcut[ 'link' ] . '" class="' . $shortcut[ 'class' ] . '"></a>' . PHP_EOL;
    endforeach;

    $lrge.= '    </div>' . PHP_EOL;
    $mini.= '    </div>' . PHP_EOL;
    $html.= $lrge . $mini . '</div>';

    return $html;
}