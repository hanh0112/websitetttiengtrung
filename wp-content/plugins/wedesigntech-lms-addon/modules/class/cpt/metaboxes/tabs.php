<div class="dtlms-custom-box">

	<div class="dtlms-column dtlms-one-sixth first">

       <label><?php esc_html_e('Add Tabs', 'dtlms'); ?></label>

	</div>
	<div class="dtlms-column dtlms-five-sixth">

        <div id="dtlms-class-tabs-container">

            <?php
            $class_tabs_title        = get_post_meta ( $post_id, "dtlms-class-tabs-title", true);
            $class_tabs_content_type = get_post_meta ( $post_id, "dtlms-class-tabs-content-type", true);
            $class_tabs_content      = get_post_meta ( $post_id, "dtlms-class-tabs-content", true);
            $class_tabs_content_page = get_post_meta ( $post_id, "dtlms-class-tabs-content-page", true);

            $j = 0;
            if(isset($class_tabs_title) && is_array($class_tabs_title)) {
                foreach($class_tabs_title as $class_tab_title) {

                    if($class_tabs_content_type[$j] == 'page') {
                        $tc_textarea_class = 'hidden';
                        $tc_page_class = '';
                    } else {
                        $tc_textarea_class = '';
                        $tc_page_class = 'hidden';
                    }
                ?>
                    <div class="dtlms-tab-box">
                        <?php
                        echo '<input id="dtlms-class-tabs-title" name="dtlms-class-tabs-title[]" class="large" type="text" value="'.$class_tab_title.'" style="width:31.7%;" />';

                        $tabs_content_type_options = array (
                            'textarea' => esc_html__('Text Area', 'dtlms'),
                            'page'     => esc_html__('Page', 'dtlms')
                        );

                        echo '<select id="dtlms-class-tabs-content-type" name="dtlms-class-tabs-content-type[]" data-placeholder="'.esc_html__('Select...', 'dtlms').'" class="dtlms-chosen-select">';
                        foreach ($tabs_content_type_options as $tabs_content_type_option_key => $tabs_content_type_option){
                            echo '<option value="' . esc_attr( $tabs_content_type_option_key ) . '" ' . selected( $tabs_content_type_option_key, $class_tabs_content_type[$j], false ) . '>' . esc_html( $tabs_content_type_option ) . '</option>';
                        }
                        echo '</select>';

                        echo '<div class="dtlms-class-tabs-content-textarea-holder '.$tc_textarea_class.'">';
                            $class_tabs_content_string = (isset($class_tabs_content[$j]) && !empty($class_tabs_content[$j])) ? $class_tabs_content[$j] : '';
                            echo '<textarea id="dtlms-class-tabs-content" name="dtlms-class-tabs-content[]" class="large" type="text" style="width:100%;">'.$class_tabs_content_string.'</textarea>';
                        echo '</div>';

                        echo '<div class="dtlms-class-tabs-content-page-holder '.$tc_page_class.'">';
                            $class_tabs_content_page_string = (isset($class_tabs_content_page[$j]) && !empty($class_tabs_content_page[$j])) ? $class_tabs_content_page[$j] : -1;
                            $pages = get_pages();
                            echo '<select id="dtlms-class-tabs-content-page" name="dtlms-class-tabs-content-page[]" data-placeholder="'.esc_html__('Select...', 'dtlms').'" class="dtlms-chosen-select">';
                                foreach ( $pages as $page ) {
                                    echo '<option value="' . esc_attr( $page->ID ) . '" ' . selected( $page->ID, $class_tabs_content_page_string, false ) . '>' . esc_html( $page->post_title ) . '</option>';
                                }
                            echo '</select>';
                        echo '</div>';

                        ?>
                        <span class="dtlms-remove-tab"><span class="fas fa-times"></span></span>
                        <span class="fas fa-arrows-alt"></span>
                    </div>
                <?php
                $j++;
                }
            }
            ?>

        </div>

        <a href="#" class="dtlms-add-tab custom-button-style"><?php esc_html_e('Add Tab', 'dtlms'); ?></a>

        <p class="dtlms-note"> <?php esc_html_e('If you wish you can add additional tabs along with content for your item.', 'dtlms'); ?> </p>

    	<div id="dtlms-tab-to-clone" class="hidden">

            <?php
            echo '<input id="dtlms-class-tabs-title" name="dtlms-class-tabs-title[]" class="large" type="text" placeholder="'.esc_html__('Title', 'dtlms').'" style="width:31.7%;" />';

            $tabs_content_type_options = array (
                'textarea' => esc_html__('Text Area', 'dtlms'),
                'page'     => esc_html__('Page', 'dtlms')
            );

            echo '<select id="dtlms-class-tabs-content-type" name="dtlms-class-tabs-content-type[]" data-placeholder="'.esc_html__('Select...', 'dtlms').'" class="dtlms-chosen-select-item">';
            foreach ($tabs_content_type_options as $tabs_content_type_option_key => $tabs_content_type_option){
                echo '<option value="' . esc_attr( $tabs_content_type_option_key ) . '">' . esc_html( $tabs_content_type_option ) . '</option>';
            }
            echo '</select>' ;

            echo '<div class="dtlms-class-tabs-content-textarea-holder">';
                echo '<textarea id="dtlms-class-tabs-content" name="dtlms-class-tabs-content[]" class="large" type="text" placeholder="'.esc_html__('Content', 'dtlms').'" style="width:100%; height:100px"></textarea>';
            echo '</div>';

            echo '<div class="dtlms-class-tabs-content-page-holder hidden">';
                $pages = get_pages();
                echo '<select id="dtlms-class-tabs-content-page" name="dtlms-class-tabs-content-page[]" data-placeholder="'.esc_html__('Select...', 'dtlms').'" class="dtlms-chosen-select-item">';
                    foreach ( $pages as $page ) {
                        echo '<option value="' . esc_attr( $page->ID ) . '">' . esc_html( $page->post_title ) . '</option>';
                    }
                echo '</select>' ;
            echo '</div>';
            ?>
            <span class="dtlms-remove-tab"><span class="fas fa-times"></span></span>
            <span class="fas fa-arrows-alt"></span>

        </div>

	</div>

</div>