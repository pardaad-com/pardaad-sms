<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * Elementor Form Field - Mobile Number
 * Add a new "Mobile Number" field to Elementor form widget.
 */
class Elementor_Mobile_Number_Field extends \ElementorPro\Modules\Forms\Fields\Field_Base {

	public function get_type() {
		return 'mobile-number';
	}
    
	public function get_name() {
		return __( 'SunWay - Iran Mobile Number', 'sunway' );
	}

	public function render( $item, $item_index, $form ) {
		$form->add_render_attribute(
			'input' . $item_index,
			[
				'size' => '1',
				'class' => 'elementor-field-textual',
				'placeholder' => $item['mobile-number-placeholder'],
			]
		);

		echo '<input ' . $form->get_render_attribute_string( 'input' . $item_index ) . '>';
	}

	public function update_controls( $widget ) {
		$elementor = \ElementorPro\Plugin::elementor();

		$control_data = $elementor->controls_manager->get_control_from_stack( $widget->get_unique_name(), 'form_fields' );

		if ( is_wp_error( $control_data ) ) {
			return;
		}

		$field_controls = [
			'mobile-number-placeholder' => [
				'name' => 'mobile-number-placeholder',
				'label' => __('Placeholder'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Mobile Number'),
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'tab'          => 'content',
				'inner_tab'    => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
		];

		$control_data['fields'] = $this->inject_field_controls( $control_data['fields'], $field_controls );

		$widget->update_control( 'form_fields', $control_data );
	}

	public function validation( $field, $record, $ajax_handler ) {
		if ( empty( $field['value'] ) ) {
            $ajax_handler->add_error(
				$field['id'],
				__( 'Please enter your mobile number', 'sunway' )
			);
		} else {
            if ( preg_match( '/^(?:98|\+98|0098|0)?9[0-9]{9}$/', $field['value'] ) !== 1 ) {
                $ajax_handler->add_error(
                    $field['id'],
                    __( 'The mobile number is invalid', 'sunway' )
                );
            }
        }
	}

	public function __construct() {
		parent::__construct();
		add_action( 'elementor/preview/init', [ $this, 'editor_preview_footer' ] );
	}

	public function editor_preview_footer() {
		add_action( 'wp_footer', [ $this, 'content_template_script' ] );
	}

	public function content_template_script() {
		?>
		<script>
		jQuery( document ).ready( () => {

			elementor.hooks.addFilter(
				'elementor_pro/forms/content_template/field/<?php echo $this->get_type(); ?>',
				function ( inputField, item, i ) {
					const fieldId    = 'form_field_${i}';
					const fieldClass = 'elementor-field-textual elementor-field ${item.css_classes}';
					const size       = '1';

					return '<input id="${fieldId}" class="${fieldClass}" size="${size}" pattern="${pattern}" title="${title}">';
				}, 10, 3
			);

		});
		</script>
		<?php
	}

}