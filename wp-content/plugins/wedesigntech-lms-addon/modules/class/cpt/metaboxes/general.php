<div class="dtlms-custom-box">

    <!-- Page Layout -->
    <div class="dtlms-column dtlms-one-half first">

        <div class="dtlms-column dtlms-one-third first"><?php echo esc_html__( 'Page Layout', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <?php
            $page_layout = get_post_meta($post_id, 'page-layout', true);
            $page_layout = ($page_layout != '') ? $page_layout : 'type1';

            $pagelayouts = array ('type1' => 'Type 1', 'type2' => 'Type 2', 'type3' => 'Type 3', 'type4' => 'Type 4');

            echo '<select name="page-layout" data-placeholder="'.esc_html__('Choose Page Layout...', 'dtlms').'" class="dtlms-chosen-select">';
                foreach ($pagelayouts as $pagelayout_key => $pagelayout) {
                    echo '<option value="'.esc_attr($pagelayout_key).'" '.selected($pagelayout_key, $page_layout, false).'>'.esc_html($pagelayout).'</option>';
                }
            echo '</select>';
            ?>
        </div>

    </div>
    <!-- Page Layout End -->

    <div class="dtlms-column dtlms-one-half"></div>

</div>

<div class="dtlms-custom-box">

	<div class="dtlms-column dtlms-one-half first">
        <div class="dtlms-column dtlms-one-third first">
            <label><?php echo sprintf( esc_html__('Featured %1$s', 'dtlms'), $class_title_singular ); ?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
			<?php
			$dt_class_featured = get_post_meta($post_id, "dtlms-class-featured", true);
            $switchclass = ($dt_class_featured == 'true') ? 'checkbox-switch-on' : 'checkbox-switch-off';
            $checked = ($dt_class_featured == 'true') ? ' checked="checked"' : '';
            ?>
            <div data-for="dtlms-class-featured" class="dtlms-checkbox-switch <?php echo esc_attr($switchclass);?>"></div>
            <input id="dtlms-class-featured" class="hidden" type="checkbox" name="dtlms-class-featured" value="true" <?php echo dtlms_html_output($checked);?> />
            <p class="dtlms-note"> <?php esc_html_e("Make this item as featured one.", 'dtlms'); ?> </p>
            <div class="dtlms-clear"></div>
        </div>
    </div>

	<div class="dtlms-column dtlms-one-half">
        <div class="dtlms-column dtlms-one-third first">
            <label><?php esc_html_e('Main Tab Title', 'dtlms'); ?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
            <?php $dt_class_maintabtitle = get_post_meta ( $post_id, "dtlms-class-maintabtitle",true);?>
            <input class="dtlms-class-maintabtitle" name="dtlms-class-maintabtitle" type="text" value="<?php echo esc_attr($dt_class_maintabtitle);?>" style="width:80%;" />
            <p class="dtlms-note"> <?php esc_html_e("Add main tab title for your item here.", 'dtlms'); ?> </p>
            <div class="dtlms-clear"></div>
        </div>
    </div>

</div>