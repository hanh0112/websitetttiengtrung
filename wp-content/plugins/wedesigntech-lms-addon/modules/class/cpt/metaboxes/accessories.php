<div class="dtlms-custom-box">

	<div class="dtlms-column dtlms-one-half first">
        <div class="dtlms-column dtlms-one-third first">
            <label><?php esc_html_e('Accessories Tab Title', 'dtlms'); ?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
            <?php $dt_class_accessories_tabtitle = get_post_meta ( $post_id, "dtlms-class-accessories-tabtitle",true);?>
            <input class="dtlms-class-accessories-tabtitle" name="dtlms-class-accessories-tabtitle" type="text" value="<?php echo esc_attr($dt_class_accessories_tabtitle); ?>" style="width:80%;" />
            <p class="dtlms-note"> <?php esc_html_e("Add title for accessories tab here.", 'dtlms'); ?> </p>
            <div class="dtlms-clear"></div>
        </div>
    </div>

	<div class="dtlms-column dtlms-one-half">
    </div>

</div>

<div class="dtlms-custom-box">

	<div class="dtlms-column dtlms-one-sixth first">

       <label><?php esc_html_e('Add Accessories', 'dtlms'); ?></label>

	</div>
	<div class="dtlms-column dtlms-five-sixth">

        <div id="dtlms-class-accessories-container">

            <?php
            $class_accessories_icon = get_post_meta ( $post_id, "dtlms-class-accessories-icon", true);
            $class_accessories_label = get_post_meta ( $post_id, "dtlms-class-accessories-label", true);
            $class_accessories_value = get_post_meta ( $post_id, "dtlms-class-accessories-value", true);
            $class_accessories_description = get_post_meta ( $post_id, "dtlms-class-accessories-description", true);

            $j = 0;
            if(isset($class_accessories_value) && is_array($class_accessories_value)) {
                foreach($class_accessories_value as $classaccessoryvalue) {
                    ?>
                    <div class="dtlms-accessory-box" style="width: 100%;">
                        <?php
                        $classaccessoriesicon = $classaccessorieslabel = $classaccessoriesdescription = '';
                        if(isset($class_accessories_icon[$j])) {
                            $classaccessoriesicon = $class_accessories_icon[$j];
                        }
                        if(isset($class_accessories_label[$j])) {
                            $classaccessorieslabel = $class_accessories_label[$j];
                        }
                        if(isset($class_accessories_description[$j])) {
                            $classaccessoriesdescription = $class_accessories_description[$j];
                        }

                        echo '<input id="dtlms-class-accessories-icon" name="dtlms-class-accessories-icon[]" class="large" type="text" value="'.esc_attr($classaccessoriesicon).'" style="width:32.56%;" />';
                        echo '<input id="dtlms-class-accessories-label" name="dtlms-class-accessories-label[]" class="large" type="text" value="'.esc_attr($classaccessorieslabel).'" style="width:32.56%;" />';
                        echo '<input id="dtlms-class-accessories-value" name="dtlms-class-accessories-value[]" class="large" type="text" value="'.esc_attr($classaccessoryvalue).'" style="width:32.56%; margin-right: 0;" />';
                        echo '<input id="dtlms-class-accessories-description" name="dtlms-class-accessories-description[]" class="large" type="text" value="'.esc_attr($classaccessoriesdescription).'" style="width:100%; margin-top:10px;" />';
                        ?>
                        <span class="dtlms-remove-accessory"><span class="fas fa-times"></span></span>
                        <span class="fas fa-arrows-alt"></span>
                    </div>
                    <?php
                    $j++;
                }
            }
            ?>

        </div>

        <a href="#" class="dtlms-add-accessory custom-button-style"><?php esc_html_e('Add Accessory', 'dtlms'); ?></a>

        <p class="dtlms-note"> <?php esc_html_e('You can additional items with icon, label and value here.', 'dtlms'); echo "<br>"; esc_html_e('Among these three its necessary to add value atleast.', 'dtlms'); ?> </p>

    	<div id="dtlms-accessory-to-clone" class="hidden" style="width: 100%;">

            <?php
            echo '<input id="dtlms-class-accessories-icon" name="dtlms-class-accessories-icon[]" placeholder="'.esc_html__('Icon', 'dtlms').'" class="large" type="text" value="" style="width:32.56%;" />';
            echo '<input id="dtlms-class-accessories-label" name="dtlms-class-accessories-label[]" placeholder="'.esc_html__('Label', 'dtlms').'" class="large" type="text" value="" style="width:32.56%;" />';
            echo '<input id="dtlms-class-accessories-value" name="dtlms-class-accessories-value[]" placeholder="'.esc_html__('Value', 'dtlms').'" class="large" type="text" value="" style="width:32.56%; margin-right: 0;" />';
            echo '<input id="dtlms-class-accessories-description" name="dtlms-class-accessories-description[]" placeholder="'.esc_html__('Description', 'dtlms').'" class="large" type="text" value="" style="width:100%; margin-top:10px;" />';
            ?>
            <span class="dtlms-remove-accessory"><span class="fas fa-times"></span></span>
            <span class="fas fa-arrows-alt"></span>

        </div>

	</div>

</div>