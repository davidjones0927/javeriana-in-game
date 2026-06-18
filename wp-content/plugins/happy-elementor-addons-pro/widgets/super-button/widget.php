<?php
/**
 * Super Button widget class
 *
 * @package Happy_Addons_Pro
 */

namespace Happy_Addons_Pro\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Happy_Addons_Pro\Classes\Breadcrumb_Trail;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Repeater;

defined('ABSPATH') || die();

class Super_Button extends Base {
	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title() {
		return __('Super Button', 'happy-addons-pro');
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'hm hm-fixed-size-button';
	}

	public function get_keywords() {
		return ['super-button', 'super', 'button', 'creative'];
	}

	public function get_custom_help_url() {
		return 'https://happyaddons.com/docs/happy-addons-for-elementor-pro/happy-effects-pro/super-button/';
	}

	protected function is_dynamic_content(): bool {
		return false;
	}

	/**
     * Register widget content controls
     */
	protected function register_content_controls() {
		$this->__button_settings_content_controls();
		$this->__dropdown_content_controls();
	}

	protected function __button_settings_content_controls() {

		$this->start_controls_section(
			'_section_button_settings',
			[
				'label' => __('Button', 'happy-addons-pro'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_style',
			[
				'label'                 => __( 'Button Style', 'happy-addons-pro' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'style-1',
				'options'               => [
					'style-1'          => __( 'Morphy', 'happy-addons-pro' ),
					'style-2'          => __( 'Hide & Seek', 'happy-addons-pro' ),
					'style-3'          => __( 'Swap Over', 'happy-addons-pro' ),
					'style-4'          => __( 'Resurface', 'happy-addons-pro' ),
					'style-5'          => __( 'Pill CTA', 'happy-addons-pro' ),
					'style-6'          => __( 'Back and Forth', 'happy-addons-pro' ),
					// 'style-7'          => __( 'Style 7', 'happy-addons-pro' ),
					'style-8'          => __( 'Pipeline', 'happy-addons-pro' ),
					'style-9'          => __( 'Sliding pill', 'happy-addons-pro' ),
					'style-10'         => __( 'Drawer', 'happy-addons-pro' ),

					// 'style-11'         => __( 'Style 11', 'happy-addons-pro' ),
				],
			]
		);

		$this->add_control(
			'btn_icon',
			[
				'label' => __( 'Icon', 'happy-addons-pro' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'huge huge-arrow-right-02-round',
					'library' => 'huge-icons',
				],
				'condition' => [
					'button_style!' => ['style-8'], //,'style-10'
				],
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label' => __( 'Button Text', 'happy-addons-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Start the Journey', 'happy-addons-pro' ),
				'placeholder' => __( 'Type button text here', 'happy-addons-pro' ),
				'label_block' => false,
				'dynamic' => [
					'active' => true
				],
				// 'condition' => [
				// 	'button_style!' => ['style-10'],
				// ],
			]
		);

		$this->add_control(
			'btn_link',
			[
				'label' => __( 'Link', 'happy-addons-pro' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'https://happyaddons.com/',
				'default' => [
					'url' => '#',
					'is_external' => true
				],
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'button_style!' => ['style-10'],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __dropdown_content_controls() {

		$this->start_controls_section(
			'_section_dropdown_content',
			[
				'label' => __('Dropdown Item', 'happy-addons-pro'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'button_style' => 'style-10'
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'option_text',
			[
				'label' => __( 'Option Text', 'happy-addons-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Start the Journey', 'happy-addons-pro' ),
				'placeholder' => __( 'Type button text here', 'happy-addons-pro' ),
				'label_block' => false,
				'dynamic' => [
					'active' => true
				],
			]
		);

		$repeater->add_control(
			'option_link',
			[
				'label' => __( 'Option Link', 'happy-addons-pro' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'https://happyaddons.com/',
				'default' => [
					'url' => '#',
					'is_external' => true
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'option_icon',
			[
				'label' => __( 'Icon', 'happy-addons-pro' ),
				'type' => Controls_Manager::ICONS,
				'default' => [],
				// 'default' => [
				// 	'value' => 'fas fa-arrow-bottom',
				// 	'library' => 'solid',
				// ],
			]
		);

		$this->add_control(
			'btn_list',
			[
				'label' => __( 'Option List', 'happy-addons-pro' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'option_text' => __( 'MacOS', 'happy-addons-pro' ),
						'option_link' => [
								'url' => 'https://happyaddons.com/',
								'is_external' => true
						],
						'option_icon' => [
							'value' => 'fab fa-apple',
							'library' => 'brands',
						],
					],
					[
						'option_text' => __( 'Windows', 'happy-addons-pro' ),
						'option_link' => [
								'url' => 'https://happyaddons.com/pricing/',
								'is_external' => true
						],
						'option_icon' => [
							'value' => 'fab fa-windows',
							'library' => 'brands',
						],
					],
					[
						'option_text' => __( 'Android', 'happy-addons-pro' ),
						'option_link' => [
								'url' => '#',
								'is_external' => true
						],
						'option_icon' => [
							'value' => 'hm hm-android',
							'library' => 'happy-icons',
						],
					],
				],
				'title_field' => '{{{ option_text }}}',
				'condition' => [
					'button_style' => ['style-10'],
				],
			]
		);

		$this->add_control(
			'dropdown_pos',
			[
				'label' => __( 'Dropdown Position', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'happy-addons-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => __( 'Top', 'happy-addons-pro' ),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => __( 'Top', 'happy-addons-pro' ),
						'icon' => 'eicon-v-align-bottom',
					],
					'right' => [
						'title' => __( 'Right', 'happy-addons-pro' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'bottom',
				// 'selectors_dictionary' => [
				// 	'left' => '0',
				// 	'top' => 'unset',
				// 	'right' => '1',
				// ],
				// 'selectors' => [
				// 	'{{WRAPPER}} .ha-price-menu .ha-price-menu-item .ha-price-menu-image' => 'order: {{VALUE}};',
				// ],
				// 'prefix_class' => 'ha-price-menu-image-align-',
				'condition' => [
					'button_style' => ['style-10'],
				],
			]
		);

		$this->add_control(
			'show_dropdown_on_editor',
			[
				'label' => __('Dropdown show on editor?', 'happy-addons-pro'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'happy-addons-pro'),
				'label_off' => __('Hide', 'happy-addons-pro'),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'button_style' => ['style-10'],
				],
			]
		);

		$this->add_control(
			'dropdown_layout',
			[
				'label' => __( 'Dropdown Layout', 'happy-addons-pro' ),
				'label_block' => false,
				'type' => Controls_Manager::CHOOSE,
				'default' => 'list',
                'toggle' => false,
				'options' => [
					'list' => [
						'title' => __( 'List', 'happy-addons-pro' ),
						'icon' => 'eicon-editor-list-ul',
					],
					'inline' => [
						'title' => __( 'Inline', 'happy-addons-pro' ),
						'icon' => 'eicon-ellipsis-h',
					],
				],
				'style_transfer' => true,
			]
		);

		/* $this->add_control(
			'icon_pos',
			[
				'label' => __( 'Icon Position', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'happy-addons-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => __( 'Top', 'happy-addons-pro' ),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => __( 'Top', 'happy-addons-pro' ),
						'icon' => 'eicon-v-align-bottom',
					],
					'right' => [
						'title' => __( 'Right', 'happy-addons-pro' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'bottom',
                'toggle' => false,
				'selectors_dictionary' => [
					'left' => '0',
					'top' => 'unset',
					'right' => '1',
				],
				// 'selectors' => [
				// 	'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a.ha-super-btn-dropdown-menu-item' => 'order: {{VALUE}};',
				// ],
				// 'prefix_class' => '.ha-super-btn-dropdown-menu-item-icon-align-',
				'condition' => [
					'button_style!' => ['style-10'],
				],
			]
		); */


		$this->add_control(
			'dropdown_icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				// 'mobile_default' => 'top',
                'toggle' => false,
				'style_transfer' => true,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'happy-addons-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => esc_html__( 'Top', 'happy-addons-pro' ),
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'happy-addons-pro' ),
						'icon' => 'eicon-h-align-right',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'happy-addons-pro' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				// 'prefix_class' => 'elementor%s-position-', // %s is for responsive control only.
				'prefix_class' => 'ha-super-btn-dropdown-icon-pos--',
				// 'prefix_class' => 'ha-super-btn-dropdown-icon-pos--',
				'condition' => [
					'button_style' => ['style-10'],
				],
			]
		);
			// 'elementor%s-position-'
			// %s will place the device name. like:- -widescreen, -laptop, -tablet
			// .elementor-widescreen-position-right

		$this->add_control(
			'dropdown_content_vertical_alignment',
			[
				'label' => esc_html__( 'Vertical Alignment', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'happy-addons-pro' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'happy-addons-pro' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'happy-addons-pro' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'middle',
                'toggle' => false,
				'style_transfer' => true,
				'selectors_dictionary' => [
					'top' => 'start',
					'middle' => 'center',
					'bottom' => 'end',
				],
				'selectors' => [
					'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a' => 'align-items: {{VALUE}};',
					// '{{WRAPPER}} .elementor-icon-box-wrapper' => 'align-items: {{VALUE}};',
				],
				'condition' => [
					'button_style' => ['style-10'],
					'dropdown_icon_position' => [ 'left', 'right' ],
				],
			]
		);

		$this->add_control(
			'dropdown_item_text_align',
			[
				'label' => esc_html__( 'Alignment', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-right',
					],
					// 'justify' => [
					// 	'title' => esc_html__( 'Justified', 'happy-addons-pro' ),
					// 	'icon' => 'eicon-text-align-justify',
					// ],
				],
				'default' => 'left',
                'toggle' => false,
				'style_transfer' => true,
				'selectors' => [
					'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a' => 'text-align: {{VALUE}};',
				],
				// 'separator' => 'after',
				'condition' => [
					'dropdown_icon_position' => [ 'top', 'bottom' ],
					'button_style' => ['style-10'],
					'dropdown_layout' => 'list',
				],
			]
		);

		$this->add_control(
			'dropdown_item_justify_align',
			[
				'label' => esc_html__( 'Alignment', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-right',
					],
					'space-between' => [
						'title' => esc_html__( 'Justified', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'flex-start',
                'toggle' => false,
				'style_transfer' => true,
				'selectors' => [
					'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a' => 'justify-content: {{VALUE}};',
				],
				'condition' => [
					'dropdown_icon_position' => [ 'left', 'right' ],
					'button_style' => ['style-10'],
					'dropdown_layout' => 'list',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
     * Register widget style controls
     */
	protected function register_style_controls() {
		$this->__common_btn_style_controls();
		$this->__icon_box_style_controls();
		$this->__dropdown_style_controls();
	}

	// style = ['1','2','3','4','5','6','8']
    protected function __common_btn_style_controls() {

        $this->start_controls_section(
            '_section_style_common',
            [
                'label' => __( 'Button', 'happy-addons-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
		);

		// style = ['9']
		$this->add_responsive_control(
			'button_size',
			[
				'label' => __( 'Width', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					// '{{WRAPPER}} .ha-pricing-table-media--icon > i' => 'font-size: {{SIZE}}{{UNIT}};',
					// '{{WRAPPER}} .ha-pricing-table-media--icon > svg' => 'width: {{SIZE}}{{UNIT}};',
					// '{{WRAPPER}} :is(.ha-super-btn-stl-1, .ha-super-btn-stl-2, .ha-super-btn-stl-6) .ha-super-btn-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ha-super-btn-stl-9' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-9'],
				]
			]
		);

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __( 'Typography', 'happy-addons-pro' ),
                'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
                'selector' => '
					{{WRAPPER}} .ha-super-btn-stl-1 .ha-super-btn-text,
					{{WRAPPER}} .ha-super-btn-stl-1 .ha-super-btn-icon > :is(i, svg),

					{{WRAPPER}} .ha-super-btn-stl-2 .ha-super-btn-text,
					{{WRAPPER}} .ha-super-btn-stl-2 .ha-super-btn-icon > :is(i, svg),

					{{WRAPPER}} .ha-super-btn-stl-3 .ha-super-btn-text,
					{{WRAPPER}} .ha-super-btn-stl-3 .ha-super-btn-icon,

					{{WRAPPER}} .ha-super-btn-stl-4 .ha-super-btn-text,
					{{WRAPPER}} .ha-super-btn-stl-4 .ha-super-btn-icon,

					{{WRAPPER}} .ha-super-btn-stl-5 .ha-super-btn-text,
					{{WRAPPER}} .ha-super-btn-stl-5 .ha-super-btn-icon,

					{{WRAPPER}} .ha-super-btn-stl-6 .ha-super-btn-text,
					{{WRAPPER}} .ha-super-btn-stl-6 .ha-super-btn-icon span,

					{{WRAPPER}} .ha-super-btn-stl-8 .ha-super-btn-text,
					{{WRAPPER}} .ha-super-btn-stl-9 .ha-super-btn-text,
					{{WRAPPER}} .ha-super-btn-stl-9 .ha-super-btn-icon,
					{{WRAPPER}} .ha-super-btn-stl-10 button
				',
            ]
		);

		$this->add_responsive_control(
            'button_padding',
            [
                'label' => __( 'Padding', 'happy-addons-pro' ),
                'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ha-super-btn-stl-1 .ha-super-btn-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .ha-super-btn-stl-2 .ha-super-btn-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .ha-super-btn-stl-3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .ha-super-btn-stl-4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .ha-super-btn-stl-5' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .ha-super-btn-stl-6' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .ha-super-btn-stl-8' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .ha-super-btn-stl-9' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .ha-super-btn-stl-10 button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-super-btn-stl-1 .ha-super-btn-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ha-super-btn-stl-2 .ha-super-btn-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ha-super-btn-stl-3' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ha-super-btn-stl-4' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ha-super-btn-stl-5' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ha-super-btn-stl-6' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ha-super-btn-stl-8' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ha-super-btn-stl-9' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ha-super-btn-stl-10 button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		// style = ['3','4','5','6','8','9','10']
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'button_border',
				'label'                 => __( 'Border', 'happy-addons-pro' ),
				'selector'              => '{{WRAPPER}} .ha-breadcrumbs li span.ha-breadcrumbs-text',
				'condition' => [
					'button_style' => ['style-3','style-4','style-5','style-6','style-8','style-9','style-10'],
				],
                'selector' => '
					{{WRAPPER}} .ha-super-btn-stl-3,
					{{WRAPPER}} .ha-super-btn-stl-4,
					{{WRAPPER}} .ha-super-btn-stl-5,
					{{WRAPPER}} .ha-super-btn-stl-6,
					{{WRAPPER}} .ha-super-btn-stl-8,
					{{WRAPPER}} .ha-super-btn-stl-9,
					{{WRAPPER}} .ha-super-btn-stl-10 button
				',
			]
		);
		// style = ['3','4','5','6','8','9','10']
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_shadow',
				'condition' => [
					'button_style' => ['style-3','style-4','style-5','style-6','style-8','style-9','style-10'],
				],
                'selector' => '
					{{WRAPPER}} .ha-super-btn-stl-3,
					{{WRAPPER}} .ha-super-btn-stl-4,
					{{WRAPPER}} .ha-super-btn-stl-5,
					{{WRAPPER}} .ha-super-btn-stl-6,
					{{WRAPPER}} .ha-super-btn-stl-8,
					{{WRAPPER}} .ha-super-btn-stl-9,
					{{WRAPPER}} .ha-super-btn-stl-10 button
				',
			]
		);

		/* Hover & Normal Style */
		$this->add_control(
			'hr',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( '_tabs_button' );

		$this->start_controls_tab(
			'_tab_button_normal',
			[
				'label' => __( 'Normal', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-super-btn-stl-1 .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-1 .ha-super-btn-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-2 .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-2 .ha-super-btn-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-3 .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-3 .ha-super-btn-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-4 .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-4 .ha-super-btn-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-5 .ha-super-btn-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-6 .ha-super-btn-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-8 .ha-super-btn-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-9 .ha-super-btn-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-10 button' => 'color: {{VALUE}};',
				],
			]
		);

		// $this->add_control(
		// 	'button_bg_color',
		// 	[
		// 		'label' => __( 'Background Color', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .ha-super-btn-stl-1 .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-1 .ha-super-btn-icon' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-2 .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-2 .ha-super-btn-icon' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-3' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-4' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-5' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-6' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-8' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-9' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-10 button' => 'background-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_bg',
				'label' => __( 'Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => ['image'],
				// 'selector' => '{{WRAPPER}} .ha-super-btn-stl-1 .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-1 .ha-super-btn-icon',
                'selector' => '
					{{WRAPPER}} .ha-super-btn-stl-1 :is(.ha-super-btn-text, .ha-super-btn-icon),
					{{WRAPPER}} .ha-super-btn-stl-2 :is(.ha-super-btn-text, .ha-super-btn-icon),

					{{WRAPPER}} :is(.ha-super-btn-stl-3, .ha-super-btn-stl-4, .ha-super-btn-stl-5, .ha-super-btn-stl-6, .ha-super-btn-stl-8, .ha-super-btn-stl-9, .ha-super-btn-stl-10 button),

					{{WRAPPER}} .ha-super-btn-stl-2 .ha-super-btn-icon20,
					{{WRAPPER}} .ha-super-btn-stl-60
				',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_button_hover',
			[
				'label' => __( 'Hover', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-super-btn-stl-1:hover .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-1:focus .ha-super-btn-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-1:hover .ha-super-btn-icon, {{WRAPPER}} .ha-super-btn-stl-1:focus .ha-super-btn-icon' => 'color: {{VALUE}};',

					'{{WRAPPER}} .ha-super-btn-stl-2:hover .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-2:focus .ha-super-btn-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-2:hover .ha-super-btn-icon, {{WRAPPER}} .ha-super-btn-stl-2:focus .ha-super-btn-icon' => 'color: {{VALUE}};',

					'{{WRAPPER}} .ha-super-btn-stl-3:hover .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-3:focus .ha-super-btn-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-3:hover .ha-super-btn-icon, {{WRAPPER}} .ha-super-btn-stl-3:focus .ha-super-btn-icon' => 'color: {{VALUE}};',

					'{{WRAPPER}} .ha-super-btn-stl-4:hover .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-4:focus .ha-super-btn-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-4:hover .ha-super-btn-icon, {{WRAPPER}} .ha-super-btn-stl-4:focus .ha-super-btn-icon' => 'color: {{VALUE}};',

					'{{WRAPPER}} .ha-super-btn-stl-5:hover .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-5:focus .ha-super-btn-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-6:hover .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-6:focus .ha-super-btn-text' => 'color: {{VALUE}};',

					'{{WRAPPER}} .ha-super-btn-stl-8:hover .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-8:focus .ha-super-btn-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-9:hover .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-9:focus .ha-super-btn-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-10:hover button, {{WRAPPER}} .ha-super-btn-stl-10:focus button' => 'color: {{VALUE}};',
				],
			]
		);

		// $this->add_control(
		// 	'button_hover_bg_color',
		// 	[
		// 		'label' => __( 'Background Color', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			// '{{WRAPPER}} .ha-pricing-table-btn:hover, {{WRAPPER}} .ha-pricing-table-btn:focus' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-1:hover .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-1:focus .ha-super-btn-text' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-1:hover .ha-super-btn-icon, {{WRAPPER}} .ha-super-btn-stl-1:focus .ha-super-btn-icon' => 'background-color: {{VALUE}};',

		// 			'{{WRAPPER}} .ha-super-btn-stl-2:hover .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-2:focus .ha-super-btn-text' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-2:hover .ha-super-btn-icon, {{WRAPPER}} .ha-super-btn-stl-2:focus .ha-super-btn-icon' => 'background-color: {{VALUE}};',

		// 			'{{WRAPPER}} .ha-super-btn-stl-3:hover, {{WRAPPER}} .ha-super-btn-stl-3:focus' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-4:hover, {{WRAPPER}} .ha-super-btn-stl-4:focus' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-5:hover, {{WRAPPER}} .ha-super-btn-stl-5:focus' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-6:hover, {{WRAPPER}} .ha-super-btn-stl-6:focus' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-8:hover, {{WRAPPER}} .ha-super-btn-stl-8:focus' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-9:hover, {{WRAPPER}} .ha-super-btn-stl-9:focus' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-10:hover button, {{WRAPPER}} .ha-super-btn-stl-10:focus button' => 'background-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_hover_bg',
				'label' => __( 'Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => ['image'],
				// 'selector' => '{{WRAPPER}} .ha-super-btn-stl-1 .ha-super-btn-text, {{WRAPPER}} .ha-super-btn-stl-1 .ha-super-btn-icon',
                'selector' => '
					{{WRAPPER}} .ha-super-btn-stl-1:hover :is(.ha-super-btn-text, .ha-super-btn-icon),
					{{WRAPPER}} .ha-super-btn-stl-1:focus :is(.ha-super-btn-text, .ha-super-btn-icon),
					{{WRAPPER}} .ha-super-btn-stl-2:focus :is(.ha-super-btn-text, .ha-super-btn-icon),
					{{WRAPPER}} .ha-super-btn-stl-2:hover :is(.ha-super-btn-text, .ha-super-btn-icon),

					{{WRAPPER}} :is(.ha-super-btn-stl-3, .ha-super-btn-stl-4, .ha-super-btn-stl-5, .ha-super-btn-stl-6, .ha-super-btn-stl-8, .ha-super-btn-stl-9, .ha-super-btn-stl-10 button):hover,
					{{WRAPPER}} :is(.ha-super-btn-stl-3, .ha-super-btn-stl-4, .ha-super-btn-stl-5, .ha-super-btn-stl-6, .ha-super-btn-stl-8, .ha-super-btn-stl-9, .ha-super-btn-stl-10 button):focus,

					{{WRAPPER}} .ha-super-btn-stl-2 .ha-super-btn-icon20,
					{{WRAPPER}} .ha-super-btn-stl-60
				',
			]
		);

		// style = ['3','4','5','6','8','9','10']
		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'button_style' => ['style-3','style-4','style-5','style-6','style-8','style-9','style-10'],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-super-btn-stl-3:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-4:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-5:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-6:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-8:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-9:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-10:hover button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// $this->icon_style();

		// style = ['8']
		$this->pipe_style();

		$this->end_controls_section();
	}

	protected function __icon_box_style_controls() {

		$this->start_controls_section(
			'_section_icon_box_style',
			[
				'label' => __('Icon', 'happy-addons-pro'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_style' => ['style-1','style-2','style-3','style-5','style-6','style-9','style-10'],
				]
			]
		);

		$this->icon_style();

		$this->end_controls_section();
	}

	// style = ['1','2','3','5','6','9','10']
	protected function icon_style() {
		/* Icon Style */
		// style = ['1','2','3','5','6','9','10']
		$this->add_control(
			'icon_style_header',
			[
				'label' => __( 'Icon', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				// 'separator' => 'before',
				'condition' => [
					'button_style' => ['style-1','style-2','style-3','style-5','style-6','style-9','style-10'],
				]
			]
		);
		// style = ['1','2','5','6','9']
		$this->add_responsive_control(
			'icon_box_size',
			[
				'label' => __( 'Box Size', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					// '{{WRAPPER}} .ha-pricing-table-media--icon > i' => 'font-size: {{SIZE}}{{UNIT}};',
					// '{{WRAPPER}} .ha-pricing-table-media--icon > svg' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} :is(.ha-super-btn-stl-1, .ha-super-btn-stl-2, .ha-super-btn-stl-6) .ha-super-btn-icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} :is(.ha-super-btn-stl-2)' => '--ha-super-btn-margin-inline: {{SIZE}};',
					'{{WRAPPER}} :is(.ha-super-btn-stl-5)' => '--ha-super-btn-stl-5-icon-size: {{SIZE}};',
					'{{WRAPPER}} :is(.ha-super-btn-stl-9)' => '--ha-super-btn-stl-9-btn-icon-box-width: {{SIZE}}px;',
				],
				'condition' => [
					'button_style' => ['style-1','style-2','style-5','style-6','style-9'],
				]
			]
		);
		// style = ['1','2','3','4','5','6','10']
		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					// '{{WRAPPER}} .ha-pricing-table-media--icon > i' => 'font-size: {{SIZE}}{{UNIT}};',
					// '{{WRAPPER}} .ha-pricing-table-media--icon > svg' => 'width: {{SIZE}}{{UNIT}};',
					// '{{WRAPPER}} :is(.ha-super-btn-stl-1, .ha-super-btn-stl-2, .ha-super-btn-stl-6) .ha-super-btn-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} :is(.ha-super-btn-stl-1, .ha-super-btn-stl-2, .ha-super-btn-stl-3, .ha-super-btn-stl-4, .ha-super-btn-stl-5, .ha-super-btn-stl-6, .ha-super-btn-stl-9) .ha-super-btn-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} :is(.ha-super-btn-stl-1, .ha-super-btn-stl-2, .ha-super-btn-stl-3, .ha-super-btn-stl-4, .ha-super-btn-stl-5, .ha-super-btn-stl-6, .ha-super-btn-stl-9) .ha-super-btn-icon svg' => 'height: {{SIZE}}{{UNIT}};',

					'{{WRAPPER}} :is(.ha-super-btn-stl-10) button .ha-super-btn-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} :is(.ha-super-btn-stl-10) button .ha-super-btn-icon svg' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-1','style-2','style-3','style-4','style-5','style-6','style-9','style-10'],
				]
			]
		);

		$this->add_control(
			'icon_size_notice',
			[
				'type' => Controls_Manager::NOTICE,
				'notice_type' => 'info',
				'dismissible' => false,
				'content' => esc_html__( 'Icon Size can not exceed the Box Size.', 'happy-addons-pro' ),
				'condition' => [
					'button_style' => ['style-1','style-2','style-5','style-6','style-9'],
				]
			]
		);

		// style = ['3','5','6','10']
		$this->add_responsive_control(
			'icon_spacing',
			[
				'label' => __( 'Icon Spacing', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .ha-super-btn-stl-3 .ha-super-btn-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
					// '{{WRAPPER}} .ha-super-btn-stl-4 .ha-super-btn-text+.ha-super-btn-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
					// '{{WRAPPER}} .ha-super-btn-stl-4 .ha-super-btn-icon+.ha-super-btn-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ha-super-btn-stl-5 .ha-super-btn-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ha-super-btn-stl-6 .ha-super-btn-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ha-super-btn-stl-10 button .ha-super-btn-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-3','style-5','style-6','style-10'],
				]
			]
		);
		// style = ['10']
		$this->add_responsive_control(
            'icon_box_padding',
            [
                'label' => __( 'Padding', 'happy-addons-pro' ),
                'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} :is(.ha-super-btn-stl-10) button .ha-super-btn-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
				'condition' => [
					'button_style' => ['style-10'],
				]
            ]
		);
		// style = ['10']
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'icon_box_border',
				'label'                 => __( 'Border', 'happy-addons-pro' ),
				'selector'              => '{{WRAPPER}} .ha-breadcrumbs li span.ha-breadcrumbs-text',
				'condition' => [
					'button_style' => ['style-10'],
				],
                'selector' => '
					{{WRAPPER}} .ha-super-btn-stl-10 button .ha-super-btn-icon
				',
			]
		);
		// style = ['1','2','5','6','10']
		$this->add_control(
			'icon_box_border_radius',
			[
				'label' => __( 'Border Radius', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} :is(.ha-super-btn-stl-1, .ha-super-btn-stl-2, .ha-super-btn-stl-5, .ha-super-btn-stl-6, .ha-super-btn-stl-10) .ha-super-btn-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-1','style-2','style-5','style-6','style-10'],
				]
			]
		);

		// style = ['5','6,'9']
		$this->start_controls_tabs(
			'_tabs_button_icon',
			[
				'condition' => [
					'button_style' => ['style-5','style-6','style-9'],
				]
			]
		);

		$this->start_controls_tab(
			'_tab_button_icon_normal',
			[
				'label' => __( 'Normal', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'button_icon_color',
			[
				'label' => __( 'Icon Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-super-btn-stl-5 .ha-super-btn-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-6 .ha-super-btn-icon span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-9 .ha-super-btn-icon' => 'color: {{VALUE}};',
				],
			]
		);

		// $this->add_control(
		// 	'button_icon_bg_color',
		// 	[
		// 		'label' => __( 'Background Color', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .ha-super-btn-stl-5 .ha-super-btn-icon' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-6 .ha-super-btn-icon' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-9 .ha-super-btn-icon-overlay' => 'background-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_icon_bg',
				'label' => __( 'Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => ['image'],
                'selector' => '
					{{WRAPPER}} :is(.ha-super-btn-stl-5, .ha-super-btn-stl-6) .ha-super-btn-icon,
					{{WRAPPER}} .ha-super-btn-stl-9 .ha-super-btn-icon-overlay
				',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_button_icon_hover',
			[
				'label' => __( 'Hover', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'button_icon_hover_color',
			[
				'label' => __( 'Icon Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-super-btn-stl-5:hover .ha-super-btn-icon, {{WRAPPER}} .ha-super-btn-stl-5:focus .ha-super-btn-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-6:hover .ha-super-btn-icon span, {{WRAPPER}} .ha-super-btn-stl-6:focus .ha-super-btn-icon span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-super-btn-stl-9:hover .ha-super-btn-icon, {{WRAPPER}} .ha-super-btn-stl-9:focus .ha-super-btn-icon' => 'color: {{VALUE}};',
				],
			]
		);

		// $this->add_control(
		// 	'button_icon_hover_bg_color',
		// 	[
		// 		'label' => __( 'Background Color', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .ha-super-btn-stl-5:hover .ha-super-btn-icon, {{WRAPPER}} .ha-super-btn-stl-5:focus .ha-super-btn-icon' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-6:hover .ha-super-btn-icon, {{WRAPPER}} .ha-super-btn-stl-6:focus .ha-super-btn-icon' => 'background-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-9:hover .ha-super-btn-icon-overlay, {{WRAPPER}} .ha-super-btn-stl-9:focus .ha-super-btn-icon-overlay' => 'background-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_icon_hover_bg',
				'label' => __( 'Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => ['image'],
                'selector' => '
					{{WRAPPER}} .ha-super-btn-stl-5:hover :is(.ha-super-btn-text, .ha-super-btn-icon),
					{{WRAPPER}} .ha-super-btn-stl-5:focus :is(.ha-super-btn-text, .ha-super-btn-icon),

					{{WRAPPER}} .ha-super-btn-stl-6:focus :is(.ha-super-btn-text, .ha-super-btn-icon),
					{{WRAPPER}} .ha-super-btn-stl-6:hover :is(.ha-super-btn-text, .ha-super-btn-icon),

					{{WRAPPER}} .ha-super-btn-stl-9:hover .ha-super-btn-icon-overlay,
					{{WRAPPER}} .ha-super-btn-stl-9:focus .ha-super-btn-icon-overlay
				',
			]
		);

		// style = ['3','4']
		// $this->add_control(
		// 	'button_icon_hover_border_color',
		// 	[
		// 		'label' => __( 'Border Color', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::COLOR,
		// 		'condition' => [
		// 			'button_style' => ['style-3','style-4'],
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .ha-super-btn-stl-3:hover' => 'border-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-4:hover' => 'border-color: {{VALUE}};',
		// 			'{{WRAPPER}} .ha-super-btn-stl-5:hover' => 'border-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		$this->end_controls_tab();
		$this->end_controls_tabs();

	}

	// style = ['8']
	protected function pipe_style() {
		$this->add_control(
			'pipe_style_header',
			[
				'label' => __( 'Pipe', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'button_style' => ['style-8'],
				]
			]
		);

		$this->add_responsive_control(
			'pipe_width',
			[
				'label' => __( 'Width', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-super-btn-stl-8 span.ha-super-btn-pipe' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-8'],
				]
			]
		);

		$this->add_responsive_control(
			'pipe_height',
			[
				'label' => __( 'Height', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-super-btn-stl-8 span.ha-super-btn-pipe' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-8'],
				]
			]
		);

		// $this->add_control(
		// 	'pipe_color',
		// 	[
		// 		'label' => __( 'Color', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .ha-super-btn-stl-8 span.ha-super-btn-pipe' => 'background: {{VALUE}};',
		// 		],
		// 		'condition' => [
		// 			'button_style' => ['style-8'],
		// 		]
		// 	]
		// );

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'pipe_bg',
		        'label' => __('Background', 'happy-addons-pro'),
		        'types' => ['classic', 'gradient'],
		        'exclude' => ['image'],
		        'selector' => '{{WRAPPER}} .ha-super-btn-stl-8 span.ha-super-btn-pipe',
				'condition' => [
					'button_style' => ['style-8'],
				]
		    ]
		);

		$this->add_control(
			'pipe_border_radius',
			[
				'label' => __( 'Border Radius', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-super-btn-stl-8 span.ha-super-btn-pipe' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-8'],
				]
			]
		);

	}

	// style = ['10']
	protected function __dropdown_style_controls() {

		$this->start_controls_section(
			'_super_btn_dropdown_style_control',
			[
				'label' => __( 'Dropdown', 'happy-addons-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_style' => ['style-10'],
				]
			]
		);

		$this->add_control(
			'_super_btn_dropdown_wrap',
			[
				'label' => __( 'Wrapper', 'happy-addons-pro' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'dropdown_box_width',
			[
				'label'      => __( 'Box Width', 'happy-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					// '%'  => [
					// 	'min'  => 0,
					// 	'max'  => 100,
					// 	'step' => 1,
					// ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dropdown_box_distance',
			[
				'label'      => __( 'Distance', 'happy-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 150,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .ha-super-btn-stl-10' => '--ha-super-btn-stl-10-dropdown-dstnt: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// $this->add_control(
		// 	'dropdown_wrap_background',
		// 	[
		// 		'label'     => __( 'Background', 'happy-addons-pro' ),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu' => 'background: {{VALUE}}',
		// 		],

		// 	]
		// );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'dropdown_wrap_bg',
				'label'    => __( 'Background', 'happy-addons-pro' ),
				'types'    => ['classic', 'gradient'],
				'exclude'  => ['image'],
				'selector' => '{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'dropdown_box_shadow',
				'label'    => __( 'Box Shadow', 'happy-addons-pro' ),
				'selector' => '{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'dropdown_border',
				'selector' => '{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu',
			]
		);

		$this->add_responsive_control(
			'dropdown_border_radius',
			[
				'label'      => __( 'Border Radius', 'happy-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		/* Items */
		$this->add_control(
			'_super_btn_dropdown_item_heading',
			[
				'label' => __( 'Items', 'happy-addons-pro' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'dropdown_item_typography',
				'label'     => __( 'Typography', 'happy-addons-pro' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a',
			]
		);

		$this->add_responsive_control(
			'dropdown_item_margin',
			[
				'label'      => __( 'Margin', 'happy-addons-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				// 'default'    => [
				// 	'top'    => 15,
				// 	'right'  => '',
				// 	'bottom' => 15,
				// 	'left'   => '',
				// 	'unit'   => 'px',
				// ],
				'selectors'  => [
					'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dropdown_item_padding',
			[
				'label'      => __( 'Padding', 'happy-addons-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'dropdown_item_border',
				'selector' => '{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a',
			]
		);

		$this->add_responsive_control(
			'dropdown_item_border_first_item',
			[
				'label'      => __( 'First Item Border', 'happy-addons-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a:first-of-type' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				//

				'condition' => [
					'dropdown_item_border_border!' => ['','none'],
				]
			]
		);

		$this->add_responsive_control(
			'dropdown_item_border_last_item',
			[
				'label'      => __( 'Last Item Border', 'happy-addons-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a:last-of-type' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'dropdown_item_border_border!' => ['','none'],
				]
			]
		);

		$this->start_controls_tabs(
			'dropdown_normal_tabs'
		);

		$this->start_controls_tab(
			'dropdown_normal_tab',
			[
				'label' => __( 'Normal', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'dropdown_item_color',
			[
				'label'     => __( 'Color', 'happy-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a' => 'color: {{VALUE}}',
				],

			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'dropdown_hover_tab',
			[
				'label' => __( 'Hover', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'dropdown_item_hover_color',
			[
				'label'     => __( 'Color', 'happy-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a:hover' => 'color: {{VALUE}}',
				],

			]
		);

		// $this->add_control(
		// 	'dropdown_item_hover_background',
		// 	[
		// 		'label'     => __( 'Background Color', 'happy-addons-pro' ),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a:hover' => 'background: {{VALUE}}',
		// 		],

		// 	]
		// );

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'dropdown_item_hover_bg',
		        'label' => __('Background', 'happy-addons-pro'),
		        'types' => ['classic', 'gradient'],
		        'exclude' => ['image'],
		        'selector' => '{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a:hover',
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

        /*Divider*/
        // $this->add_control(
		// 	'_super_btn_dropdown_divider_heading',
		// 	[
		// 		'label' => __( 'Divider', 'happy-addons-pro' ),
		// 		'type'  => Controls_Manager::HEADING,
		// 		'separator' => 'before',
		// 	]
		// );

        // $this->add_group_control(
		// 	Group_Control_Border::get_type(),
		// 	[
		// 		'name'     => 'super_btn_dropdown_divider_border',
		// 		'selector' => '{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu > a:not(:last-child)',
		// 	]
		// );

		/* Items Icon */
		$this->add_control(
			'_super_btn_dropdown_item_icon_heading',
			[
				'label' => __( 'Icon', 'happy-addons-pro' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'dropdown_item_icon_size',
			[
				'label'      => __( 'Icon Size', 'happy-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a .ha-super-btn-dropdown-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a .ha-super-btn-dropdown-icon svg' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dropdown_item_icon_gap',
			[
				'label'      => __( 'Space', 'happy-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// $this->add_responsive_control(
		// 	'dropdown_item_icon_margin',
		// 	[
		// 		'label'      => __( 'Margin', 'happy-addons-pro' ),
		// 		'type'       => Controls_Manager::DIMENSIONS,
		// 		'size_units' => ['px', '%'],
		// 		'selectors'  => [
		// 			'{{WRAPPER}} .ha-super-btn-stl-10 .ha-super-btn-dropdown-menu a .ha-super-btn-dropdown-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 		],
		// 	]
		// );

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		//echo "<h4>{$settings['button_style']}</h4>";
		if ( 'style-10' != $settings['button_style'] ) {
			$this->add_link_attributes( 'button_text', $settings['btn_link'] );
		}

		$style_10_cls = '';
		if (
			ha_elementor()->editor->is_edit_mode() &&
			'style-10' == $settings['button_style'] &&
			$settings['show_dropdown_on_editor'] &&
			'yes' == $settings['show_dropdown_on_editor']
		) {
			$style_10_cls = 'open';
		}

		?>

		<?php if ( 'style-1' == $settings['button_style'] && $settings['btn_text'] && ! empty( $settings['btn_icon'] ) ) :  ?>
		<!-- button style 1 start -->
		<a <?php $this->print_render_attribute_string( 'button_text' ); ?> class="ha-super-btn-stl-1">
			<span class="ha-super-btn-filter-blur">
				<svg width="0" height="0"><defs>
					<filter id="ha-super-btn-stl-1">
					<feGaussianBlur in="SourceGraphic" stdDeviation="5" result="blur"></feGaussianBlur>
					<feColorMatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9"></feColorMatrix>
					<feComposite in="SourceGraphic" in2="ha-super-btn-stl-1" operator="atop"></feComposite>
					<feBlend in="SourceGraphic" in2="ha-super-btn-stl-1"></feBlend>
					</filter>
				</defs></svg>
			</span>
			<span class="ha-super-btn-main-wrap">
				<span class="ha-super-btn-text"><?php echo esc_html( $settings['btn_text'] ); ?></span>
				<span class="ha-super-btn-icon">
					<?php if ( ! empty( $settings['btn_icon'] ) ) :
						ha_render_icon( $settings, 'icon', 'btn_icon' );
					endif; ?>
				</span>
			</span>
		</a>
		<!-- button style 1 end -->
		 <?php endif; ?>


		<?php if ( 'style-2' == $settings['button_style'] && $settings['btn_text'] && ! empty( $settings['btn_icon'] ) ) :  ?>
		<!-- button style 2 start -->
		<a <?php $this->print_render_attribute_string( 'button_text' ); ?> class="ha-super-btn-stl-2">
			<span class="ha-super-btn-icon left">
				<?php if ( ! empty( $settings['btn_icon'] ) ) :
						ha_render_icon( $settings, 'icon', 'btn_icon' );
					endif; ?>
			</span>
			<span class="ha-super-btn-text"><?php echo esc_html( $settings['btn_text'] ); ?></span>
			<span class="ha-super-btn-icon right">
				<?php if ( ! empty( $settings['btn_icon'] ) ) :
						ha_render_icon( $settings, 'icon', 'btn_icon' );
					endif; ?>
			</span>
		</a>
		<!-- button style 2 end -->
		 <?php endif; ?>


		<?php if ( 'style-3' == $settings['button_style'] && $settings['btn_text'] && ! empty( $settings['btn_icon'] ) ) :  ?>
		<!-- button style 3 start -->
		<a <?php $this->print_render_attribute_string( 'button_text' ); ?> class="ha-super-btn-stl-3">
			<span class="ha-super-btn-text">
				<span class="text-1"><?php echo esc_html( $settings['btn_text'] ); ?></span>
				<span class="text-2"><?php echo esc_html( $settings['btn_text'] ); ?></span>
			</span>
			<span class="ha-super-btn-icon">
				<?php if ( ! empty( $settings['btn_icon'] ) ) :
					ha_render_icon( $settings, 'icon', 'btn_icon' );
				endif; ?>
				<?php if ( ! empty( $settings['btn_icon'] ) ) :
					ha_render_icon( $settings, 'icon', 'btn_icon' );
				endif; ?>
			</span>
		</a>
		<!-- button style 3 end -->
		<?php endif; ?>


		<?php if ( 'style-4' == $settings['button_style'] && $settings['btn_text'] && ! empty( $settings['btn_icon'] ) ) :  ?>
		<!-- button style 4 start -->
		<a <?php $this->print_render_attribute_string( 'button_text' ); ?> class="ha-super-btn-stl-4">
			<span class="ha-super-btn-main-wrap">
				<span class="ha-super-btn-text"><?php echo esc_html( $settings['btn_text'] ); ?></span>
				<span class="ha-super-btn-icon">
					<?php if ( ! empty( $settings['btn_icon'] ) ) :
						ha_render_icon( $settings, 'icon', 'btn_icon' );
					endif; ?>
				</span>
				<span class="ha-super-btn-icon">
					<?php if ( ! empty( $settings['btn_icon'] ) ) :
						ha_render_icon( $settings, 'icon', 'btn_icon' );
					endif; ?>
				</span>
			</span>
		</a>
		<!-- button style 4 end -->
		<?php endif; ?>


		<?php if ( 'style-5' == $settings['button_style'] && $settings['btn_text'] && ! empty( $settings['btn_icon'] ) ) :  ?>
		<!-- button style 5 start -->
		<a <?php $this->print_render_attribute_string( 'button_text' ); ?> class="ha-super-btn-stl-5">
			<span class="ha-super-btn-text"><?php echo esc_html( $settings['btn_text'] ); ?></span>
			<span class="ha-super-btn-icon">
				<?php if ( ! empty( $settings['btn_icon'] ) ) :
					ha_render_icon( $settings, 'icon', 'btn_icon' );
					ha_render_icon( $settings, 'icon', 'btn_icon' );
				endif; ?>
			</span>
		</a>
		<!-- button style 5 end -->
		<?php endif; ?>


		<?php if ( 'style-6' == $settings['button_style'] && $settings['btn_text'] && ! empty( $settings['btn_icon'] ) ) :  ?>
		<!-- button style 6 start -->
		<a <?php $this->print_render_attribute_string( 'button_text' ); ?> class="ha-super-btn-stl-6">
			<span class="ha-super-btn-text">
				<span class="text-1"><?php echo esc_html( $settings['btn_text'] ); ?></span>
				<span class="text-2"><?php echo esc_html( $settings['btn_text'] ); ?></span>
			</span>
			<span class="ha-super-btn-icon">
				<span>
					<?php if ( ! empty( $settings['btn_icon'] ) ) :
						ha_render_icon( $settings, 'icon', 'btn_icon' );
						ha_render_icon( $settings, 'icon', 'btn_icon' );
					endif; ?>
				</span>
			</span>
		</a>
		<!-- button style 6 end -->
		<?php endif; ?>


		<?php if ( 'style-8' == $settings['button_style'] && $settings['btn_text'] && $settings['btn_text'] ) :  ?>
		<!-- button style 8 start -->
		<a <?php $this->print_render_attribute_string( 'button_text' ); ?> class="ha-super-btn-stl-8">
			<!-- <button class="button"> -->
			<span class="ha-super-btn-text"><?php echo esc_html( $settings['btn_text'] ); ?></span>
			<span class="ha-super-btn-pipe"></span>
			<!-- </button> -->
		</a>
		<!-- button style 8 end -->
		<?php endif; ?>


		<?php if ( 'style-9' == $settings['button_style'] && $settings['btn_text'] && ! empty( $settings['btn_icon'] ) ) :  ?>
		<!-- button style 9 start -->
		<a <?php $this->print_render_attribute_string( 'button_text' ); ?> class="ha-super-btn-stl-9">
			<span class="ha-super-btn-text"><?php echo esc_html( $settings['btn_text'] ); ?></span>
			<div class="ha-super-btn-icon-overlay">
				<span class="ha-super-btn-icon">
					<?php if ( ! empty( $settings['btn_icon'] ) ) :
						ha_render_icon( $settings, 'icon', 'btn_icon' );
					endif; ?>
				</span>
			</div>
		</a>
		<!-- button style 9 end -->
		<?php endif; ?>


		<?php if ( 'style-10' == $settings['button_style'] && is_array($settings['btn_list']) && $settings['btn_text'] && ! empty( $settings['btn_icon'] ) ) :  ?>
		<!-- button style 10 start -->
		<div class="ha-super-btn-stl-10 <?php echo esc_attr( $settings['dropdown_pos'].' '.$style_10_cls ); ?>">
			<button>
				<span class="ha-super-btn-text">
					<?php echo esc_html( $settings['btn_text'] ); ?>
				</span>
				<span class="ha-super-btn-icon arrow">
					<?php if ( ! empty( $settings['btn_icon'] ) ) :
						ha_render_icon( $settings, 'icon', 'btn_icon' );
					endif; ?>
				</span>
			</button>
			<div class="ha-super-btn-dropdown-menu ha-super-btn-dropdown-menu-layout--<?php echo esc_attr( $settings['dropdown_layout'] ); ?>">
				<?php foreach ( $settings['btn_list'] as $key => $item ) : ?>
				<?php
					$repeater_key = 'ha-super-btn-dropdown-link' . $key;
					if ( ! empty( $item['option_link']['url'] ) ) {
						$this->add_link_attributes( $repeater_key, $item['option_link'] );
					}
				?>
				<a class="ha-super-btn-dropdown-menu-item" <?php $this->print_render_attribute_string( $repeater_key ); ?>>
					<?php if ( ! empty( $item['option_icon'] ) && ! empty( $item['option_icon']['value'] ) ) : ?>
						<span class="ha-super-btn-dropdown-icon"><?php ha_render_icon( $item, false, 'option_icon' ); ?></span>
					<?php endif; ?>
					<?php if ( $item['option_text'] ) : ?>
						<span class="ha-super-btn-dropdown-text"><?php echo esc_html( $item['option_text'] ); ?></span>
					<?php endif; ?>
				</a>
				<?php endforeach; ?>
			</div>
		</div>
		<!-- button style 10 end -->
		<?php endif; ?>

		<?php
	}

	protected function render_style_1_markup() {
	}

}
