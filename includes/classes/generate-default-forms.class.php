<?php
/**
 * Default Contact Form 7
 */
if ( !class_exists( 'aios_filterable_gallery_default_forms' ) ) {

	class aios_filterable_gallery_default_forms {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function __construct() {
			$this->add_actions();
		}

		/**
		 * Add Actions.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function add_actions() {
			$is_listing_forms_generate = get_option( 'is_listing_forms_generate' );
			if ( empty( $is_listing_forms_generate ) ) add_action( 'admin_init', array( $this, 'generate_form_install' ) );
		}

		/**
		 * Register Form once Plugin is install.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function generate_form_install() {
			$this->create_forms( array( 0, 1, 2 ) );
			update_option( 'is_listing_forms_generate', 'generated' );
		}

		/**
		 * List of forms to generate
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		public function forms( $cf7number ) {
			$site_name = get_bloginfo('name');
			$site_url = get_bloginfo('url');

			$toReturn				= array();
			$toReturn['messages'] 	= array(
				'mail_sent_ok' => 'Your message was sent successfully. Thanks.',
				'mail_sent_ng' => 'Failed to send your message. Please try later or contact the administrator by another method.',
				'validation_error' => 'Validation errors occurred. Please confirm the fields and submit it again.',
				'spam' => 'Failed to send your message. Please try later or contact the administrator by another method.',
				'accept_terms' => 'Please accept the terms to proceed.',
				'invalid_required' => 'Please fill the required field.',
				'captcha_not_match' => 'Your entered code is incorrect.',
				'invalid_number' => 'Number format seems invalid.',
				'number_too_small' => 'This number is too small.',
				'number_too_large' => 'This number is too large.',
				'invalid_email' => 'Email address seems invalid.',
				'invalid_url' => 'URL seems invalid.',
				'invalid_tel' => 'Telephone number seems invalid.',
				'quiz_answer_not_correct' => 'Your answer is not correct.',
				'invalid_date' => 'Date format seems invalid.',
				'date_too_early' => 'This date is too early.',
				'date_too_late' => 'This date is too late.',
				'upload_failed' => 'Failed to upload file.',
				'upload_file_type_invalid' => 'This file type is not allowed.',
				'upload_file_too_large' => 'This file is too large.',
				'upload_failed_php_error' => 'Failed to upload file. Error occurred.'
			);

			if ( $cf7number == 0 ) {

				$toReturn['mail'] = array(
					'subject' => '"Request Information" form inquiry from your Agent Image website',
					'sender' => '[first-name] [last-name] <[email]>',
					'body' => 'From: [first-name] [last-name] <[email]>
Subject: "Request Information" form inquiry from your Agent Image website

Message Body:
Someone has filled out the "Request Information" inquiry form on your website.

<table width="600" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="200"><strong>Listings:</strong></td>
		<td>[listing_subject]</td>
	</tr>
	<tr>
		<td width="200"><strong>Name:</strong></td>
		<td>[first-name] [last-name]</td>
	</tr>
	<tr>
		<td><strong>Email:</strong></td>
		<td>[email]</td>
	</tr>
	<tr>
		<td><strong>Phone:</strong></td>
		<td>[phone]</td>
	</tr>
	<tr>
		<td><strong>When are you moving?:</</strong></td>
		<td>[approx_date_move]</td>
	</tr>
	<tr>
		<td><strong>Best way to reach you?:</strong></td>
		<td>[preffered_contact]</td>
	</tr>
	<tr>
		<td><strong>Comments:</strong></td>
		<td>[message]</td>
	</tr>
</table>
--
This mail is sent via contact form on (' . $site_name . ' - ' . $site_url . ')',
					'recipient' => get_bloginfo('admin_email'),
					'additional_headers' => 'Reply-To: [email]',
					'attachments' => '',
					'use_html' => false,
					'exclude_blank' => false
				);

				$toReturn['form'] = '<p class="modal-filterable_gallery-paragraph">Tell us how to reach you and we\'ll get back in touch.</p>
<div class="container-fluid modal-filterable_gallery-form text-left">
	<div class="row">
		<div class="col-md-6">
			<label for="first-name">First Name*</label>
			[text* first-name id:first-name]
		</div>
		<div class="col-md-6">
			<label for="last-name">Last Name*</label>
			[text* last-name id:last-name]
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label for="email">Email Address*</label>
			[email* email id:email]
		</div>
		<div class="col-md-6">
			<label for="phone">Phone Number</label>
			[tel phone id:phone]
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label for="approx_date_move">When are you moving?</label>
			[text approx_date_move id:approx_date_move class:text_datepicker placeholder "MM/DD/YYYY"]
		</div>
		<div class="col-md-6">
			<label for="preffered_contact">Best way to reach you?</label>
			[select preffered_contact id:preffered_contact "Email and Phone" "Email" "Phone"]
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<label for="message">Your Message</label>
			[textarea message]
		</div>
	</div>
	<div class="hide">
		<label for="first-name">Listing Address</label>
		[text listing_subject class:listing_subject]
	</div>
	<div class="row mt-6">
		<div class="col-md-12">
			[submit "Send"]
		</div>
	</div>
</div>';
				$toReturn['shotcodeTitle'] = 'Request Information (Auto-generated by AIOS Listings)';
			} else if ( $cf7number == 1 ) {
				$toReturn['mail'] = array(
					'subject' => '"Schedule a Showing" form inquiry from your Agent Image website',
					'sender' => '[first-name] [last-name] <[email]>',
					'body' => 'From: [first-name] [last-name] <[email]>
Subject: "Schedule a Showing" form inquiry from your Agent Image website

Message Body:
Someone has filled out the "Schedule a Showing" inquiry form on your website.

<table width="600" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="200"><strong>Listings:</strong></td>
		<td>[listing_subject]</td>
	</tr>
	<tr>
		<td width="200"><strong>Name:</strong></td>
		<td>[first-name] [last-name]</td>
	</tr>
	<tr>
		<td><strong>Email:</strong></td>
		<td>[email]</td>
	</tr>
	<tr>
		<td><strong>Phone:</strong></td>
		<td>[phone]</td>
	</tr>
	<tr>
		<td><strong>When are you moving?:</</strong></td>
		<td>[preferred_date]</td>
	</tr>
	<tr>
		<td><strong>Are you available at another time?:</strong></td>
		<td>[alternate_date]</td>
	</tr>
	<tr>
		<td><strong>Comments:</strong></td>
		<td>[message]</td>
	</tr>
</table>
--
This mail is sent via contact form on (' . $site_name . ' - ' . $site_url . ')',
					'recipient' => get_bloginfo('admin_email'),
					'additional_headers' => 'Reply-To: [email]',
					'attachments' => '',
					'use_html' => false,
					'exclude_blank' => false
				);

				$toReturn['form'] = '<p class="modal-filterable_gallery-paragraph">Tell us how to reach you and we\'ll get back in touch.</p>
<div class="container-fluid text-left">
	<div class="row">
		<div class="col-md-6">
			<label for="first-name">First Name*</label>
			[text* first-name id:first-name]
		</div>
		<div class="col-md-6">
			<label for="last-name">Last Name*</label>
			[text* last-name id:last-name]
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label for="email">Email Address*</label>
			[email* email id:email]
		</div>
		<div class="col-md-6">
			<label for="phone">Phone Number</label>
			[tel phone id:phone]
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label for="preferred_date">When are you available?</label>
			[text preferred_date id:preferred_date class:text_datepicker placeholder "MM/DD/YYYY"]
		</div>
		<div class="col-md-6">
			<label for="alternate_date">Are you available at another time?</label>
			[text alternate_date id:alternate_date class:text_datepicker placeholder "MM/DD/YYYY"]
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<label for="message">Your Message</label>
			[textarea message id:message]
		</div>
	</div>
	<div class="hide">
		<label for="first-name">Listing Address</label>
		[text listing_subject class:listing_subject]
	</div>
	<div class="row mt-6">
		<div class="col-md-12">
			[submit "Send"]
		</div>
	</div>
</div>';
				$toReturn['shotcodeTitle'] = 'Schedule a Showing (Auto-generated by AIOS Listings)';
				return $toReturn;

			} else if ( $cf7number == 2 ) {

				$toReturn['mail'] = array(
					'subject' => '"Interested in [your-listing-interest-subject]" form inquiry from your Agent Image website',
					'sender' => '[your-first-name] [your-last-name] <[your-email]>',
					'body' => 'From: [your-first-name] [your-last-name] <[your-email]>
Subject: "Interested in [your-listing-interest-subject]" form inquiry from your Agent Image website

Message Body:
Someone has filled out the "Interested in [your-listing-interest-subject]" inquiry form on your website.

<table width="600" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="200"><strong>Interested in:</strong></td>
		<td>[your-listing-interest-subject]</td>
	</tr>
	<tr>
		<td width="200"><strong>Name:</strong></td>
		<td>[your-first-name] [your-last-name]</td>
	</tr>
	<tr>
		<td><strong>Email Address:</strong></td>
		<td>[your-email]</td>
	</tr>
	<tr>
		<td><strong>Phone Number:</strong></td>
		<td>[your-phone]</td>
	</tr>
	<tr>
		<td><strong>Additional Comments:</strong></td>
		<td>[your-message]</td>
	</tr>
</table>
--
This mail is sent via contact form on (' . $site_name . ' - ' . $site_url . ')',
					'recipient' => get_bloginfo('admin_email'),
					'additional_headers' => 'Reply-To: [your-email]',
					'attachments' => '',
					'use_html' => false,
					'exclude_blank' => false
				);

				$toReturn['form'] = '<div class="form-column your-first-name">
	<label for="your-first-name">First Name</label>
	[text* your-first-name]
</div>
<div class="form-column your-last-name">
	<label for="your-last-name">Last Name</label>
	[text* your-last-name]
</div>
<div class="form-column your-phone">
	<label for="your-phone">Phone No.</label>
	[tel your-phone]
</div>
<div class="form-column your-email">
	<label for="your-email">Email Address</label>
	[email* your-email]
</div>
<div class="form-column your-message">
	<label for="your-message">Message</label>
	[textarea your-message]
</div>
<div class="hide your-listing-interest-subject">
	<label for="your-listing-interest-subject">Subject</label>
	[text* your-listing-interest-subject]
</div>
<div class="form-column your-listing-interest-submit">
	[submit "Contact Us"]
</div>';
				$toReturn['shotcodeTitle'] = 'Interested in Listings (Auto-generated by AIOS Listings)';
			}

			return $toReturn;

		}

		/**
		 * This will generate the forms
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return string
		 */
		public function generate() {
			$this->create_forms( array( 0, 1, 2 ) );
		}

		public function create_forms( $forms = array() ) {
			foreach ( $forms as $form ) {
				$cf7Info = $this->forms( $form );
				$exist_form_id = $this->check_if_form_exist( $form );

				if ( is_numeric( $exist_form_id ) ) {
					$mail_meta          = get_post_meta( $exist_form_id, '_mail', true );
 
					$sender             = $mail_meta['sender'];
					$recipient          = $mail_meta['recipient'];
					$additional_headers = $mail_meta['additional_headers'];
 
					$cf7Info['mail']['sender']                  = $mail_meta['sender'];
					$cf7Info['mail']['recipient']               = $mail_meta['recipient'];
					$cf7Info['mail']['additional_headers']      = $mail_meta['additional_headers'];
 
					update_post_meta($exist_form_id, '_messages', $cf7Info['messages']);
					update_post_meta($exist_form_id, '_mail', $cf7Info['mail']);
					update_post_meta($exist_form_id, '_form', $cf7Info['form']);
				} else {
					$toInsert = array(
						'post_title'    => $cf7Info['shotcodeTitle'],
						'post_content'  => 'Auto Generated by WAD',
						'post_type'     => 'wpcf7_contact_form',
						'post_status'   => 'publish',
						'post_author'   => 1
					);
					 
					$cf7id = wp_insert_post($toInsert);
					 
					$filterable_gallery_settings = get_option( 'filterable_gallery_settings' );
					
					if ( $form == 0 ) {
						$filterable_gallery_settings['forms_request_information'] = $cf7id;
						update_option( 'filterable_gallery_settings', $filterable_gallery_settings );
					}

					if ( $form == 1 ) {
						$filterable_gallery_settings['forms_schedule_showing'] = $cf7id;
						update_option( 'filterable_gallery_settings', $filterable_gallery_settings );
					}

					if ( $form == 2 ) {
						$filterable_gallery_settings['interested_listing'] = $cf7id;
						update_option( 'filterable_gallery_settings', $filterable_gallery_settings );
					}

					if ($cf7id) {
						update_post_meta($cf7id, '_messages', $cf7Info['messages']);
						update_post_meta($cf7id, '_mail', $cf7Info['mail']);
						update_post_meta($cf7id, '_form', $cf7Info['form']);
					}
				}
			}
		}

		/**
		 * Check if form is exists
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return boolan | string
		 */
		public function check_if_form_exist( $id ) {
			wp_reset_query();
			wp_reset_postdata();

			$cf7_args = array(
				'post_type'		=> 'wpcf7_contact_form',
				'posts_per_page'=> -1
			);

			$cf7_form = '';

			switch ( $id ) {
				case 0: $cf7_form = 'Request Information (Auto-generated by AIOS Listings)'; break;
				case 1: $cf7_form = 'Schedule a Showing (Auto-generated by AIOS Listings)'; break;
				case 2: $cf7_form = 'Interested in Listings (Auto-generated by AIOS Listings)'; break;
			}

			$cf7_arr = get_posts ( $cf7_args );
			wp_reset_query();

			$cf7_holder = array();

			if ( !empty ( $cf7_arr ) ){
				foreach ($cf7_arr as $cf7_item ) {
					$cf7_holder[$cf7_item->post_title] = $cf7_item->post_title;
				}
			}

			if ( in_array( $cf7_form, $cf7_holder ) ){
				$form_data = get_page_by_title( $cf7_form, '', 'wpcf7_contact_form' );
				return $form_data->ID;
			} else {
				return false;
			}
		}

	}

	$aios_filterable_gallery_default_forms = new aios_filterable_gallery_default_forms();
	
}