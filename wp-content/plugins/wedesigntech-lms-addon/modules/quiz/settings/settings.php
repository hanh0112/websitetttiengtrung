<?php

function dtlms_settings_import_content() {

	$output = '';

	$output .= '<div class="dtlms-settings-import-container">';

		$output .= '<p>';
			$output .= '<label>'.esc_html__('Import Option', 'dtlms').'</label>';
			$output .= '<select name="dtlms-import-type" class="dtlms-import-type">';
					$import_types = array('question' => 'Question', 'quiz' => 'Quiz');
					foreach ($import_types as $import_type => $import_type_label){
						$output .= '<option value="'.$import_type.'">'.$import_type_label.'</option>';
					}
			$output .= '</select>';
		$output .= '</p>';

		$output .= '<input type="button" name="dtlms-chooseupload-file-button" class="dtlms-chooseupload-file-button" value="'.esc_html__('Choose / Upload File', 'dtlms').'">';

		$output .= '<input type="text" name="dtlms-import-file" class="dtlms-import-file" style="width:30%;" value="">';

		$output .= '<a href="#" class="dtlms-button dtlms-import-file-button small">'.esc_html__('Import', 'dtlms').'</a>';

	$output .= '</div>';

	$output .= dtlms_generate_loader_html(true);

	$output .= '<div class="dtlms-settings-import-output-container"></div>';

	$output .= '<div class="dtlms-hr-invisible"></div>';

	$output .= '<h4><strong>'.esc_html__('Question CSV Sample File Format', 'dtlms').'</strong></h4>';

	$output .= '<div class="dtlms-settings-data-holder">';

		$output .= '<table class="dtlms-custom-table" style="width:100%">
						<tr>
							<th>'.esc_html__('Title', 'dtlms').'</th>
							<th>'.esc_html__('Question', 'dtlms').'</th>
							<th>'.esc_html__('Question Type', 'dtlms').' (multiple-choice,multiple-choice-image,multiple-correct,boolean,gap-fill,single-line,multi-line)</th>
							<th>'.esc_html__('Answers', 'dtlms').' ( Separate answers with "|" )</th>
							<th>'.esc_html__('Correct Answer', 'dtlms').' ( Separate answers with "|" )</th>
							<th>'.esc_html__('Answer Hint', 'dtlms').'</th>
							<th>'.esc_html__('Answer Explanation', 'dtlms').'</th>
						</tr>
						<tr>
							<td>Question 1</td>
							<td><h4>In this problem, what is 6?</h4>2 X 6 = 12</td>
							<td>multiple-choice</td>
							<td>Sum|Addend|Factor|Product</td>
							<td>Product</td>
							<td>Shop</td>
							<td><p>In this problem, <b>6 is an product.</b></p></td>
						</tr>
						<tr>
							<td>Question 2</td>
							<td>Out of which are all contients?</td>
							<td>multiple-correct</td>
							<td>Asia|India|Africa|Mexico|America</td>
							<td>Asia|Africa|America</td>
							<td>Continent</td>
							<td>Africa, the Americas, Antarctica, Asia, Australia together with Oceania, and Europe are considered to be Continents.</td>
						</tr>
					</table>';

	$output .= '</div>';

	$output .= '<div class="dtlms-hr-invisible"></div>';

	$output .= '<h4><strong>'.esc_html__('Quiz CSV Sample File Format', 'dtlms').'</strong></h4>';

	$output .= '<div class="dtlms-settings-data-holder"">';

		$output .= '<table class="dtlms-custom-table" style="width:100%">
						<tr>
							<th>'.esc_html__('Title', 'dtlms').'</th>
							<th>'.esc_html__('Content', 'dtlms').'</th>
							<th>'.esc_html__('Free Quiz', 'dtlms').'  ( true / false )</th>
							<th>'.esc_html__('Subttile', 'dtlms').'</th>
							<th>'.esc_html__('Duration', 'dtlms').' ( Number )</th>
							<th>'.esc_html__('Duration Parameter', 'dtlms').' ( seconds, minutes, hours, days, weeks, months, years )</th>
							<th>'.esc_html__('Number of Retakes', 'dtlms').' ( Number )</th>
							<th>'.esc_html__('Post Quiz Message', 'dtlms').'</th>
							<th>'.esc_html__('Randomize Questions', 'dtlms').' ( true / false )</th>
							<th>'.esc_html__('Enable Auto Evaluation', 'dtlms').' ( true / false )</th>
							<th>'.esc_html__('Mark As Graded In Auto Evaluation', 'dtlms').' ( true / false )</th>
							<th>'.esc_html__('Question Type', 'dtlms').'  ( add-questions / add-categories )</th>
							<th>'.esc_html__('Add Questions', 'dtlms').' ( questionno|questionno#questionmark|questionmark#questionnegativemark|questionnegativemark )</th>
							<th>'.esc_html__('Add Categories', 'dtlms').' ( categoryid|categoryid#numberofquestionstopick|numberofquestionstopick#gradeperquestion|gradeperquestion#negativegradeperquestion|negativegradeperquestion )</th>
							<th>'.esc_html__('Pass Percentage', 'dtlms').' ( Number )</th>
							<th>'.esc_html__('Show Questions One By One', 'dtlms').' ( true / false )</th>
							<th>'.esc_html__('Show Correct Answer and Answer Explanation', 'dtlms').' ( true / false )</th>
							<th>'.esc_html__('Show Question Counter', 'dtlms').' ( true / false )</th>
						</tr>
						<tr>
							<td>Quiz 1</td>
							<td>Consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</td>
							<td>false</td>
							<td>Porttitor eu 123</td>
							<td>45</td>
							<td>minutes</td>
							<td>10</td>
							<td>Aenean leo ligula, porttitor eu</td>
							<td>true</td>
							<td>true</td>
							<td>false</td>
							<td>add-questions</td>
							<td>1001|1002#10|10#-1|-1</td>
							<td></td>
							<td>90</td>
							<td>true</td>
							<td>true</td>
							<td>true</td>
						</tr>
							<td>Quiz 2</td>
							<td>Consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</td>
							<td>false</td>
							<td>Aliquam lorem ante</td>
							<td>30</td>
							<td>minutes</td>
							<td>10</td>
							<td>Aenean leo ligula, porttitor eu</td>
							<td>true</td>
							<td>true</td>
							<td>false</td>
							<td>add-categories</td>
							<td></td>
							<td>20|21#4|6#10|10#-1|-1</td>
							<td>90</td>
							<td>true</td>
							<td>true</td>
							<td>true</td>
						</tr>
					</table>';

	$output .= '</div>';

	return $output;

}

echo dtlms_settings_import_content();

?>