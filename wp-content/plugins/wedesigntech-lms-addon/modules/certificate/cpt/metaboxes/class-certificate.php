<div class="dtlms-custom-box dtlms-onsiteonline-items" <?php echo dtlms_html_output($onsiteonline_hide_cls); ?>>

    <div class="dtlms-column dtlms-one-third first">
        <label><?php esc_html_e('Enable Certificate','dtlms');?></label>
    </div>
    <div class="dtlms-column dtlms-two-third">
        <?php
        $enable_certificate = get_post_meta ( $post_id, 'enable-certificate', true );
        $switchclass = ($enable_certificate == true) ? 'checkbox-switch-on' : 'checkbox-switch-off';
        $checked = ($enable_certificate == true) ? ' checked="checked"' : '';
        ?>
        <div data-for="enable-certificate" class="dtlms-checkbox-switch <?php echo esc_attr($switchclass);?>"></div>
        <input id="enable-certificate" class="hidden" type="checkbox" name="enable-certificate" value="true" <?php echo dtlms_html_output($checked);?> />
        <p class="dtlms-note"> <?php esc_html_e('Would you like to enable certificate for this class?','dtlms');?> </p>
    </div>

    <div class="dtlms-hr-invisible"></div>
    <div class="dtlms-hr-invisible"></div>

    <div class="dtlms-online-items" <?php echo dtlms_html_output($online_hide_cls); ?>>

        <div class="dtlms-column dtlms-one-third first">
            <label><?php esc_html_e('Certificate Percentage (%)', 'dtlms'); ?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
            <?php $certificate_percentage = get_post_meta ( $post_id, 'certificate-percentage', true ); ?>
            <input type="text" id="certificate-percentage" name="certificate-percentage" value="<?php echo esc_attr($certificate_percentage); ?>" class="large">
            <p class="dtlms-note"> <?php esc_html_e('Add percentage required to gain this certificate.','dtlms');?> </p>
        </div>

        <div class="dtlms-hr-invisible"></div>
        <div class="dtlms-hr-invisible"></div>

    </div>

    <div class="dtlms-column dtlms-one-third first">
        <label><?php esc_html_e('Certificate Template','dtlms');?></label>
    </div>
    <div class="dtlms-column dtlms-two-third">
        <?php
        $certificate_template = get_post_meta ( $post_id, 'certificate-template', true );
        $certificates_args = array( 'post_type' => 'dtlms_certificates', 'numberposts' => -1, 'orderby' => 'date', 'order' => 'DESC', 'suppress_filters'  => FALSE );
        $certificates_array = get_posts( $certificates_args );

        $out = '';
        $out .= '<select id="certificate-template" name="certificate-template" style="width:70%;" data-placeholder="'.esc_html__('Select Certificate Template...', 'dtlms').'" class="dtlms-chosen-select">' . "\n";
        $out .= '<option value="">' . __( 'None', 'dtlms' ) . '</option>';
        if ( count( $certificates_array ) > 0 ) {
            foreach ($certificates_array as $certificate){
                $out .= '<option value="' . esc_attr( $certificate->ID ) . '"' . selected( $certificate->ID, $certificate_template, false ) . '>' . esc_html( $certificate->post_title ) . '</option>' . "\n";
            }
        }
        $out .= '</select>' . "\n";
        echo dtlms_html_output($out);
        ?>
        <p class="dtlms-note"> <?php esc_html_e('Choose certificate template here.','dtlms');?> </p>
    </div>

</div>