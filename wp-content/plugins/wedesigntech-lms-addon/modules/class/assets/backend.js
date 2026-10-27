var dtLMSClassBackend = {

	dtInit : function() {
		dtLMSClassBackend.dtClasses();
		dtLMSClassBackend.dtClassRegistration();
		dtLMSClassBackend.dtSettings();
	},

	dtClasses : function() {

		// Switch options between onsite and online
		jQuery('body').delegate('.dtlms-class-type', 'change', function(e){

			jQuery('.dtlms-online-items').slideUp();
			jQuery('.dtlms-onsite-items').slideUp();
			jQuery('.dtlms-onsiteonline-items').slideUp();
			jQuery('.dtlms-tabs-vertical-container li.dtlms-tab-certificate, .dtlms-tabs-vertical-container li.dtlms-tab-badge').slideUp();
			if(jQuery(this).val() == 'onsite') {
				jQuery('.dtlms-online-items').slideUp();
				jQuery('.dtlms-onsite-items').slideDown();
				jQuery('.dtlms-onsiteonline-items').slideDown();
				jQuery('.dtlms-tabs-vertical-container li.dtlms-tab-certificate, .dtlms-tabs-vertical-container li.dtlms-tab-badge').slideDown();
			} else if(jQuery(this).val() == 'online') {
				jQuery('.dtlms-online-items').slideDown();
				jQuery('.dtlms-onsite-items').slideUp();
				jQuery('.dtlms-onsiteonline-items').slideDown();
				jQuery('.dtlms-tabs-vertical-container li.dtlms-tab-certificate, .dtlms-tabs-vertical-container li.dtlms-tab-badge').slideDown();
			}
			e.preventDefault();

		});

		// Switch options between course content and shortcodes content
		jQuery('body').delegate('select#dtlms-class-content-options','change', function(e){

			jQuery('.dtlms-course-content').slideUp();
			jQuery('.dtlms-shortcode-content').slideUp();

			if(jQuery(this).val() == 'course') {
				jQuery('.dtlms-course-content').slideDown();
				jQuery('.dtlms-shortcode-content').slideUp();
				jQuery(".chosen-container").attr('style', 'width:80%');
			}
			if(jQuery(this).val() == 'shortcode') {
				jQuery('.dtlms-course-content').slideUp();
				jQuery('.dtlms-shortcode-content').slideDown();
				jQuery(".chosen-container").attr('style', 'width:80%');
			}

			e.preventDefault();

		});


		// Generate latitude and longitude values from date
		jQuery('.dtlms-generate-gps').on('click', function(e){

			var $address = jQuery('.dtlms-class-address').val();

			if( jQuery.trim($address).length <= 0 ){
				alert(lmsclassbackendobject.locationAlert1);
			} else {
				var geocoder = new google.maps.Geocoder();
				geocoder.geocode({ 'address': jQuery.trim($address) }, function (results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						jQuery('.dtlms-class-latitude').attr('value', results[0].geometry.location.lat());
						jQuery('.dtlms-class-longitude').attr('value', results[0].geometry.location.lng());
					} else {
						alert(lmsclassbackendobject.locationAlert2);
					}
				});
			}

			e.preventDefault();

		});

		// Add course to class
		jQuery('a.dtlms-add-course').on('click', function(e){

			var clone = jQuery("#dtlms-course-to-clone").clone();

			clone.attr('class', 'dtlms-course-box').removeClass('hidden').removeAttr('id');
			clone.find('select').attr('class', 'dtlms-class-courses dtlms-chosen-select').attr('name', 'dtlms-class-courses[]');
			clone.appendTo('#dtlms-class-courses-container');

			jQuery('.dtlms-chosen-select').chosen({
				no_results_text: lmsbackendobject.noResult,
			});

			e.preventDefault();

		});

		jQuery('body').delegate('span.dtlms-remove-course','click', function(e){

			jQuery(this).parents('.dtlms-course-box').remove();

			e.preventDefault();

		});

		jQuery('#dtlms-class-courses-container').sortable({ placeholder: 'sortable-placeholder' });


		// Adding accessories
		jQuery('a.dtlms-add-accessory').on('click', function(e){

			var clone = jQuery('#dtlms-accessory-to-clone').clone();
			clone.attr('class', 'dtlms-accessory-box').removeClass('hidden').removeAttr('id');
			clone.appendTo('#dtlms-class-accessories-container');

			e.preventDefault();

		});

		jQuery('body').delegate('span.dtlms-remove-accessory','click', function(e){

			jQuery(this).parents('.dtlms-accessory-box').remove();
			e.preventDefault();

		});

		jQuery('#dtlms-class-accessories-container').sortable({ placeholder: 'sortable-placeholder' });


		// Adding tabs
		jQuery('a.dtlms-add-tab').on('click', function(e){

			var clone = jQuery("#dtlms-tab-to-clone").clone();
			clone.attr('class', 'dtlms-tab-box').removeClass('hidden').removeAttr('id');
			clone.find('.dtlms-chosen-select-item').addClass('dtlms-chosen-select').removeClass('dtlms-chosen-select-item');
			clone.appendTo('#dtlms-class-tabs-container');

			jQuery('.dtlms-chosen-select').chosen({
				no_results_text: lmsbackendobject.noResult,
			});

			e.preventDefault();

		});

		jQuery('body').delegate('span.dtlms-remove-tab','click', function(e){

			jQuery(this).parents('.dtlms-tab-box').remove();
			e.preventDefault();

		});

		jQuery('#dtlms-class-tabs-container').sortable({ placeholder: 'sortable-placeholder' });

	},

	dtClassRegistration : function() {

		jQuery( 'body' ).delegate( '.dtlms-classregistrations-classes', 'change', function(e) {

			var this_item = jQuery(this),
				class_id = this_item.val();

			jQuery.ajax({
				type: "POST",
				url: lmsbackendobject.ajaxurl,
				data:
				{
					action: 'dtlms_load_class_registration_details',
					class_id: class_id,
				},
				beforeSend: function() {
					dtLMSCommonUtils.dtLMSAjaxBeforeSend(this_item.parents('.dtlms-classregistrations-container'));
				},
				success: function (response) {
					this_item.parents('.dtlms-classregistrations-container').find('.dtlms-classregistrations-classes-container').html(response);
					// Checkbox switch
					dtLMSCommonUtils.dtLMSCheckboxSwitch();
				},
				complete: function() {
					dtLMSCommonUtils.dtLMSAjaxAfterSend(this_item.parents('.dtlms-classregistrations-container'));
				}
			});

			e.preventDefault();

		});

		jQuery( 'body' ).delegate( '.dtlms-save-class-registration-settings', 'click', function(e) {

			var this_item = jQuery(this),
				class_id = this_item.attr('data-classid');

			var registered_users_certificate = jQuery('.approve-registered-users-certificate:checked').map(function(){
				return this.value;
			}).get();

			var registered_users_badge = jQuery('.approve-registered-users-badge:checked').map(function(){
				return this.value;
			}).get();


			jQuery.ajax({
				type: "POST",
				url: lmsbackendobject.ajaxurl,
				data:
				{
					action: 'dtlms_save_class_registration_settings',
					class_id: class_id,
					registered_users_certificate: registered_users_certificate,
					registered_users_badge: registered_users_badge,
				},
				beforeSend: function(){
					this_item.prepend( '<span><i class="fas fa-spinner fa-spin"></i></span>' );
				},
				success: function (response) {
					jQuery('.dtlms-class-registration-response-holder').html(response);
					window.setTimeout(function(){
						jQuery('.dtlms-class-registration-response-holder').fadeOut('slow');
					}, 2000);
				},
				complete: function(){
					this_item.find('span').remove();
				}
			});

			e.preventDefault();

		});

	},

	dtSettings : function() {

		jQuery( 'body' ).delegate( '.dtlms-assigning-classes-students', 'change', function(e){

			var class_id = jQuery(this).val();

			jQuery.ajax({
				type: "POST",
				url: lmsbackendobject.ajaxurl,
				data:
				{
					action: 'dtlms_assigning_classes_load_students_data',
					class_id: class_id,
				},
				beforeSend: function(){
					dtLMSCommonUtils.dtLMSAjaxBeforeSend(undefined);
				},
				success: function (response) {
					jQuery('.dtlms-assign-studentstoclass-container').html(response);
					dtLMSCommonUtils.dtLMSCheckboxSwitch();
				},
				complete: function(){
					dtLMSCommonUtils.dtLMSAjaxAfterSend(undefined);
				}
			});

			e.preventDefault();

		});

		jQuery( 'body' ).delegate( '.dtlms-save-assign-classes-students-settings', 'click', function(e) {

			var this_item = jQuery(this),
				page_student_ids = this_item.attr('data-pagestudentids'),
				class_id = this_item.attr('data-classid');

			var student_ids = jQuery('.assign-students-to-class:checked').map(function(){
				return this.value;
			}).get();

			jQuery.ajax({
				type: "POST",
				url: lmsbackendobject.ajaxurl,
				data:
				{
					action: 'dtlms_save_assign_classes_students_settings',
					class_id: class_id,
					student_ids: student_ids,
					page_student_ids: page_student_ids,
				},
				beforeSend: function(){
					this_item.prepend( '<span><i class="fas fa-spinner fa-spin"></i></span>' );
				},
				success: function (response) {
					jQuery('.dtlms-assign-classes-students-response-holder').html(response);
					window.setTimeout(function(){
						jQuery('.dtlms-assign-classes-students-response-holder').fadeOut('slow');
					}, 2000);
				},
				complete: function(){
					this_item.find('span').remove();
				}
			});

			e.preventDefault();

		});

		jQuery( 'body' ).delegate( '.dtlms-assigning-classes-classes', 'change', function(e){

			var student_id = jQuery(this).val();

			jQuery.ajax({
				type: "POST",
				url: lmsbackendobject.ajaxurl,
				data:
				{
					action: 'dtlms_assigning_classes_load_classes_data',
					student_id: student_id,
				},
				beforeSend: function(){
					dtLMSCommonUtils.dtLMSAjaxBeforeSend(undefined);
				},
				success: function (response) {
					jQuery('.dtlms-assign-classestostudent-container').html(response);
					dtLMSCommonUtils.dtLMSCheckboxSwitch();
				},
				complete: function(){
					dtLMSCommonUtils.dtLMSAjaxAfterSend(undefined);
				}
			});

			e.preventDefault();

		});

		jQuery( 'body' ).delegate( '.dtlms-save-assign-classes-classes-settings', 'click', function(e) {

			var this_item = jQuery(this),
				page_class_ids = this_item.attr('data-pageclassids'),
				student_id = this_item.attr('data-studentid');

			var class_ids = jQuery('.assign-classes-to-student:checked').map(function(){
				return this.value;
			}).get();

			jQuery.ajax({
				type: "POST",
				url: lmsbackendobject.ajaxurl,
				data:
				{
					action: 'dtlms_save_assign_classes_classes_settings',
					student_id: student_id,
					class_ids: class_ids,
					page_class_ids: page_class_ids
				},
				beforeSend: function(){
					this_item.prepend( '<span><i class="fas fa-spinner fa-spin"></i></span>' );
				},
				success: function (response) {
					jQuery('.dtlms-assign-classes-classes-response-holder').html(response);
					window.setTimeout(function(){
						jQuery('.dtlms-assign-classes-classes-response-holder').fadeOut('slow');
					}, 2000);
				},
				complete: function(){
					this_item.find('span').remove();
				}
			});

			e.preventDefault();

		});
	},

};

jQuery(document).ready(function() {

	"use strict";

	dtLMSClassBackend.dtInit();

});