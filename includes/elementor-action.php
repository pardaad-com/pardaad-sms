<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// SunWay class to handle action after submit form
class SunWay_Action_After_Submit extends \ElementorPro\Modules\Forms\Classes\Action_Base {

	// name of the form action
	public function get_name() {
		return 'sunway';
	}

	// label of the form action, displays on form actions selector
	public function get_label() {
		return __( 'Send SMS By Sunway', 'sunway' );
	}

	// register box of the sunway settings and all of its fields when sunway action selected on the form
	public function register_settings_section( $widget ) {

		$widget->start_controls_section(
			'section_sunway',
			[
				'label' => __( 'Send SMS By Sunway', 'sunway' ),
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);

		$widget->add_control(
			'sunway_message',
			[
				'label' => __( 'Message Text', 'sunway' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
			]
		);

		$widget->add_control(
			'sunway_reciever',
			[
				'label' => __( 'Reciever Number', 'sunway' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __('Write mobile number field id, in example: mobile'),
			]
		);

		$widget->add_control(
			'sunway_username',
			[
				'label' => __( 'Username', 'sunway' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$widget->add_control(
			'sunway_password',
			[
				'label' => __( 'Password', 'sunway' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$widget->add_control(
			'sunway_from',
			[
				'label' => __( 'Sender Number', 'sunway' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
		$widget->end_controls_section();

	}

	
	// function to send SMS after form submited
	public function run( $record, $ajax_handler ) {
		$message = $record->get_form_settings('sunway_message');
		$reciever = $record->get_form_settings('sunway_reciever');
		$username = $record->get_form_settings('sunway_username');
		$password = $record->get_form_settings('sunway_password');
		$from = $record->get_form_settings('sunway_from');
		$form_data = $record->get_formatted_data();
		$raw_fields = $record->get( 'fields' );
		$fields = [];
		foreach ( $raw_fields as $id => $field ) {
			$fields[ $id ] = $field['value'];
		}
		$to = $fields[$reciever];
        $url = 'https://sms.sunwaysms.com/smsws/HttpService.ashx?service=SendArray&username='.$username.'&password='.$password.'&message='.$message.'&from='.$from.'&to='.$to;
        $send_sms = wp_remote_post( $url );
	}


	public function on_export( $element ) {

		unset(
			$element['sunway_message']
			$element['sunway_reciever']
			$element['sunway_username']
			$element['sunway_password']
		);
		return $element;

	}

} // end SunWay_Action_After_Submit class