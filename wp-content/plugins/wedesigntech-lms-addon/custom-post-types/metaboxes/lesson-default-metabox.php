<?php
global $post;
$post_id = $post->ID;
echo '<input type="hidden" name="dtlms_lessons_meta_nonce" value="'.wp_create_nonce('dtlms_lessons_nonce').'" />';

$current_user = wp_get_current_user();
$current_user_id = $current_user->ID;
?>

<!-- Free Lesson -->
<div class="dtlms-custom-box">
    <div class="dtlms-column dtlms-one-sixth first">
        <label><?php esc_html_e( 'Unlock Lesson','dtlms');?></label>
    </div>
    <div class="dtlms-column dtlms-five-sixth">
        <?php
        $free_lesson = get_post_meta ( $post_id, 'free-lesson', true );
        $switchclass = ($free_lesson == true) ? 'checkbox-switch-on' : 'checkbox-switch-off';
        $checked = ($free_lesson == true) ? ' checked="checked"' : '';
        ?>
        <div data-for="free-lesson" class="dtlms-checkbox-switch <?php echo esc_attr($switchclass);?>"></div>
        <input id="free-lesson" class="hidden" type="checkbox" name="free-lesson" value="true" <?php echo dtlms_html_output($checked);?>/>
        <p class="dtlms-note"> <?php echo esc_html__('YES! to unlock this lesson, so that you can use this lesson as preview. It won\'t be affected by "Curriculum Completion Lock" in course settings.','dtlms');?> </p>
    </div>
</div>
<!-- Free Lesson End -->

<!-- Lesson Curriculum -->
<div class="dtlms-custom-box">

    <div class="dtlms-column dtlms-one-sixth first">
       <label><?php esc_html_e('Curriculum','dtlms'); ?></label>
    </div>

    <div class="dtlms-column dtlms-five-sixth">

        <?php
        $dtlms_course_curriculums = apply_filters( 'dtlms_course_curriculums', array () );
        unset($dtlms_course_curriculums['dtlms_lessons']);

        if(is_array($dtlms_course_curriculums) && !empty($dtlms_course_curriculums)) {

            $dtlms_course_curriculum_keys = array_keys($dtlms_course_curriculums);
            ?>

            <div id="dtlms-curriculum-items-container">

                <?php

                $lesson_curriculum = get_post_meta ( $post_id, 'lesson-curriculum', true);

                if(isset($lesson_curriculum) && is_array($lesson_curriculum)) {

                    foreach($lesson_curriculum as $curriculum) {

                            if(is_numeric($curriculum)) {

                                $curriculum_post_type = get_post_type($curriculum);

                                if(in_array($curriculum_post_type, $dtlms_course_curriculum_keys)) {

                                    echo '<div id="dtlms-curriculum-section-item">';

                                        echo '<label>'.$dtlms_course_curriculums[$curriculum_post_type]['singular_label'].'</label>';

                                        $args = array (
                                            'post_type'        => $curriculum_post_type,
                                            'numberposts'      => -1,
                                            'suppress_filters' => false,
                                        );

                                        if ( !in_array( 'administrator', (array) $current_user->roles ) ) {
                                            $args['author'] = $current_user_id;
                                        }

                                        $post_types = get_posts($args);

                                        echo '<select data-placeholder="'.esc_html__('Select...', 'dtlms').'" class="cc-select" id="lesson-curriculum" name="lesson-curriculum[]">';
                                            foreach ( $post_types as $post_type ){
                                                echo '<option value="'.$post_type->ID.'" '.selected( $post_type->ID, $curriculum, false ).'>' . $post_type->post_title . '</option>';
                                            }
                                        echo '</select>';

                                        wp_reset_postdata();

                                        echo '<span class="dtlms-remove-curriculum-item"><span class="fas fa-times"></span></span>';
                                        echo '<span class="fas fa-arrows-alt"></span>';

                                    echo '</div>';

                                }

                            } else {

                                echo '<div id="dtlms-curriculum-section-item">';

                                    echo '<label>'.esc_html__('Section', 'dtlms').'</label>';
                                    echo '<input type="text" value="'.$curriculum.'" id="lesson-curriculum" name="lesson-curriculum[]" />';

                                    echo '<span class="dtlms-remove-curriculum-item"><span class="fas fa-times"></span></span>';
                                    echo '<span class="fas fa-arrows-alt"></span>';

                                echo '</div>';

                            }

                    }

                }
                ?>

            </div>

            <a href="#" class="dtlms-add-curriculum section custom-button-style" data-curriculumtype="lesson"><?php esc_html_e('Add Section', 'dtlms'); ?></a>

            <?php
            foreach($dtlms_course_curriculums as $dtlms_course_curriculum) {
                echo '<a href="#" class="dtlms-add-curriculum '.$dtlms_course_curriculum['singular_slug'].' custom-button-style" data-curriculumtype="lesson">'.sprintf(esc_html__('Add %1$s', 'dtlms'), $dtlms_course_curriculum['singular_label']).'</a>';
            }
            ?>

            <p class="dtlms-note">
                <?php
                esc_html_e('Add sections, lessons, quiz, lessons here. Make sure you have created them already.','dtlms');
                echo "<br>";
                esc_html_e('Leave empty if you don\'t like to use sub items.','dtlms');
                echo "<br>";
                esc_html_e('Make sure you haven\'t repeated any curriculum.', 'dtlms');
                ?>
            </p>

            <div id="dtlms-curriculum-section-to-clone" class="hidden">

                <label><?php echo esc_html__('Section', 'dtlms'); ?></label>

                <?php
                echo '<input type="text" placeholder="'.esc_html__('Section Title', 'dtlms').'" />';
                ?>

                <span class="dtlms-remove-curriculum-item"><span class="fas fa-times"></span></span>
                <span class="fas fa-arrows-alt"></span>

            </div>

            <?php
            foreach($dtlms_course_curriculums as $dtlms_course_curriculum) {
                echo '<div id="dtlms-curriculum-'.$dtlms_course_curriculum['singular_slug'].'-to-clone" class="hidden">';

                    echo '<label>'.$dtlms_course_curriculum['singular_label'].'</label>';

                    $args = array (
                                    'post_type'        => $dtlms_course_curriculum['post_type'],
                                    'numberposts'      => -1,
                                    'suppress_filters' => FALSE,
                                );
                    if ( !in_array( 'administrator', (array) $current_user->roles ) ) {
                        $args['author'] = $current_user_id;
                    }

                    $curriculum_posts = get_posts($args);

                    echo '<select data-placeholder="'.sprintf(esc_html__('Select %1$s...', 'dtlms'), $dtlms_course_curriculum['singular_label']).'" class="cc-select">';
                    foreach ( $curriculum_posts as $curriculum_post ){
                        echo '<option value="' . $curriculum_post->ID . '">' . $curriculum_post->post_title . '</option>';
                    }
                    echo '</select>';

                    wp_reset_postdata();

                    echo '<span class="dtlms-remove-curriculum-item"><span class="fas fa-times"></span></span>';
                    echo '<span class="fas fa-arrows-alt"></span>';

                echo '</div>';
            }

        }
        ?>

    </div>

</div>
<!-- Lesson Curriculum End -->

<div class="dtlms-custom-box">

    <!-- Drip Duration -->
    <div class="dtlms-column dtlms-one-half first">

        <div class="dtlms-column dtlms-one-third first">
           <label><?php esc_html_e('Duration', 'dtlms'); ?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
            <?php $duration = get_post_meta ( $post_id, 'duration', true ); ?>
            <input type="number" id="duration" name="duration" value="<?php echo esc_attr($duration); ?>" min="0" >
            <p class="dtlms-note"> <?php esc_html_e('Add duration here.','dtlms');?> </p>
        </div>

    </div>
    <!-- Drip Duration End -->

    <!-- Drip Duration Parameter -->
    <div class="dtlms-column dtlms-one-half">

        <div class="dtlms-column dtlms-one-third first">
           <label><?php esc_html_e('Duration Parameter','dtlms');?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
            <?php
            $duration_parameter = get_post_meta ( $post_id, 'duration-parameter', true );
            $durationparameters = array ('60' => 'Minutes', '3600' => 'Hours', '86400' => 'Days', '604800' => 'Weeks', '2592000' => 'Months');

            echo '<select name="duration-parameter" data-placeholder="'.esc_html__('Select Duration Parameter...', 'dtlms').'" class="dtlms-chosen-select">';
            echo '<option value="">' . esc_html__( 'None', 'dtlms' ) . '</option>';
            foreach ($durationparameters as $durationparameter_key => $durationparameter){
                echo '<option value="' . esc_attr( $durationparameter_key ) . '"' . selected( $durationparameter_key, $duration_parameter, false ) . '>' . esc_html( $durationparameter ) . '</option>';
            }
            echo '</select>' ;
            ?>
            <p class="dtlms-note"> <?php esc_html_e('Choose duration parameter here.','dtlms');?> </p>
        </div>

    </div>
    <!-- Drip Duration Parameter End -->

</div>

<div class="dtlms-custom-box">

    <!-- Co Teachers -->

        <div class="dtlms-column dtlms-one-sixth first">
            <label><?php esc_html_e('Teachers ','dtlms'); ?></label>
        </div>

        <div class="dtlms-column dtlms-five-sixth">
            <?php
            $out = '';
            $teacher = get_post_meta ( $post_id, 'teacher', true );

            echo '<select id="teacher" name="teacher[]" data-placeholder="'.__('Select Teachers...', 'dtlms').'" class="dtlms-chosen-select">';

                    $out .= '<option value="">' . esc_html__( 'None', 'dtlms' ) . '</option>';
                    $args = array( 'role' => 'instructor' );
                    $user_query = new WP_User_Query( $args );
                    if ( !empty( $user_query->results ) ) {
                        foreach ( $user_query->results as $user ) {
                            $selected = (!empty($teacher) && in_array($user->ID , $teacher )) ? 'selected="selected"' : '';
                            echo '<option value="' . esc_attr( $user->ID ) . '"' . $selected . '>' . esc_html( $user->display_name ) . '</option>';
                        }
                    }
                    echo dtlms_html_output($out);

            echo '</select>';
            ?>
            <p class="dtlms-note"> <?php esc_html_e('Add Teachers for this Lesson.', 'dtlms');?> </p>
        </div>
    <!-- Teachers End -->

</div>

<div class="dtlms-custom-box">

    <!-- Maximum Mark -->
    <div class="dtlms-column dtlms-one-half first">
        <div class="dtlms-column dtlms-one-third first">
           <label><?php esc_html_e('Maximum Mark', 'dtlms'); ?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
            <?php $lesson_maximum_mark = get_post_meta ( $post_id, 'lesson-maximum-mark', true ); ?>
            <input id="lesson-maximum-mark" name="lesson-maximum-mark" type="number" value="<?php echo esc_attr($lesson_maximum_mark); ?>" style="width:10%;" min="1" />
            <p class="dtlms-note"> <?php esc_html_e('Maximum mark for lesson. Default value is 100.','dtlms');?> </p>
        </div>
    </div>
    <!-- Maximum Mark End -->

    <!-- Pass Percentage -->

    <div class="dtlms-column dtlms-one-half">
    </div>
    <!-- Pass Percentage End -->

</div>