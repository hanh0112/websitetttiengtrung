var dtLMSQuizBackendUtils = {

	dtLMSQuizCategoryOnChange : function() {

		jQuery('body').delegate('#dtlms-quiz-categories', 'change', function(e){
			jQuery(this).parents('#dtlms-category-box').find('#dtlms-quiz-categories-questions').attr('max', jQuery(this).find('option:selected').attr('data-count'));
		});

	},

	dtLMSCompletionLockDripFeedSwitch : function() {

		jQuery('body').delegate('#drip-completionlock-switch', 'change', function(e){

			var drip_completionlock = jQuery(this).val();

			jQuery('.dtlms-completionlock-holder').slideUp();
			jQuery('.dtlms-dripfeed-holder').slideUp();

			if(drip_completionlock == 'completionlock') {

				jQuery('.dtlms-completionlock-holder').slideDown();
				jQuery('.dtlms-dripfeed-holder').slideUp();

			} else if(drip_completionlock == 'dripfeed') {

				jQuery('.dtlms-completionlock-holder').slideUp();
				jQuery('.dtlms-dripfeed-holder').slideDown();

			}

		});

	},

	dtLMSSidebarContentSwitch : function() {

		jQuery('body').delegate('#sidebar-content-type', 'change', function(e){

			var sidebar_content_type = jQuery(this).val();

			if(sidebar_content_type == 'page') {

				jQuery('.dtlms-sidebar-content-page-holder').slideDown();
				jQuery('.dtlms-sidebar-content-textarea-holder').slideUp();

			} else {

				jQuery('.dtlms-sidebar-content-page-holder').slideUp();
				jQuery('.dtlms-sidebar-content-textarea-holder').slideDown();

			}

		});

	},

	dtLMSClassTabsContentSwitch : function() {

		jQuery('body').delegate('#dtlms-class-tabs-content-type', 'change', function(e){

			var tabs_content_type = jQuery(this).val();

			if(tabs_content_type == 'page') {

				jQuery(this).parents('.dtlms-tab-box').find('.dtlms-class-tabs-content-page-holder').slideDown();
				jQuery(this).parents('.dtlms-tab-box').find('.dtlms-class-tabs-content-textarea-holder').slideUp();

			} else {

				jQuery(this).parents('.dtlms-tab-box').find('.dtlms-class-tabs-content-page-holder').slideUp();
				jQuery(this).parents('.dtlms-tab-box').find('.dtlms-class-tabs-content-textarea-holder').slideDown();

			}

		});

	},

};

var dtLMSQuizBackend = {

	dtInit : function() {
		dtLMSQuizBackend.dtQuizzes();
		dtLMSQuizBackend.dtQuestions();
		dtLMSQuizBackend.dtGradings();
		dtLMSQuizBackend.dtImport();
	},

	dtQuizzes : function() {

		dtLMSQuizBackendUtils.dtLMSQuizCategoryOnChange();

		jQuery('body').delegate('select#dtlms-quiz-question-type', 'change', function(e){

			jQuery('.dtlms-add-questions-holder').slideDown();
			jQuery('.dtlms-add-categories-holder').slideUp();
			if(jQuery(this).val() == 'add-categories') {
				jQuery('.dtlms-add-questions-holder').slideUp();
				jQuery('.dtlms-add-categories-holder').slideDown();
			}

			e.preventDefault();

		});

		jQuery('a.dtlms-add-questions').on('click', function(e){

			var clone = jQuery("#dtlms-questions-to-clone").clone();

			clone.attr('id', 'dtlms-question-box').removeClass('hidden');
			clone.find('select').attr('id', 'dtlms-quiz-question').attr('name', 'dtlms-quiz-question[]').attr('class', 'dtlms-new-chosen-select');
			clone.find('.question-grade').attr('id', 'dtlms-quiz-question-grade').attr('name', 'dtlms-quiz-question-grade[]').removeClass('question-grade').attr('required', 'required');
			clone.find('.question-negative-grade').attr('id', 'dtlms-quiz-question-negative-grade').attr('name', 'dtlms-quiz-question-negative-grade[]').removeClass('question-negative-grade');

			clone.appendTo('#dtlms-quiz-questions-container');

			jQuery(".dtlms-new-chosen-select").chosen({
				no_results_text: lmsquizbackendobject.noResult,
			});

			e.preventDefault();

		});

		jQuery('body').delegate('span.dtlms-remove-question','click', function(e){

			jQuery(this).parents('#dtlms-question-box').remove();
			jQuery( "#dtlms-quiz-question-grade" ).trigger( "change" );

			e.preventDefault();

		});

		jQuery('body').delegate('#dtlms-quiz-question-grade', 'change', function(){

			 var total = parseInt(0);
			 jQuery('#dtlms-quiz-questions-container #dtlms-question-box').each(function(){
				var ival = jQuery(this).find('#dtlms-quiz-question-grade').val();
				if(ival == 'NAN' || ival ==''){
					ival = parseInt(0);
				}
				total = parseInt(total) + parseInt(ival);
			 });

			 jQuery(this).parents('.dtlms-column').find('#dtlms-total-marks-container span').html(total);
			 jQuery(this).parents('.dtlms-column').find('#dtlms-total-marks-container input[type="hidden"]').val(total);

		});

		jQuery('#dtlms-quiz-questions-container').sortable({ placeholder: 'sortable-placeholder' });

		jQuery('a.dtlms-add-categories').on('click', function(e){

			var clone = jQuery("#dtlms-categories-to-clone").clone();

			clone.attr('id', 'dtlms-category-box').removeClass('hidden');
			clone.find('select').attr('id', 'dtlms-quiz-categories').attr('name', 'dtlms-quiz-categories[]').attr('class', 'dtlms-new-chosen-select');
			clone.find('.quiz-category-questions').attr('id', 'dtlms-quiz-categories-questions').attr('name', 'dtlms-quiz-categories-questions[]').removeClass('quiz-category-questions').attr('required', 'required');
			clone.find('.quiz-category-grade').attr('id', 'dtlms-quiz-categories-grade').attr('name', 'dtlms-quiz-categories-grade[]').removeClass('quiz-category-grade').attr('required', 'required');
			clone.find('.quiz-category-negative-grade').attr('id', 'dtlms-quiz-categories-negative-grade').attr('name', 'dtlms-quiz-categories-negative-grade[]').removeClass('quiz-category-negative-grade');

			clone.appendTo('#dtlms-quiz-categories-container');

			jQuery(".dtlms-new-chosen-select").chosen({
				no_results_text: lmsquizbackendobject.noResult,
			});

			dtLMSQuizBackendUtils.dtLMSQuizCategoryOnChange();

			e.preventDefault();

		});

		jQuery('body').delegate('span.dtlms-remove-category','click', function(e){

			jQuery(this).parents('#dtlms-category-box').remove();
			jQuery( "#dtlms-quiz-categories-grade" ).trigger( "change" );

			e.preventDefault();

		});

		jQuery('body').delegate('#dtlms-quiz-categories-questions, #dtlms-quiz-categories-grade', 'change', function(){

			 var total = parseInt(0);
			 jQuery('#dtlms-quiz-categories-container #dtlms-category-box').each(function(){
				var questions = jQuery(this).find('#dtlms-quiz-categories-questions').val();
				if(questions == 'NAN' || questions ==''){
					questions = parseInt(0);
				}
				var grade = jQuery(this).find('#dtlms-quiz-categories-grade').val();
				if(grade == 'NAN' || grade ==''){
					grade = parseInt(0);
				}

				total = parseInt(total) + (parseInt(questions)*parseInt(grade));
			 });

			 jQuery(this).parents('.dtlms-column').find('#dtlms-total-marks-container span').html(total);
			 jQuery(this).parents('.dtlms-column').find('#dtlms-total-marks-container input[type="hidden"]').val(total);

		});

		jQuery('#dtlms-quiz-categories-container').sortable({ placeholder: 'sortable-placeholder' });

	},

	dtQuestions : function() {

		// Multichoice answers script
		jQuery('a.dtlms-add-multichoice-answer').on('click', function(e){

			var wrong_ans_cnt = jQuery("div.dtlms-multichoice-answer-clone").find('#dt_multichoice_answers_cnt').val();
			wrong_ans_cnt = parseInt(wrong_ans_cnt)+1;
			jQuery("div.dtlms-multichoice-answer-clone").find('#dt_multichoice_answers_cnt').val(wrong_ans_cnt);

			jQuery("div.dtlms-multichoice-answer-clone").find('#dtlms-multichoice-correct-answer').val(wrong_ans_cnt);

			jQuery("div.dtlms-multichoice-answer-clone").find('#dtlms-answer-holder').clone().appendTo( "#dtlms-multichoice-answers-container" );

			e.preventDefault();

		});

		jQuery('body').delegate('span.dtlms-remove-multichoice-answer', 'click', function(e){

			jQuery(this).parents('#dtlms-answer-holder').remove();

			var wrong_ans_cnt = jQuery("div.dtlms-multichoice-answer-clone").find('#dt_multichoice_answers_cnt').val();
			wrong_ans_cnt = parseInt(wrong_ans_cnt)-1;
			jQuery("div.dtlms-multichoice-answer-clone").find('#dt_multichoice_answers_cnt').val(wrong_ans_cnt);

			var i = 0;
			jQuery('#dtlms-multichoice-answers-container #dtlms-multichoice-correct-answer').each(function() {
				jQuery(this).val(i);
				i++;
			});

			e.preventDefault();

		});

		jQuery('#dtlms-multichoice-answers-container').sortable({
			placeholder: 'sortable-placeholder',
			stop: function(event, ui) {
				var i = 0;
				jQuery(this).find('.dtlms-multichoice-correct-answer').each(function() {
					jQuery(this).val(i);
					i++;
				});
			}
		});


		// Multichoice image answers script
		jQuery('a.dtlms-add-multichoice-image-answer').on('click', function(e){

			var wrong_ans_cnt = jQuery("div.dtlms-multichoice-image-answer-clone").find('#dt_multichoice_image_answers_cnt').val();
			wrong_ans_cnt = parseInt(wrong_ans_cnt)+1;
			jQuery("div.dtlms-multichoice-image-answer-clone").find('#dt_multichoice_image_answers_cnt').val(wrong_ans_cnt);
			jQuery("div.dtlms-multichoice-image-answer-clone").find('#dtlms-multichoice_image-correct-answer').val(wrong_ans_cnt);
			jQuery("div.dtlms-multichoice-image-answer-clone").find('#dtlms-answer-holder').clone().appendTo( "#dtlms-multichoice-image-answers-container" );

			e.preventDefault();

		});

		jQuery('body').delegate('span.dtlms-remove-multichoice-image-answer','click', function(e){

			jQuery(this).parents('#dtlms-answer-holder').remove();
			var wrong_ans_cnt = jQuery("div.dtlms-multichoice-image-answer-clone").find('#dt_multichoice_image_answers_cnt').val();
			wrong_ans_cnt = parseInt(wrong_ans_cnt)-1;
			jQuery("div.dtlms-multichoice-image-answer-clone").find('#dt_multichoice_image_answers_cnt').val(wrong_ans_cnt);
			var i = 0;
			jQuery('#dtlms-multichoice-image-answers-container #dtlms-multichoice-image-correct-answer').each(function() {
				jQuery(this).val(i);
				i++;
			});

			e.preventDefault();

		});

		jQuery("#dtlms-multichoice-image-answers-container").sortable({
			placeholder: 'sortable-placeholder',
			stop: function(event, ui) {
				var i = 0;
				jQuery(this).find('.dtlms-multichoice-image-correct-answer').each(function() {
					jQuery(this).val(i);
					i++;
				});
			}
		});


		// Multiple correct answers
		jQuery('a.dtlms-add-multicorrect-answer').on('click', function(e){

			var wrong_ans_cnt = jQuery("div.dtlms-multicorrect-answer-clone").find('#dt_multicorrect_answers_cnt').val();
			wrong_ans_cnt = parseInt(wrong_ans_cnt)+1;
			jQuery("div.dtlms-multicorrect-answer-clone").find('#dt_multicorrect_answers_cnt').val(wrong_ans_cnt);
			jQuery("div.dtlms-multicorrect-answer-clone").find('#dtlms-multicorrect-correct-answer').val(wrong_ans_cnt);
			jQuery("div.dtlms-multicorrect-answer-clone").find('#dtlms-answer-holder').clone().appendTo( "#dtlms-multicorrect-answers-container" );

			e.preventDefault();

		});

		jQuery('body').delegate('span.dtlms-remove-multicorrect-answer','click', function(e){

			jQuery(this).parents('#dtlms-answer-holder').remove();
			var wrong_ans_cnt = jQuery("div.dtlms-multicorrect-answer-clone").find('#dt_multicorrect_answers_cnt').val();
			wrong_ans_cnt = parseInt(wrong_ans_cnt)-1;
			jQuery("div.dtlms-multicorrect-answer-clone").find('#dt_multicorrect_answers_cnt').val(wrong_ans_cnt);
			var i = 0;
			jQuery('#dtlms-multicorrect-answers-container #dtlms-multicorrect-correct-answer').each(function() {
				jQuery(this).val(i);
				i++;
			});

			e.preventDefault();

		});

		jQuery('#dtlms-multicorrect-answers-container').sortable({
			placeholder: 'sortable-placeholder',
			stop: function(event, ui) {
				var i = 0;
				jQuery('.dtlms-multicorrect-correct-answer').each(function() {
					jQuery(this).val(i);
					i++;
				});
			}
		});


		// Question type change
		jQuery('body').delegate('select#dtlms-question-type','change', function(e){
			jQuery('.dtlms-answers').hide();
			jQuery('.dtlms-' + jQuery(this).val() + '-answers').show();
			e.preventDefault();
		});

	},

	dtGradings : function() {

		jQuery('div.dtlms-quiz-answer-switch:not(.disabled)').each(function() {

		  jQuery(this).on('click', function(){

			  var $marksobtained = jQuery('input#dtlms-marks-obtained').val();
			  if($marksobtained == '') {
			  	jQuery('a#dtlms-reset-grade').addClass('dtlms-reset-grade-auto');
			  	jQuery('a#dtlms-reset-grade').trigger('click');
			  	jQuery('a#dtlms-reset-grade').removeClass('dtlms-reset-grade-auto');
			 	var $marksobtained = jQuery('input#dtlms-marks-obtained').val();
			  }

			  var $ele = '#'+jQuery(this).attr("data-for");
			  var $grade = jQuery(this).parents('.dtlms-answers').attr('data-grade');
			  var $negative_grade = jQuery(this).parents('.dtlms-answers').attr('data-negative-grade');

			  var $totalmarks = jQuery('input#dtlms-maximum-marks').val();
			  var $marksobtained_percent = 0;

			  var $correct_questions = jQuery('input#correct-questions').val();
			  var $wrong_questions = jQuery('input#wrong-questions').val();

				if($negative_grade > 0) {
					$negative_grade_data = '-'+$negative_grade;
				} else {
					$negative_grade_data = 0;
				}

			  jQuery(this).toggleClass('dtlms-quiz-answer-switch-off dtlms-quiz-answer-switch-on');
			  if(jQuery(this).hasClass('dtlms-quiz-answer-switch-on')) {

				  jQuery(this).parents('.dtlms-answers').find('.dtlms-grade-display-field').html($grade + ' / ' + $grade);
				  if($negative_grade > 0) {
				  	$marksobtained = parseInt($marksobtained)+parseInt($grade)+parseInt($negative_grade);
				  } else {
				  	$marksobtained = parseInt($marksobtained)+parseInt($grade);
				  }

				  $marksobtained_percent = +(($marksobtained/$totalmarks)*100).toFixed(2);

				  jQuery('input#dtlms-marks-obtained').val($marksobtained);
				  jQuery('input#dtlms-marks-obtained-percentage').val($marksobtained_percent);

				  jQuery('input#correct-questions').val(parseInt($correct_questions, 10)+1);
				  jQuery('input#wrong-questions').val(parseInt($wrong_questions, 10)-1);

				  jQuery(this).html('Right');
				  jQuery($ele).prop('checked', true);

			  } else {

				  jQuery(this).parents('.dtlms-answers').find('.dtlms-grade-display-field').html($negative_grade_data+' / ' + $grade);
				  if($negative_grade > 0) {
				  	$marksobtained = parseInt($marksobtained)-parseInt($grade)-parseInt($negative_grade);
				  } else {
				  	$marksobtained = parseInt($marksobtained)-parseInt($grade);
				  }
				  $marksobtained_percent = +(($marksobtained/$totalmarks)*100).toFixed(2);

				  jQuery('input#dtlms-marks-obtained').val($marksobtained);
				  jQuery('input#dtlms-marks-obtained-percentage').val($marksobtained_percent);

				  jQuery('input#correct-questions').val(parseInt($correct_questions, 10)-1);
				  jQuery('input#wrong-questions').val(parseInt($wrong_questions, 10)+1);

				  jQuery(this).html('Wrong');
				  jQuery($ele).removeAttr('checked');

			  }

			  jQuery('#dtlms-marks-obtained').trigger('change');

		  });

		});

		jQuery('a#dtlms-reset-grade').on('click', function(e) {

			if(jQuery(this).hasClass('dtlms-reset-grade-auto') || confirm(lmsquizbackendobject.resetGrade) ) {

				var negative_grade_total = total_grade = 0;
				jQuery('.dtlms-custom-table .dtlms-answers').each(function() {

					var grade = parseInt(jQuery(this).attr('data-grade'));

					if(jQuery(this).hasClass('skipped')) {

						jQuery(this).find('.dtlms-grade-display-field').html('skipped');

					} else {

						var negative_grade = parseInt(jQuery(this).attr('data-negative-grade'));

						if(negative_grade > 0) {
							jQuery(this).find('.dtlms-grade-display-field').html('-'+negative_grade + ' / ' + grade);
						} else {
							jQuery(this).find('.dtlms-grade-display-field').html('0 / ' + grade);
						}

						jQuery(this).find('.dtlms-grade-option-field .dtlms-quiz-answer-switch').removeAttr('class').addClass('dtlms-quiz-answer-switch dtlms-quiz-answer-switch-off').html('Wrong');
						jQuery(this).find('.dtlms-grade-option-field input').removeAttr('checked').val(false);

						negative_grade_total = negative_grade_total + negative_grade;

					}

					total_grade = total_grade + grade;

				});

				if(negative_grade_total > 0) {
					jQuery('#dtlms-marks-obtained').val('-'+negative_grade_total);
					var grade_percent = ((negative_grade_total/total_grade)*100).toFixed(2);
					jQuery('#dtlms-marks-obtained-percentage').val('-'+grade_percent);
				} else {
					jQuery('#dtlms-marks-obtained').val(0);
					jQuery('#dtlms-marks-obtained-percentage').val(0);
				}

			  	var $total_questions = jQuery('input#total-questions').val();
			  	var $skipped_questions = jQuery('input#skipped-questions').val();

			  	$wrong_questions = parseInt($total_questions)-parseInt($skipped_questions);

				jQuery('input#correct-questions').val(0);
				jQuery('input#wrong-questions').val($wrong_questions);

			}

			e.preventDefault();

		});

		jQuery('a#dtlms-auto-grade').on('click', function(e ){

			var total_grade = 0, marks_obtained = 0;
			var $correct_questions = 0, $wrong_questions = 0;

			jQuery('.dtlms-custom-table .dtlms-answers').each(function() {

				if(jQuery(this).find('.dtlms-correct-answer').attr('data-multichoiceimage') == 'true') {
					var correct_answer = jQuery(this).find('.dtlms-correct-answer').find('img').attr('src');
				} else {
					var correct_answer = jQuery(this).find('.dtlms-correct-answer').attr('data-correctanswer');
				}

				if(jQuery(this).find('.dtlms-user-answer').attr('data-multichoiceimage') == 'true') {
					var user_answer = jQuery(this).find('.dtlms-user-answer').find('img').attr('src');
				} else {
					var user_answer = jQuery(this).find('.dtlms-user-answer').attr('data-useranswer');
				}

				if(correct_answer == undefined) {
					correct_answer = '';
				}

				if(user_answer == undefined) {
					user_answer = '';
				}

				var grade = parseInt(jQuery(this).attr('data-grade'));
				var negative_grade = parseInt(jQuery(this).attr('data-negative-grade'));

				if(negative_grade > 0) {
					negative_grade_data = '-'+negative_grade;
				} else {
					negative_grade_data = 0;
				}

				total_grade = parseInt(total_grade)+grade;

				if(user_answer != '') {

					if(correct_answer.toLowerCase().replace(new RegExp(/\r?\n|\r|<br>| /g),"") == user_answer.toLowerCase().replace(new RegExp(/\r?\n|\r|<br>| /g),"")) {
						marks_obtained = parseInt(marks_obtained)+grade;
						jQuery(this).find('.dtlms-grade-display-field').html(grade + ' / ' + grade);
						jQuery(this).find('.dtlms-grade-option-field .dtlms-quiz-answer-switch').removeAttr('class').addClass('dtlms-quiz-answer-switch dtlms-quiz-answer-switch-on').html('Right');
						jQuery(this).find('.dtlms-grade-option-field input').prop('checked', true).val(true);

						$correct_questions = parseInt($correct_questions)+1;
					} else {
						marks_obtained = parseInt(marks_obtained)-negative_grade;
						jQuery(this).find('.dtlms-grade-display-field').html(negative_grade_data + ' / ' + grade);
						jQuery(this).find('.dtlms-grade-option-field .dtlms-quiz-answer-switch').removeAttr('class').addClass('dtlms-quiz-answer-switch dtlms-quiz-answer-switch-off').html('Wrong');
						jQuery(this).find('.dtlms-grade-option-field input').removeAttr('checked').val(false);

						$wrong_questions = parseInt($wrong_questions)+1;
					}

				}

			});

			var marks_obtained_percent = +((marks_obtained/total_grade)*100).toFixed(2);

			jQuery('input#dtlms-marks-obtained').val(marks_obtained);
			jQuery('input#dtlms-marks-obtained-percentage').val(marks_obtained_percent);

			jQuery('input#correct-questions').val($correct_questions);
			jQuery('input#wrong-questions').val($wrong_questions);

			e.preventDefault();

		});

	},

	dtImport : function(){

		var file_frame = attachments_url = '';

		jQuery('.dtlms-chooseupload-file-button').on('click', function(e){

		    if ( file_frame ) {
		      file_frame.open();
		      return;
		    }

		    file_frame = wp.media.frames.file_frame = wp.media({
		    	multiple: false,
		    	title : lmsquizbackendobject.importUploadTitle,
		    	button :{
		    		text : lmsquizbackendobject.importInsertFile
		    	}
		    });

		    file_frame.on( 'select', function() {

		        var attachments = file_frame.state().get('selection').toJSON();
		        var attachments_url	= attachments[0].url;

		        jQuery('.dtlms-import-file').val(attachments_url);

		    });

		    file_frame.open();


		});

		jQuery( 'body' ).delegate( '.dtlms-import-file-button', 'click', function(e){

		    // Ajax call to read csv file
		    var this_item = jQuery(this);
		    var attachments_url = jQuery('.dtlms-import-file').val();
		    var import_type = jQuery('.dtlms-import-type').val();

		    if(attachments_url != '') {

				jQuery.ajax({
					type: "POST",
					url: lmsbackendobject.ajaxurl,
					data:
					{
						action: 'dtlms_process_imported_file',
						import_file: attachments_url,
						import_type: import_type,
					},
					beforeSend: function(){
						this_item.prepend( '<span><i class="fas fa-spinner fa-spin"></i></span>' );
					},
					success: function (response) {
						jQuery('.dtlms-settings-import-output-container').html(response);
					},
					complete: function(){
						this_item.find('span').remove();
					}
				});

		    } else {

		    	jQuery('.dtlms-settings-import-output-container').html(lmsquizbackendobject.invalidFile);

		    }

		    e.preventDefault();

		});

	}

};

jQuery(document).ready(function() {

	"use strict";

	dtLMSQuizBackend.dtInit();

});