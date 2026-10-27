<div class="dtlms-custom-box">

    <div class="dtlms-column dtlms-one-third first">
        <label><?php esc_html_e('Enable Badge','dtlms');?></label>
    </div>
    <div class="dtlms-column dtlms-two-third">
        <?php
        $enable_badge = get_post_meta ( $post_id, 'enable-badge', true );
        $switchclass = ($enable_badge == true) ? 'checkbox-switch-on' : 'checkbox-switch-off';
        $checked = ($enable_badge == true) ? ' checked="checked"' : '';
        ?>
        <div data-for="enable-badge" class="dtlms-checkbox-switch <?php echo esc_attr($switchclass);?>"></div>
        <input id="enable-badge" class="hidden" type="checkbox" name="enable-badge" value="true" <?php echo dtlms_html_output($checked);?> />
        <p class="dtlms-note"> <?php esc_html_e('Would you like to enable badge for this course?','dtlms');?> </p>
    </div>

</div>
<div class="dtlms-custom-box">

    <div class="dtlms-column dtlms-one-third first">
        <label><?php esc_html_e('Badge Percentage (%)', 'dtlms'); ?></label>
    </div>
    <div class="dtlms-column dtlms-two-third">
        <?php $badge_percentage = get_post_meta ( $post_id, 'badge-percentage', true ); ?>
        <input type="text" id="badge-percentage" name="badge-percentage" value="<?php echo esc_attr($badge_percentage); ?>" />
        <p class="dtlms-note"> <?php esc_html_e('Add percentage required to gain this badge.','dtlms');?> </p>
    </div>

</div>
<div class="dtlms-custom-box">

    <div class="dtlms-column dtlms-one-third first">
        <label><?php esc_html_e('Badge Image', 'dtlms'); ?></label>
    </div>
    <div class="dtlms-column dtlms-two-third">
        <div class="dtlms-upload-media-items-container">
            <?php
            $badge_image_url = get_post_meta ( $post_id, 'badge-image-url', true );
            $badge_image_id = get_post_meta ( $post_id, 'badge-image-id', true );
            ?>
            <input name="badge-image-url" type="text" class="uploadfieldurl" readonly value="<?php echo esc_attr($badge_image_url);?>"/>
            <input name="badge-image-id" type="hidden" class="uploadfieldid" readonly value="<?php echo esc_attr($badge_image_id);?>"/>
            <input type="button" value="<?php esc_html_e('Upload','dtlms');?>" class="dtlms-upload-media-item-button show-preview"data-mediatype="image" />
            <input type="button" value="<?php esc_html_e('Remove','dtlms');?>" class="dtlms-upload-media-item-reset" />
            <?php echo dtlms_adminpanel_image_preview($badge_image_url); ?>
        </div>
        <p class="dtlms-note"> <?php esc_html_e('Choose badge image for your course.','dtlms');?> </p>
    </div>

</div>