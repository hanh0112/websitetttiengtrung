<?php
global $post;
$post_id = $post->ID;

echo '<input type="hidden" name="dtlms_classes_meta_nonce" value="'.wp_create_nonce('dtlms_classes_nonce').'" />';

$class_title_singular = apply_filters( 'class_label', 'singular' );
$class_title_plural = apply_filters( 'class_label', 'plural' );

$current_user = wp_get_current_user();
$current_user_id = $current_user->ID;

$tabs = array (
    'general'     => array (
        'label'   => esc_html__('General', 'dtlms'),
        'icon'    => 'far fa-eye',
        'path'    => DTLMS_CLASS_PLUGIN_PATH . 'cpt/metaboxes/general.php'
    ),
    'curriculum'  => array (
        'label'   => esc_html__('Curriculum', 'dtlms'),
        'icon'    => 'fas fa-eye',
        'path'    => DTLMS_CLASS_PLUGIN_PATH . 'cpt/metaboxes/curriculum.php'
    ),
     'class-type' => array (
        'label'   => sprintf( esc_html__('%1$s Type', 'dtlms'), $class_title_singular ),
        'icon'    => 'fas fa-eye',
        'path'    => DTLMS_CLASS_PLUGIN_PATH . 'cpt/metaboxes/class-type.php'
    ),
    'accessories' => array (
        'label'   => esc_html__('Accessories', 'dtlms'),
        'icon'    => 'fas fa-eye',
        'path'    => DTLMS_CLASS_PLUGIN_PATH . 'cpt/metaboxes/accessories.php'
    ),
    'tabs'        => array (
        'label'   => esc_html__('Tabs', 'dtlms'),
        'icon'    => 'fas fa-eye',
        'path'    => DTLMS_CLASS_PLUGIN_PATH . 'cpt/metaboxes/tabs.php'
    ),
    'sidebar'     => array (
        'label'   => esc_html__('Sidebar', 'dtlms'),
        'icon'    => 'fas fa-eye',
        'path'    => DTLMS_CLASS_PLUGIN_PATH . 'cpt/metaboxes/sidebar.php'
    )
);

$tabs = apply_filters( 'dtlms_class_cpt_metabox_tabs', $tabs );

?>

<div class="dtlms-tabs-vertical-container" data-effect="fade">

    <ul class="dtlms-tabs-vertical">
        <?php
        $i = 0;
        foreach($tabs as $key => $tab) {

            $class = 'dtlms-tab-'.$key;
            if($i == 0) { $class .= ' current'; }

            echo '<li class="'.$class.'"><a href="javascript:void(0);"><span class="'.$tab['icon'].'"></span>'.$tab['label'].'</a></li>';

            $i++;
        }
        ?>
    </ul>

    <?php
    $i = 0;
    foreach($tabs as $key => $tab) {

        $style_attr = '';
        if($i == 0) { $style_attr = 'style="display: block;"'; }

        echo '<div class="dtlms-tabs-vertical-content dtlms-tab-'.$key.'" '.$style_attr.'>';
            echo '<h3 class="dtlms-tab-title">'.$tab['label'].'</h3>';

            ob_start();
            require $tab['path'];
            $tab_content = ob_get_contents();
            ob_end_clean();

            echo dtlms_html_output($tab_content);

        echo '</div>';

        $i++;

    }
    ?>

</div>