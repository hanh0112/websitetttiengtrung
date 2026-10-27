<div class="dtlms-custom-box">

	<div class="dtlms-column dtlms-one-half first">

        <div class="dtlms-column dtlms-one-third first">
            <label><?php echo sprintf( esc_html__('%1$s Type', 'dtlms'), $class_title_singular ); ?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
            <?php
            $class_type = get_post_meta ( $post_id, 'dtlms-class-type', TRUE );
            $class_type = (isset($class_type) && $class_type != '') ? $class_type: 'default';

            if($class_type == 'onsite') {
                $onsite_hide_cls = '';
                $online_hide_cls = 'style="display:none;"';
                $onsiteonline_hide_cls = '';
            } else if($class_type == 'online') {
                $onsite_hide_cls = 'style="display:none;"';
                $online_hide_cls = '';
                $onsiteonline_hide_cls = '';
            } else if($class_type == 'default') {
                $onsite_hide_cls = 'style="display:none;"';
                $online_hide_cls = 'style="display:none;"';
                $onsiteonline_hide_cls = 'style="display:none;"';
            }

            $class_types = array('default' => esc_html__('Default', 'dtlms'), 'online' => esc_html__('Online', 'dtlms'), 'onsite' => esc_html__('Onsite', 'dtlms'));

            $out = '';
            $out .= '<select name="dtlms-class-type" style="width:70%;" data-placeholder="'.sprintf( esc_html__('Select %1$s Type', 'dtlms'), $class_title_singular ).'" class="dtlms-class-type dtlms-chosen-select">' . "\n";
			foreach ($class_types as $class_type_key => $class_type_value){
				$out .= '<option value="' . esc_attr( $class_type_key ) . '"' . selected( $class_type_key, $class_type, false ) . '>' . esc_html( $class_type_value ) . '</option>' . "\n";
			}
            $out .= '</select>' . "\n";
            echo dtlms_html_output($out);
            ?>

            <p class="dtlms-note">
                <?php
                echo esc_html__('Choose item type here.', 'dtlms');
                echo "<br>";
                echo sprintf( esc_html__('%1$s - just for listing your items. Pirce option is not applicable here.', 'dtlms'), '<strong>'.esc_html__('Default', 'dtlms').'</strong>' );
                echo "<br>";
                echo sprintf( esc_html__('%1$s - if you like to sell bunch of courses online with tracking, you can use this option.', 'dtlms'), '<strong>'.esc_html__('Online', 'dtlms').'</strong>' );
                echo "<br>";
                echo sprintf( esc_html__('%1$s - if you like to advertise your onsite items, you can use this option.', 'dtlms'), '<strong>'.esc_html__('Onsite', 'dtlms').'</strong>' );
                ?>
            </p>
        </div>

	</div>

</div>

<div class="dtlms-custom-box dtlms-onsite-items" <?php echo dtlms_html_output($onsite_hide_cls); ?>>

	<div class="dtlms-column dtlms-one-half first">
        <div class="dtlms-column dtlms-one-third first">
            <label><?php esc_html_e('Start Date', 'dtlms'); ?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
            <?php $dt_class_start_date = get_post_meta ( $post_id, "dtlms-class-start-date",true);?>
            <input class="dtlms-class-start-date dtlms-datepicker" name="dtlms-class-start-date" type="text" value="<?php echo esc_attr($dt_class_start_date);?>" style="width:30%;" />
            <p class="dtlms-note"> <?php esc_html_e("Choose class start date here.", 'dtlms'); ?> </p>
            <div class="dtlms-clear"></div>
        </div>
    </div>

	<div class="dtlms-column dtlms-one-half">
        <div class="dtlms-column dtlms-one-third first">
            <label><?php esc_html_e('Capacity', 'dtlms'); ?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
            <?php $dt_class_capacity = get_post_meta ( $post_id, "dtlms-class-capacity",true);?>
            <input class="dtlms-class-capacity" name="dtlms-class-capacity" type="text" value="<?php echo esc_attr($dt_class_capacity);?>" style="width:30%;" />
            <p class="dtlms-note"> <?php esc_html_e("Add class total capacity here.", 'dtlms'); ?> </p>
            <div class="dtlms-clear"></div>
        </div>
    </div>

</div>

<div class="dtlms-custom-box dtlms-onsite-items" <?php echo dtlms_html_output($onsite_hide_cls); ?>>

	<div class="dtlms-column dtlms-one-half first">
        <div class="dtlms-column dtlms-one-third first">
            <label><?php esc_html_e('Disable Purchases / Registration', 'dtlms'); ?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
			<?php
			$dt_class_disable_purchases_registration = get_post_meta($post_id, "dtlms-class-disable-purchases-regsitration", true);
            $switchclass = ($dt_class_disable_purchases_registration == 'true') ? 'checkbox-switch-on' : 'checkbox-switch-off';
            $checked = ($dt_class_disable_purchases_registration == 'true') ? ' checked="checked"' : '';
            ?>
            <div data-for="dtlms-class-disable-purchases-regsitration" class="dtlms-checkbox-switch <?php echo esc_attr($switchclass);?>"></div>
            <input id="dtlms-class-disable-purchases-regsitration" class="hidden" type="checkbox" name="dtlms-class-disable-purchases-regsitration" value="true" <?php echo dtlms_html_output($checked);?> />
            <p class="dtlms-note"> <?php esc_html_e("Disable purchases / registration if total purchases / registration exceeds class capacity.", 'dtlms'); ?> </p>
            <div class="dtlms-clear"></div>
        </div>
    </div>

	<div class="dtlms-column dtlms-one-half">
        <div class="dtlms-column dtlms-one-third first">
            <label><?php esc_html_e('Enable Purchases', 'dtlms'); ?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
			<?php
			$dt_class_enable_purchases = get_post_meta($post_id, "dtlms-class-enable-purchases", true);
            $switchclass = ($dt_class_enable_purchases == 'true') ? 'checkbox-switch-on' : 'checkbox-switch-off';
            $checked = ($dt_class_enable_purchases == 'true') ? ' checked="checked"' : '';
            ?>
            <div data-for="dtlms-class-enable-purchases" class="dtlms-checkbox-switch <?php echo esc_attr($switchclass);?>"></div>
            <input id="dtlms-class-enable-purchases" class="hidden" type="checkbox" name="dtlms-class-enable-purchases" value="true" <?php echo dtlms_html_output($checked);?> />
            <p class="dtlms-note"> <?php esc_html_e("Enable purchase option for this class.", 'dtlms'); ?> </p>
            <div class="dtlms-clear"></div>
        </div>
    </div>

</div>

<div class="dtlms-custom-box dtlms-onsite-items" <?php echo dtlms_html_output($onsite_hide_cls); ?>>

	<div class="dtlms-column dtlms-one-half first">
        <div class="dtlms-column dtlms-one-third first">
            <label><?php esc_html_e('Enable Registration', 'dtlms'); ?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
			<?php
			$dt_class_enable_registration = get_post_meta($post_id, "dtlms-class-enable-registration", true);
            $switchclass = ($dt_class_enable_registration == 'true') ? 'checkbox-switch-on' : 'checkbox-switch-off';
            $checked = ($dt_class_enable_registration == 'true') ? ' checked="checked"' : '';
            ?>
            <div data-for="dtlms-class-enable-registration" class="dtlms-checkbox-switch <?php echo esc_attr($switchclass);?>"></div>
            <input id="dtlms-class-enable-registration" class="hidden" type="checkbox" name="dtlms-class-enable-registration" value="true" <?php echo dtlms_html_output($checked);?> />
            <p class="dtlms-note">
                <?php esc_html_e("Enable registration option for this class.", 'dtlms'); ?>
                <?php echo "<br>"; ?>
                <?php esc_html_e("Note this option will be enabled only when purchase option is disabled.", 'dtlms'); ?>
            </p>
            <div class="dtlms-clear"></div>
        </div>
    </div>

	<div class="dtlms-column dtlms-one-half">
        <div class="dtlms-column dtlms-one-third first">
            <label><?php esc_html_e('Syllabus Preview', 'dtlms'); ?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
			<?php
			$dt_class_shyllabus_preview = get_post_meta($post_id, "dtlms-class-shyllabus-preview", true);
            $switchclass = ($dt_class_shyllabus_preview == 'true') ? 'checkbox-switch-on' : 'checkbox-switch-off';
            $checked = ($dt_class_shyllabus_preview == 'true') ? ' checked="checked"' : '';
            ?>
            <div data-for="dtlms-class-shyllabus-preview" class="dtlms-checkbox-switch <?php echo esc_attr($switchclass);?>"></div>
            <input id="dtlms-class-shyllabus-preview" class="hidden" type="checkbox" name="dtlms-class-shyllabus-preview" value="true" <?php echo dtlms_html_output($checked);?> />
            <p class="dtlms-note"> <?php esc_html_e("If you don't wish to show the course detail pages for onsite courses, you can disable it. Enabling this option will only show the preview of the courses.", 'dtlms'); ?> </p>
            <div class="dtlms-clear"></div>
        </div>
    </div>

</div>

<div class="dtlms-custom-box dtlms-onsite-items" <?php echo dtlms_html_output($onsite_hide_cls); ?>>
	<div class="dtlms-column dtlms-one-sixth first">
		<label><?php esc_html_e('Address', 'dtlms'); ?></label>
	</div>
	<div class="dtlms-column dtlms-five-sixth">
		<?php $dt_class_address = get_post_meta($post_id, "dtlms-class-address", true);?>
		<textarea class="dtlms-class-address widefat" name="dtlms-class-address"><?php echo dtlms_html_output($dt_class_address);?></textarea>
		<p class="dtlms-note"> <?php esc_html_e("Add address here", 'dtlms'); ?> </p>
        <div class="dtlms-clear"></div>
	</div>
</div>

<div class="dtlms-custom-box dtlms-onsite-items" <?php echo dtlms_html_output($onsite_hide_cls); ?>>
	<div class="dtlms-column dtlms-one-sixth first">
		<label><?php esc_html_e('GPS Location', 'dtlms'); ?></label>
	</div>
	<div class="dtlms-column dtlms-five-sixth">
		<?php
        $dt_class_gps = get_post_meta($post_id, "dtlms-class-gps", true);
        $dt_class_gps = is_array($dt_class_gps) ? $dt_class_gps : array();
        $latitude = array_key_exists('latitude', $dt_class_gps) ? $dt_class_gps['latitude'] : '';
        $longitude = array_key_exists('longitude', $dt_class_gps) ? $dt_class_gps['longitude'] : '';
        ?>
		<input class="dtlms-class-latitude small" name="dtlms-class-gps[latitude]" type="text" placeholder="<?php esc_html_e("Latitude","dtlms");?>" value="<?php echo esc_attr($latitude);?>"> -
		<input class="dtlms-class-longitude small" name="dtlms-class-gps[longitude]" type="text" placeholder="<?php esc_html_e("Longitude","dtlms");?>" value="<?php echo esc_attr($longitude);?>" > -
		<a href="#" class="dtlms-generate-gps custom-button-style"><?php esc_html_e( 'Click Here to get GPS Location', 'dtlms' );?> </a>
		<p class="note alert"> <?php esc_html_e("Add GPS location here to enable map.", 'dtlms'); ?> </p>
        <div class="dtlms-clear"></div>
	</div>
</div>