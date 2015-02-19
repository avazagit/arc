<?php // left_nav ARC View : Dynamic Generated Sidebar Navigation ?>


        <!-- ======================================== left_nav ======================================= -->

        <div id="sidebar" class="sidebar responsive menu-min">
            <script type="text/javascript">
                try { ace.settings.check( 'sidebar', 'fixed' ) } catch( e ){ }
            </script>

            <!----------- DYNAMIC SIDEBAR ------------>

            <?php insertDynamic( 'sidebar', $navigation, $pageContent ) ?>

            <!----------- END DYNAMIC SIDEBAR ------------>

            <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
            </div>

            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
            </script>
        </div>