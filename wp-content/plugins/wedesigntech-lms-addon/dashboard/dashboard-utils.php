<?php

// Administrator Dashboard
if(!function_exists('dtlms_get_administrator_dashboard')) {

	function dtlms_get_administrator_dashboard($user_id) {

		$output = '';

		$output .= do_shortcode(
			'<div class="dtlms-column dtlms-one-column first">

				<h2>'.esc_html__('Dashboard', 'dtlms').'</h2>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Total Items', 'dtlms').'</h3>
					[dtlms_total_items item-type="classes"]
					[dtlms_total_items item-type="courses"]
					[dtlms_total_items item-type="lessons"]
					[dtlms_total_items item-type="questions"]
					[dtlms_total_items item-type="quizzes"]
					[dtlms_total_items item-type="assignments"]
					[dtlms_total_items item-type="packages"]

				</div>

				<div class="dtlms-column dtlms-one-half first">
					[dtlms_total_items_chart chart-title="Total Items Added So Far"]
				</div>
				<div class="dtlms-column dtlms-one-half">
					[dtlms_total_items_chart chart-type="bar" chart-title="Total Items Added So Far"]
				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Overall Purchases', 'dtlms').'</h3>
					[dtlms_purchases_overview_chart include-class-purchases="true" include-course-purchases="true" include-package-purchases="true" enable-instructor-filter="true" include-data="true"]

				</div>

			</div>

			<div class="dtlms-column dtlms-one-column first">

				<h2>'.esc_html__('All Courses', 'dtlms').'</h2>
				<h3>'.esc_html__('All Courses - With Instructor Filter', 'dtlms').'</h3>
				[dtlms_instructor_courses enable-instructor-filter="true"]

			</div>

			<div class="dtlms-column dtlms-one-column first">

				<h2>'.esc_html__('All Classes', 'dtlms').'</h2>
				<h3>'.esc_html__('All Classes', 'dtlms').'</h3>
				[dtlms_class_details enable-instructor-filter="true"]

			</div>

			<div class="dtlms-column dtlms-one-column first">

				<h2>'.esc_html__('All Packages', 'dtlms').'</h2>
				<h3>'.esc_html__('All Packages', 'dtlms').'</h3>
				[dtlms_package_details]

			</div>

			<div class="dtlms-column dtlms-one-column first">

				<h2>'.esc_html__('All Students', 'dtlms').'</h2>
				<h3>'.esc_html__('All Students', 'dtlms').'</h3>
				[dtlms_student_courses]

			</div>

			<div class="dtlms-column dtlms-one-column first">

				<h2>'.esc_html__('All Instructors', 'dtlms').'</h2>
				<h3>'.esc_html__('All Instructors', 'dtlms').'</h3>
				[dtlms_instructor_added_courses]

			</div>

			<div class="dtlms-column dtlms-one-column first">

				<h2>'.esc_html__('Commission Details', 'dtlms').'</h2>

				<h3>'.esc_html__('Instructor Commissions - Course', 'dtlms').'</h3>
				[dtlms_instructor_commissions enable-instructor-filter="true"]

				<h3>'.esc_html__('Instructor Commissions - Class', 'dtlms').'</h3>
				[dtlms_instructor_commissions enable-instructor-filter="true" commission-content="class"]

				<h3>'.esc_html__('Instructor Commissions - Over Classes', 'dtlms').'</h3>
				[dtlms_instructor_commission_earnings enable-instructor-filter="true" instructor-earnings="over-item" timeline-filter="alltime" include-course-commission="false" include-class-commission="true" include-other-commission="false" include-total-commission="false"]

				<h3>'.esc_html__('Instructor Commissions - Over Courses', 'dtlms').'</h3>
				[dtlms_instructor_commission_earnings enable-instructor-filter="true" instructor-earnings="over-item" chart-type="pie" timeline-filter="alltime" include-class-commission="false" include-other-commission="false" include-total-commission="false"]

				<h3>'.esc_html__('Instructor Commissions - Over Period', 'dtlms').'</h3>
				[dtlms_instructor_commission_earnings enable-instructor-filter="true" include-class-commission="true" include-other-commission="false" include-total-commission="true"]

			</div>

			<div class="dtlms-column dtlms-one-column first">

				<h2>'.esc_html__('Instructing Items', 'dtlms').'</h2>

				<div class="dtlms-column dtlms-one-column first">
					<h3>'.esc_html__('Instructing Items - Overall', 'dtlms').'</h3>
					[dtlms_total_items item-type="classes" content-type="individual-items"]
					[dtlms_total_items item-type="courses" content-type="individual-items"]
					[dtlms_total_items item-type="lessons" content-type="individual-items"]
					[dtlms_total_items item-type="questions" content-type="individual-items"]
					[dtlms_total_items item-type="quizzes" content-type="individual-items"]
					[dtlms_total_items item-type="assignments" content-type="individual-items"]
					[dtlms_total_items item-type="packages" content-type="individual-items"]
				</div>

				<div class="dtlms-column dtlms-one-half first">
					[dtlms_total_items_chart content-type="individual-items" chart-title="Total Items Added So Far"]
				</div>
				<div class="dtlms-column dtlms-one-half">
					[dtlms_total_items_chart chart-type="bar" content-type="individual-items" chart-title="Total Items Added So Far"]
				</div>

				<div class="dtlms-column dtlms-one-column first">
					<h3>'.esc_html__('Instructing - Courses', 'dtlms').'</h3>
					[dtlms_instructor_courses enable-instructor-filter="false"]
				</div>
				<div class="dtlms-column dtlms-one-column first">
					<h3>'.esc_html__('Instructing - Classes', 'dtlms').'</h3>
					[dtlms_class_details enable-instructor-filter="false"]
				</div>

			</div>

			<div class="dtlms-column dtlms-one-column first">

				<h2>'.esc_html__('My Courses', 'dtlms').'</h2>

				<div class="dtlms-column dtlms-one-half first">
				<h3>'.esc_html__('Badges', 'dtlms').'</h3>
				[dtlms_student_badges item-type="all"]
				</div>
				<div class="dtlms-column dtlms-one-half">
				<h3>'.esc_html__('Certificates', 'dtlms').'</h3>
				[dtlms_student_certificates item-type="all"]
				</div>

				<div class="dtlms-column dtlms-one-column first">
					<h3>'.esc_html__('Courses', 'dtlms').'</h3>
					[dtlms_student_purchased_items item-type="course"]
					[dtlms_student_assigned_items item-type="course"]
					[dtlms_student_undergoing_items item-type="course"]
					[dtlms_student_underevaluation_items item-type="course"]
					[dtlms_student_completed_items item-type="course"]
				</div>

				<div class="dtlms-column dtlms-one-column first">
					<h3>'.esc_html__('Classes', 'dtlms').'</h3>
					[dtlms_student_purchased_items item-type="class"]
					[dtlms_student_assigned_items item-type="class"]
					[dtlms_student_undergoing_items item-type="class"]
					[dtlms_student_underevaluation_items item-type="class"]
					[dtlms_student_completed_items item-type="class"]
				</div>

				<div class="dtlms-column dtlms-one-column first">
					<h3>'.esc_html__('Packages', 'dtlms').'</h3>
					[dtlms_student_purchased_items item-type="package"]
				</div>

				<div class="dtlms-column dtlms-one-half first">

					<h3>'.esc_html__('Courses', 'dtlms').'</h3>

					<h3>'.esc_html__('Student Purchased Items List', 'dtlms').'</h3>
					[dtlms_student_purchased_items_list item-type="course"]

					<h3>'.esc_html__('Student Assigned Items List', 'dtlms').'</h3>
					[dtlms_student_assigned_items_list item-type="course"]

					<h3>'.esc_html__('Student Undergoing Items List', 'dtlms').'</h3>
					[dtlms_student_undergoing_items_list item-type="course"]

					<h3>'.esc_html__('Student Under Evaluation Items List', 'dtlms').'</h3>
					[dtlms_student_underevaluation_items_list item-type="course"]

					<h3>'.esc_html__('Student Completed Items List', 'dtlms').'</h3>
					[dtlms_student_completed_items_list item-type="course"]

				</div>
				<div class="dtlms-column dtlms-one-half">

					<h3>'.esc_html__('Classes', 'dtlms').'</h3>

					<h3>'.esc_html__('Student Purchased Items List', 'dtlms').'</h3>
					[dtlms_student_purchased_items_list item-type="class"]

					<h3>'.esc_html__('Student Assigned Items List', 'dtlms').'</h3>
					[dtlms_student_assigned_items_list item-type="class"]

					<h3>'.esc_html__('Student Undergoing Items List', 'dtlms').'</h3>
					[dtlms_student_undergoing_items_list item-type="class"]

					<h3>'.esc_html__('Student Under Evaluation Items List', 'dtlms').'</h3>
					[dtlms_student_underevaluation_items_list item-type="class"]

					<h3>'.esc_html__('Student Completed Items List', 'dtlms').'</h3>
					[dtlms_student_completed_items_list item-type="class"]

				</div>

				<div class="dtlms-column dtlms-one-half first">
					<h3>'.esc_html__('Course Curriculum Details', 'dtlms').'</h3>
					[dtlms_student_course_curriculum_details]
				</div>
				<div class="dtlms-column dtlms-one-half">
					<h3>'.esc_html__('Class Curriculum Details', 'dtlms').'</h3>
					[dtlms_student_class_curriculum_details]
				</div>

				<div class="dtlms-column dtlms-one-column first">
					<h3>'.esc_html__('Student Purchased Items List', 'dtlms').'</h3>
					[dtlms_student_purchased_items_list item-type="package"]
				</div>

				<div class="dtlms-column dtlms-one-column first">
					<h3>'.esc_html__('Course Events', 'dtlms').'</h3>
					[dtlms_student_course_events]
				</div>

			</div>'
		);

		return $output;

	}

}

// Instructor Dashboard
if(!function_exists('dtlms_get_instructor_dashboard')) {

	function dtlms_get_instructor_dashboard($user_id) {

		$output = '';

		$output .= do_shortcode(
			'<div class="dtlms-column dtlms-one-column first">

				<h2>'.esc_html__('Overview', 'dtlms').'</h2>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Total Items', 'dtlms').'</h3>

					[dtlms_total_items item-type="classes"]
					[dtlms_total_items item-type="courses"]
					[dtlms_total_items item-type="lessons"]
					[dtlms_total_items item-type="questions"]
					[dtlms_total_items item-type="quizzes"]
					[dtlms_total_items item-type="assignments"]
					[dtlms_total_items item-type="packages"]

				</div>

				<div class="dtlms-column dtlms-one-half first">
					[dtlms_total_items_chart chart-title="Total Items Added So Far"]
				</div>
				<div class="dtlms-column dtlms-one-half">
					[dtlms_total_items_chart chart-type="bar" chart-title="Total Items Added So Far"]
				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Overall Purchases', 'dtlms').'</h3>
					[dtlms_purchases_overview_chart include-class-purchases="true" include-course-purchases="true" include-package-purchases="true" enable-instructor-filter="true" include-data="true"]

				</div>

			</div>

			<div class="dtlms-column dtlms-one-column first">

				<h3>'.esc_html__('Instructing Courses', 'dtlms').'</h3>

				[dtlms_instructor_courses enable-instructor-filter="false"]

			</div>

			<div class="dtlms-column dtlms-one-column first">

				<h3>'.esc_html__('Instructing Classes', 'dtlms').'</h3>

				[dtlms_class_details enable-instructor-filter="false"]

			</div>

			<div class="dtlms-column dtlms-one-column first">

				<h3>'.esc_html__('Commission Details', 'dtlms').'</h3>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Instructor Commissions - Course', 'dtlms').'</h3>
					[dtlms_instructor_commissions enable-instructor-filter="false"]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Instructor Commissions - Class', 'dtlms').'</h3>
					[dtlms_instructor_commissions enable-instructor-filter="false" commission-content="class"]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Instructor Commission - Over Classes', 'dtlms').'</h3>
					[dtlms_instructor_commission_earnings enable-instructor-filter="false" instructor-earnings="over-item" timeline-filter="alltime" include-course-commission="false" include-class-commission="true" include-other-commission="false" include-total-commission="false"]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Instructor Commission - Over Courses', 'dtlms').'</h3>
					[dtlms_instructor_commission_earnings enable-instructor-filter="false" instructor-earnings="over-item" chart-type="pie" timeline-filter="alltime" include-class-commission="false" include-other-commission="false" include-total-commission="false"]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Instructor Commission - Over Period', 'dtlms').'</h3>
					[dtlms_instructor_commission_earnings enable-instructor-filter="false" include-class-commission="true" include-other-commission="false" include-total-commission="true"]

				</div>

			</div>

			<div class="dtlms-column dtlms-one-column first">

				<h2>'.esc_html__('My Courses', 'dtlms').'</h2>

				<div class="dtlms-column dtlms-one-half first">

					<h3>'.esc_html__('Badges', 'dtlms').'</h3>
					[dtlms_student_badges item-type="all"]

				</div>

				<div class="dtlms-column dtlms-one-half">

					<h3>'.esc_html__('Certificates', 'dtlms').'</h3>
					[dtlms_student_certificates item-type="all"]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Courses', 'dtlms').'</h3>
					[dtlms_student_purchased_items item-type="course"]
					[dtlms_student_assigned_items item-type="course"]
					[dtlms_student_undergoing_items item-type="course"]
					[dtlms_student_underevaluation_items item-type="course"]
					[dtlms_student_completed_items item-type="course"]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Classes', 'dtlms').'</h3>
					[dtlms_student_purchased_items item-type="class"]
					[dtlms_student_assigned_items item-type="class"]
					[dtlms_student_undergoing_items item-type="class"]
					[dtlms_student_underevaluation_items item-type="class"]
					[dtlms_student_completed_items item-type="class"]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Packages', 'dtlms').'</h3>
					[dtlms_student_purchased_items item-type="package"]

				</div>


				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Courses', 'dtlms').'</h3>
					[dtlms_student_purchased_items_list item-type="course"]
					[dtlms_student_assigned_items_list item-type="course"]
					[dtlms_student_undergoing_items_list item-type="course"]
					[dtlms_student_underevaluation_items_list item-type="course"]
					[dtlms_student_completed_items_list item-type="course"]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Classes', 'dtlms').'</h3>
					[dtlms_student_purchased_items_list item-type="class"]
					[dtlms_student_assigned_items_list item-type="class"]
					[dtlms_student_undergoing_items_list item-type="class"]
					[dtlms_student_underevaluation_items_list item-type="class"]
					[dtlms_student_completed_items_list item-type="class"]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Packages', 'dtlms').'</h3>
					[dtlms_student_purchased_items_list item-type="package"]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Course Curriculum Details', 'dtlms').'</h3>
					[dtlms_student_course_curriculum_details]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Class Curriculum Details', 'dtlms').'</h3>
					[dtlms_student_class_curriculum_details]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Course Events', 'dtlms').'</h3>
					[dtlms_student_course_events]

				</div>

			</div>'
		);

		return $output;

	}

}

// Student Dashboard
if(!function_exists('dtlms_get_student_dashboard')) {

	function dtlms_get_student_dashboard($user_id) {

		$output = '';

		$output .= do_shortcode(
			'<div class="dtlms-column dtlms-one-column first">

				<h2>'.esc_html__('Overview', 'dtlms').'</h2>

				<div class="dtlms-column dtlms-one-half first">
					<h3>'.esc_html__('Badges', 'dtlms').'</h3>
					[dtlms_student_badges item-type="all"]
				</div>
				<div class="dtlms-column dtlms-one-half">
					<h3>'.esc_html__('Certificates', 'dtlms').'</h3>
					[dtlms_student_certificates item-type="all"]
				</div>

			</div>

			<div class="dtlms-column dtlms-one-column first">

				<h2>'.esc_html__('Courses', 'dtlms').'</h2>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Courses', 'dtlms').'</h3>

					[dtlms_student_purchased_items item-type="course"]
					[dtlms_student_purchased_items_list item-type="course"]

					[dtlms_student_assigned_items item-type="course"]
					[dtlms_student_assigned_items_list item-type="course"]

					[dtlms_student_underevaluation_items item-type="course"]
					[dtlms_student_underevaluation_items_list item-type="course"]

					[dtlms_student_undergoing_items item-type="course"]
					[dtlms_student_undergoing_items_list item-type="course"]

					[dtlms_student_completed_items item-type="course"]
					[dtlms_student_completed_items_list item-type="course"]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Course Curriculum Details', 'dtlms').'</h3>
					[dtlms_student_course_curriculum_details]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Course Events', 'dtlms').'</h3>
					[dtlms_student_course_events]

				</div>

			</div>

			<div class="dtlms-column dtlms-one-column first">

				<h2>'.esc_html__('Classes', 'dtlms').'</h2>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Classes', 'dtlms').'</h3>

					[dtlms_student_purchased_items item-type="class"]
					[dtlms_student_purchased_items_list item-type="class"]

					[dtlms_student_assigned_items item-type="class"]
					[dtlms_student_assigned_items_list item-type="class"]

					[dtlms_student_underevaluation_items item-type="class"]
					[dtlms_student_underevaluation_items_list item-type="class"]

					[dtlms_student_undergoing_items item-type="class"]
					[dtlms_student_undergoing_items_list item-type="class"]

					[dtlms_student_completed_items item-type="class"]
					[dtlms_student_completed_items_list item-type="class"]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Class Curriculum Details', 'dtlms').'</h3>
					[dtlms_student_class_curriculum_details]

				</div>

				<div class="dtlms-column dtlms-one-column first">

					<h3>'.esc_html__('Packages', 'dtlms').'</h3>
					[dtlms_student_purchased_items item-type="package"]
					[dtlms_student_purchased_items_list item-type="package"]

				</div>

			</div>'
		);

		return $output;

	}

}

?>