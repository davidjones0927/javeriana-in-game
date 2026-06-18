<?php

namespace Happy_Addons_Pro\Extensions;

use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Repeater;

defined('ABSPATH') || die();

class Multi_Layer_Parallax {

	/**
	 * @var mixed
	 */
	private static $instance = null;

	/**
	 * @var mixed
	 */
	private $load_script = null;

	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function init() {

		add_action( 'elementor/frontend/before_register_scripts', [ $this, 'register_scripts' ] );
		add_action( 'elementor/preview/enqueue_scripts', [ $this, 'enqueue_preview_scripts' ] );

		add_action('elementor/element/section/section_layout/after_section_end', [ $this, 'register_controls' ], 10);
		add_action('elementor/element/container/section_layout/after_section_end', [ $this, 'register_controls' ], 10);

		add_action( 'elementor/frontend/section/before_render', [ $this, 'before_render' ], 10, 1 );
		add_action( 'elementor/frontend/container/before_render', [ $this, 'before_render' ], 10, 1 );

		add_action( 'elementor/section/print_template', array( $this, 'editor_template_print' ), 10, 2 );
		add_action( 'elementor/container/print_template', array( $this, 'editor_template_print' ), 10, 2 );
	}

	public function register_scripts() {
		$suffix = ha_is_script_debug_enabled() ? '.' : '.min.';

		wp_register_script(
			'happy-multi-layer-parallax',
			HAPPY_ADDONS_PRO_ASSETS . 'js/multi-layer-parallax' . $suffix . 'js',
			[ 'jquery', 'gsap', 'happy-elementor-addons' ],
			HAPPY_ADDONS_PRO_VERSION,
			true
		);

	}

	public function enqueue_preview_scripts() {
		wp_enqueue_script( 'gsap' );
		wp_enqueue_script( 'happy-multi-layer-parallax' );
	}

	public static function get_all_breakpoints() {
		$devices = [
			'desktop' => __( 'Desktop', 'happy-addons-pro' ),
			'tablet'  => __( 'Tablet', 'happy-addons-pro' ),
			'mobile'  => __( 'Mobile', 'happy-addons-pro' ),
		];
		if ( ha_elementor()->breakpoints->has_custom_breakpoints() ) {
			$custom_devices = [
				'widescreen'   => __('Widescreen', 'happy-addons-pro'),
				'laptop'       => __('Laptop', 'happy-addons-pro'),
				'tablet_extra' => __('Tablet Extra', 'happy-addons-pro'),
				'mobile_extra' => __('Mobile Extra', 'happy-addons-pro'),
			];
			$devices = array_merge( $devices, $custom_devices);
		}
		return $devices;
	}

	/**
	 * Register Parallax controls.
	 */
	public function register_controls( $element ) {

		$element->start_controls_section(
			'section_ha_multi_layer_parallax',
			[
				'label' => ( __( 'Multi Layer Parallax', 'happy-addons-pro') ) . ha_get_section_icon(),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);

		$element->add_control(
			'ha_multi_layer_parallax_switcher',
			[
				'label'        => __( 'Enable?', 'happy-addons-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'ha-multi-layer-parallax--',
				'render_type'  => 'template',
				'style_transfer' => false,
				'frontend_available' => true,
				'assets' => [
					'scripts' => [
						[
							'name' => 'gsap',
							'conditions' => [
								'terms' => [
									[
										'name' => 'ha_multi_layer_parallax_switcher',
										'operator' => '===',
										'value' => 'yes',
									],
								],
							],
						],
						[
							'name' => 'happy-multi-layer-parallax',
							'conditions' => [
								'terms' => [
									[
										'name' => 'ha_multi_layer_parallax_switcher',
										'operator' => '===',
										'value' => 'yes',
									],
								],
							],
						]
					],
				],
			]
		);

		$element->add_control(
			'ha_multi_layer_parallax_update',
			[
				'label' => __( 'Apply Button', 'happy-addons-pro' ),
				'show_label' => false,
				'type'  => Controls_Manager::RAW_HTML,
				'raw' => '<div class="elementor-update-preview" style="margin: 0 0 8px 0"><div class="elementor-update-preview-title">' . __( 'Update changes to the page', 'happy-addons-pro' ) . '</div><div class="elementor-update-preview-button-wrapper"><button class="elementor-update-preview-button elementor-button elementor-button-success" style="background-image: linear-gradient(90deg, #e2498a 0%, #562dd4 100%);">' . __( 'Apply', 'happy-addons-pro' ) . '</button></div></div>',
                'condition' => [
                    'ha_multi_layer_parallax_switcher' => 'yes',
                ],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'hide_layer',
			[
				'label'     => __( 'Hide This Layer', 'happy-addons-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'display: none'
				]
			]
		);

		$repeater->add_control(
			'layer_type',
			[
				'label'   => __( 'Type', 'happy-addons-pro' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'img',
			]
		);

		$repeater->add_control(
			'ha_multi_layer_parallax_image',
			[
				'label'       => __( 'Choose Image', 'happy-addons-pro' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => [
					'url' => Utils::get_placeholder_image_src()
				],
				'label_block' => true,
				'render_type' => 'template',
				'condition'   => [
					'layer_type' => 'img'
				]
			]
		);

		$repeater->add_responsive_control(
			'ha_multi_layer_parallax_width',
			[
				'label'       => __( 'Size', 'happy-addons-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 100,
					'unit' => '%'
				],
				'label_block' => true,
				'condition'   => [
					'layer_type' => 'img'
				]
			]
		);

		$repeater->add_control(
			'ha_multi_layer_parallax_z_index',
			[
				'label'       => __( 'Z-index', 'happy-addons-pro' ),
				'description' => __( 'Set z-index for the current layer', 'happy-addons-pro' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1
			]
		);

		$repeater->add_control(
			'ha_multi_layer_parallax_hor',
			[
				'label'   => __( 'Horizontal Alignment', 'happy-addons-pro' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'left'   => __( 'Left', 'happy-addons-pro' ),
					'center' => __( 'Center', 'happy-addons-pro' ),
					'right'  => __( 'Right', 'happy-addons-pro' ),
					'custom' => __( 'Custom', 'happy-addons-pro' )
				],
				'default' => 'custom'
			]
		);

		$repeater->add_responsive_control(
			'ha_multi_layer_parallax_hor_pos',
			[
				'label'       => __( 'Horizontal Position', 'happy-addons-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => __( 'Set the horizontal position for the layer background, default: 50%', 'happy-addons-pro' ),
				'default'     => [
					'size' => 0,
					'unit' => '%'
				],
				'min'         => 0,
				'max'         => 100,
				'label_block' => true,
				'condition'   => [
					'ha_multi_layer_parallax_hor' => 'custom'
				]
			]
		);

		$repeater->add_control(
			'ha_multi_layer_parallax_ver',
			[
				'label'   => __( 'Vertical Alignment', 'happy-addons-pro' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'top'     => __( 'Top', 'happy-addons-pro' ),
					'vcenter' => __( 'Center', 'happy-addons-pro' ),
					'bottom'  => __( 'Bottom', 'happy-addons-pro' ),
					'custom'  => __( 'Custom', 'happy-addons-pro' )
				],
				'default' => 'custom'
			]
		);

		$repeater->add_responsive_control(
			'ha_multi_layer_parallax_ver_pos',
			[
				'label'       => __( 'Vertical Position', 'happy-addons-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 0,
					'unit' => '%'
				],
				'min'         => 0,
				'max'         => 100,
				'description' => __( 'Set the vertical position for the layer background, default: 50%', 'happy-addons-pro' ),
				'label_block' => true,
				'condition'   => [
					'ha_multi_layer_parallax_ver' => 'custom'
				]
			]
		);

		$repeater->add_control(
			'ha_multi_layer_parallax_hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$repeater->add_control(
			'ha_multi_layer_parallax_effect_type',
			[
				'label'   => __( 'Effect Type', 'happy-addons-pro' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'mouse_track' => __( 'Mouse Track', 'happy-addons-pro' ),
					'scroll_parallax' => __( 'Scroll Parallax', 'happy-addons-pro' )
				],
				'default' => 'scroll_parallax'
			]
		);

		$repeater->add_control(
			'ha_multi_layer_parallax_rate',
			[
				'label'       => __( 'Rate', 'happy-addons-pro' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => -10,
				'min'         => -20,
				'max'         => 20,
				'step'        => 1,
				'description' => __( 'Choose the movement rate for the layer background, default: -10', 'happy-addons-pro' ),
				'condition'   => [
					'ha_multi_layer_parallax_effect_type' => 'mouse_track'
				]
			]
		);

		$repeater->add_control(
			'ha_multi_layer_parallax_scroll_ver',
			[
				'label'     => __( 'Vertical Parallax', 'happy-addons-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'ha_multi_layer_parallax_effect_type' => 'scroll_parallax'
				],
				'default'   => 'yes'
			]
		);


		$repeater->add_control(
			'ha_multi_layer_parallax_direction',
			[
				'label'     => __( 'Direction', 'happy-addons-pro' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'up'   => __( 'Up', 'happy-addons-pro' ),
					'down' => __( 'Down', 'happy-addons-pro' )
				],
				'default'   => 'down',
				'condition' => [
					'ha_multi_layer_parallax_effect_type' => 'scroll_parallax',
					'ha_multi_layer_parallax_scroll_ver' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'ha_multi_layer_parallax_speed',
			[
				'label'     => __( 'Speed', 'happy-addons-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 4
				],
				'range'     => [
					'px' => [
						'max'  => 10,
						'step' => 0.1
					]
				],
				'condition' => [
					'ha_multi_layer_parallax_effect_type' => 'scroll_parallax',
					'ha_multi_layer_parallax_scroll_ver' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'ha_multi_layer_parallax_view',
			[
				'label'     => __( 'Viewport', 'happy-addons-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'sizes' => [
						'start' => 0,
						'end'   => 100
					],
					'unit'  => '%'
				],
				'labels'    => [
					__( 'Bottom', 'happy-addons-pro' ),
					__( 'Top', 'happy-addons-pro' )
				],
				'scales'    => 1,
				'handles'   => 'range',
				'condition' => [
					'ha_multi_layer_parallax_effect_type' => 'scroll_parallax',
					'ha_multi_layer_parallax_scroll_ver' => 'yes'
				],
				'separator'   => 'after',
			]
		);

		$repeater->add_control(
			'ha_multi_layer_parallax_scroll_hor',
			[
				'label'     => __( 'Horizontal Parallax', 'happy-addons-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'ha_multi_layer_parallax_effect_type' => 'scroll_parallax'
				]
			]
		);

		$repeater->add_control(
			'ha_multi_layer_parallax_direction_hor',
			[
				'label'     => __( 'Direction', 'happy-addons-pro' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'up'   => __( 'Left', 'happy-addons-pro' ),
					'down' => __( 'Right', 'happy-addons-pro' )
				],
				'default'   => 'down',
				'condition' => [
					'ha_multi_layer_parallax_effect_type' => 'scroll_parallax',
					'ha_multi_layer_parallax_scroll_hor' => 'yes'
				]
			]
		);


		$repeater->add_control(
			'ha_multi_layer_parallax_speed_hor',
			[
				'label'     => __( 'Speed', 'happy-addons-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 4
				],
				'range'     => [
					'px' => [
						'max'  => 10,
						'step' => 0.1
					]
				],
				'condition' => [
					'ha_multi_layer_parallax_effect_type' => 'scroll_parallax',
					'ha_multi_layer_parallax_scroll_hor' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'ha_multi_layer_parallax_view_hor',
			[
				'label'     => __( 'Viewport', 'happy-addons-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'sizes' => [
						'start' => 0,
						'end'   => 100
					],
					'unit'  => '%'
				],
				'labels'    => [
					__( 'Bottom', 'happy-addons-pro' ),
					__( 'Top', 'happy-addons-pro' )
				],
				'scales'    => 1,
				'handles'   => 'range',
				'condition' => [
					'ha_multi_layer_parallax_effect_type' => 'scroll_parallax',
					'ha_multi_layer_parallax_scroll_hor' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'show_layer_on',
			[
				'label'       => __( 'Show Layer On', 'happy-addons-pro' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => self::get_all_breakpoints(),
				'default'     => array_keys( self::get_all_breakpoints() ),
				'multiple'    => true,
				'separator'   => 'before',
				'label_block' => true
			]
		);

		$element->add_control(
			'ha_multi_layer_parallax_list',
			[
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'prevent_empty' => false,
				'condition'     => [
					'ha_multi_layer_parallax_switcher' => 'yes'
				]
			]
		);

		$element->add_control(
			'ha_multi_layer_parallax_devices',
			[
				'label'       => __( 'Apply Scroll Parallax On', 'happy-addons-pro' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => self::get_all_breakpoints(),
				'default'     => array_keys( self::get_all_breakpoints() ),
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'ha_multi_layer_parallax_switcher' => 'yes'
				]
			]
		);

		$element->end_controls_section();
	}

	/**
	 * Render Parallax output on the frontend.
	 */
	public function before_render( $element ) {
		$settings = $element->get_settings_for_display();
		$is_enable = 'yes' === $element->get_settings( 'ha_multi_layer_parallax_switcher' ) ? true : false;
		if ( $is_enable && $settings['ha_multi_layer_parallax_list'] ) {
			$layers = array();
			if ( is_countable( $settings['ha_multi_layer_parallax_list'] ) ) {
				foreach ( $settings['ha_multi_layer_parallax_list'] as $layer ) {
					$layer['alt'] = Control_Media::get_image_alt( $layer['ha_multi_layer_parallax_image'] );
					array_push( $layers, $layer );
				}
			}

			$layers_settings = [
				'items'   => $layers,
				'devices' => $settings['ha_multi_layer_parallax_devices'],
			];

			$element->add_render_attribute( '_wrapper', 'data-ha-multi-layer-parallax', wp_json_encode( $layers_settings ) );
		}
	}

	public function editor_template_print( $template, $widget ) {

		if ( ! $template && 'widget' === $element->get_type() ) {
			return;
		}

		$old_template = $template;
		ob_start();
		?>
		<#
		var isEnabled = 'yes' == settings.ha_multi_layer_parallax_switcher ? true : false;
		if( isEnabled && settings.ha_multi_layer_parallax_list ) {
			var parallaxSettings = {};
			var layers = [] ;

			_.each( settings.ha_multi_layer_parallax_list, function( layer, index ) {
				layers.push( layer );
			});

			parallaxSettings.items   = layers;
			parallaxSettings.devices = settings.ha_multi_layer_parallax_devices;
			<!-- parallaxSettings.speed = settings.frames; -->

			view.addRenderAttribute( 'ha_multi_layer_parallax_data', {
				'id': 'ha-multi-layer-parallax--' + view.getID(),
				'data-ha-multi-layer-parallax': JSON.stringify( parallaxSettings )
			});

		#>
			<div {{{ view.getRenderAttributeString( 'ha_multi_layer_parallax_data' ) }}}></div>
		<# } #>
		<?php

		$parallax_content = ob_get_contents();
		ob_end_clean();
		$template = $parallax_content . $old_template;
		return $template;
	}
}
