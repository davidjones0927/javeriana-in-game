<?php
/**
 * Advanced Pricing table widget class
 *
 * @package Happy_Addons
 */
namespace Happy_Addons_Pro\Widget;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Tribe\Customizer\Controls\Separator;

defined( 'ABSPATH' ) || die();

class Advanced_Pricing_Table extends Base {

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Advanced Pricing Table', 'happy-addons-pro' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'hm hm-invoice';
	}

	public function get_keywords() {
		return [ 'advanced',  'price',  'pricing', 'table', 'package', 'product', 'plan' ];
	}

	public function get_custom_help_url() {
		return 'https://happyaddons.com/docs/happy-addons-for-elementor-pro/happy-effects-pro/advanced-pricing-table/';
	}

	/**
     * Register widget content controls
     */
	protected function register_content_controls() {
		$this->__header_content_controls();
		$this->__repeater_fields();
		$this->__options_fields();
		$this->__footer_content_controls();
	}

	protected function __header_content_controls() {

		$this->start_controls_section(
			'_section_header',
			[
				'label' => __( 'Header', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'happy-addons-pro' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'default' => __( 'For single sites', 'happy-addons-pro' ),
				'dynamic' => [
					'active' => true
				]
			]
		);

		$this->add_control(
			'sub_title',
			[
				'label' => __( 'Sub Title', 'happy-addons-pro' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'Insert a brief explanation of what this plan is ideal for.', 'happy-addons-pro' ),
				'dynamic' => [
					'active' => true
				]
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'   => __( 'Title HTML Tag', 'happy-addons-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'h1' => [
						'title' => __( 'H1', 'happy-addons-pro' ),
						'icon'  => 'eicon-editor-h1',
					],
					'h2' => [
						'title' => __( 'H2', 'happy-addons-pro' ),
						'icon'  => 'eicon-editor-h2',
					],
					'h3' => [
						'title' => __( 'H3', 'happy-addons-pro' ),
						'icon'  => 'eicon-editor-h3',
					],
					'h4' => [
						'title' => __( 'H4', 'happy-addons-pro' ),
						'icon'  => 'eicon-editor-h4',
					],
					'h5' => [
						'title' => __( 'H5', 'happy-addons-pro' ),
						'icon'  => 'eicon-editor-h5',
					],
					'h6' => [
						'title' => __( 'H6', 'happy-addons-pro' ),
						'icon'  => 'eicon-editor-h6',
					],
				],
				'default' => 'h2',
				'toggle'  => false,
			]
		);


		/* $this->add_control(
			'media_type',
			[
				'label' => __( 'Media Type', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'separator' => 'before',
				'options' => [
					'icon' => [
						'title' => __( 'Icon', 'happy-addons-pro' ),
						'icon' => 'eicon-star',
					],
					'image' => [
						'title' => __( 'Image', 'happy-addons-pro' ),
						'icon' => 'eicon-image',
					],
				],
				'default' => 'icon',
				'toggle' => false,
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'happy-addons-pro' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-place-of-worship',
					'library' => 'solid',
				],
				'condition' => [
					'media_type' => 'icon'
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Image', 'happy-addons-pro' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'media_type' => 'image'
				],
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'media_thumbnail',
				'default' => 'full',
				'separator' => 'none',
				'exclude' => [
					'custom',
				],
				'condition' => [
					'media_type' => 'image'
				]
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label' => __( 'Position', 'happy-addons-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'before_header',
				'options' => [
					'after_header'  => __( 'After Title', 'happy-addons-pro' ),
					'before_header'  => __( 'Before Title', 'happy-addons-pro' ),
				],
				'style_transfer' => true,
			]
		); */

		$this->end_controls_section();
	}

	protected function __options_fields() {

		$this->start_controls_section(
			'_section_pricing_options',
			[
				'label' => __( 'Options', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'currency_type',
			[
				'label' => __( 'Currency Type', 'happy-addons-pro' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => false,
				'options' => [
					'static' => __( 'Static', 'happy-addons-pro' ),
					'daynamic' => __( 'Dynamic', 'happy-addons-pro' ),
				],
				'default' => 'static',
			]
		);

		$this->add_control(
			'currency_symbol',
			[
				'label' => __( 'Currency Symbol', 'happy-addons-pro' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => $this->get_currency_symbol_list(),
				'default' => 'US',
				'condition' => [
					'currency_type' => 'static',
				],
			]
		);

		$this->add_control(
			'country',
			[
				'label' => __( 'Country', 'happy-addons-pro' ),
				'description' => __( 'Default value is all country. but you can select specefic country', 'happy-addons-pro' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => [
					'all' => __( 'All Country', 'happy-addons-pro' ),
					'include' => __( 'Include Country', 'happy-addons-pro' ),
					'exclude' => __( 'Exclude Country', 'happy-addons-pro' ),
				],
				'default' => 'all',
				'condition' => [
					'currency_type' => 'daynamic',
				],
			]
		);

		$country_list = $this->get_country_list();
		array_shift( $country_list );
		$this->add_control(
			'country_include',
			[
				'label' => __( 'Include Country', 'happy-addons-pro' ),
				// 'description' => __( 'Default value is all country. but you can select specefic country', 'happy-addons-pro' ),
				'type' => Controls_Manager::SELECT2,
				'show_label' => true,
				'label_block' => true,
				'multiple'    => true,
				'options' => $country_list,
				'default' => '',
				'condition' => [
					'currency_type' => 'daynamic',
					'country' => 'include',
				],
			]
		);

		$this->add_control(
			'country_exclude',
			[
				'label' => __( 'Exclude Country', 'happy-addons-pro' ),
				// 'description' => __( 'Default value is all country. but you can select specefic country', 'happy-addons-pro' ),
				'type' => Controls_Manager::SELECT2,
				'show_label' => true,
				'label_block' => true,
				'multiple'    => true,
				'options' => $country_list,
				'default' => '',
				'condition' => [
					'currency_type' => 'daynamic',
					'country' => 'exclude',
				],
			]
		);

		// $this->add_control(
		// 	'country_currency',
		// 	[
		// 		'label' => __( 'Country', 'happy-addons-pro' ),
		// 		'description' => __( 'Default value is all country. but you can select specefic country', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::SELECT2,
		// 		'label_block' => true,
		// 		'multiple'    => true,
		// 		'options' => $this->get_country_list(),
		// 		'default' => '',
		// 		'condition' => [
		// 			'currency_type' => 'daynamic',
		// 		],
		// 	]
		// );

		$this->add_control(
			'selected_icon',
			[
				'label' => __( 'Feature Icon', 'happy-addons-pro' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'skin' => 'inline',
				'exclude_inline_options' => [ 'svg' ],

				//'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-check',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-regular' => [
						'check-square',
						'window-close',
					],
					'fa-solid' => [
						'check',
					]
				]
			]
		);

		$this->add_control(
			'slider_style',
			[
				'label' => __( 'Range Slider', 'happy-addons-pro' ),
				'description' => __( 'To use slider, you have to use more then one repeater', 'happy-addons-pro' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'multiple'    => true,
				'options' => [
					'style-1' => __( 'Slider 1', 'happy-addons-pro' ),
					'style-2' => __( 'Slider 2', 'happy-addons-pro' ),
					'style-3' => __( 'Slider 3', 'happy-addons-pro' ),
					'style-4' => __( 'Slider 4', 'happy-addons-pro' ),
					'style-5' => __( 'Slider 5', 'happy-addons-pro' ),
				],
				'default' => 'style-1'
			]
		);

		$this->add_control(
			'currency_symbol_hide',
			[
				'type'         => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Hide Currency Symbol?', 'happy-addons-pro' ),
				'label_on'     => esc_html__( 'Yes', 'happy-addons-pro' ),
				'label_off'    => esc_html__( 'No', 'happy-addons-pro' ),
				'return_value' => 'yes',
				'default'      => '',
				'selectors_dictionary' => [
					// '' => '',
					'yes' => 'display:none',
				],
				'selectors'    => [
					'{{WRAPPER}} .ha-adv-pricing-table-price-currency-icon' => '{{VALUE}}'
				]
			]
		);

		$this->add_control(
			'currency_code_hide',
			[
				'type'         => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Hide Currency Code?', 'happy-addons-pro' ),
				'label_on'     => esc_html__( 'Yes', 'happy-addons-pro' ),
				'label_off'    => esc_html__( 'No', 'happy-addons-pro' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'selectors_dictionary' => [
					'yes' => 'display:none',
				],
				'selectors'    => [
					'{{WRAPPER}} .ha-adv-pricing-table-price-currency-name' => '{{VALUE}}'
				]
			]
		);

		$this->add_control(
			'button_pos',
			[
				'label' => __( 'Button Placement', 'happy-addons-pro' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => false,
				'options' => [
					'after-price' => __( 'After Price', 'happy-addons-pro' ),
					'after-slider' => __( 'After Slider', 'happy-addons-pro' ),
					'after-feature' => __( 'After Feature', 'happy-addons-pro' ),
				],
				'default' => 'after-feature',
			]
		);

		$this->end_controls_section();

	}

	protected function __repeater_fields() {

		$this->start_controls_section(
			'_section_pricing',
			[
				'label' => __( 'Pricing', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		// $this->add_control(
		// 	'currency_type',
		// 	[
		// 		'label' => __( 'Currency Type', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'label_block' => false,
		// 		'options' => [
		// 			'static' => __( 'Static', 'happy-addons-pro' ),
		// 			'daynamic' => __( 'Dynamic', 'happy-addons-pro' ),
		// 		],
		// 		'default' => 'daynamic',
		// 	]
		// );

		// $this->add_control(
		// 	'currency_symbol',
		// 	[
		// 		'label' => __( 'Currency Symbol', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'label_block' => true,
		// 		'options' => $this->get_currency_symbol_list(),
		// 		'default' => 'US',
		// 		'condition' => [
		// 			'currency_type' => 'static',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'country',
		// 	[
		// 		'label' => __( 'Country', 'happy-addons-pro' ),
		// 		'description' => __( 'Default value is all country. but you can select specefic country', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'label_block' => true,
		// 		'options' => [
		// 			'all' => __( 'All Country', 'happy-addons-pro' ),
		// 			'include' => __( 'Include Country', 'happy-addons-pro' ),
		// 			'exclude' => __( 'Exclude Country', 'happy-addons-pro' ),
		// 		],
		// 		'default' => 'all',
		// 		'condition' => [
		// 			'currency_type' => 'daynamic',
		// 		],
		// 	]
		// );

		// $country_list = $this->get_country_list();
		// array_shift( $country_list );
		// $this->add_control(
		// 	'country_include',
		// 	[
		// 		'label' => __( 'Include Country', 'happy-addons-pro' ),
		// 		// 'description' => __( 'Default value is all country. but you can select specefic country', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::SELECT2,
		// 		'show_label' => true,
		// 		'label_block' => true,
		// 		'multiple'    => true,
		// 		'options' => $country_list,
		// 		'default' => '',
		// 		'condition' => [
		// 			'currency_type' => 'daynamic',
		// 			'country' => 'include',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'country_exclude',
		// 	[
		// 		'label' => __( 'Exclude Country', 'happy-addons-pro' ),
		// 		// 'description' => __( 'Default value is all country. but you can select specefic country', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::SELECT2,
		// 		'show_label' => true,
		// 		'label_block' => true,
		// 		'multiple'    => true,
		// 		'options' => $country_list,
		// 		'default' => '',
		// 		'condition' => [
		// 			'currency_type' => 'daynamic',
		// 			'country' => 'exclude',
		// 		],
		// 	]
		// );

		// // $this->add_control(
		// // 	'country_currency',
		// // 	[
		// // 		'label' => __( 'Country', 'happy-addons-pro' ),
		// // 		'description' => __( 'Default value is all country. but you can select specefic country', 'happy-addons-pro' ),
		// // 		'type' => Controls_Manager::SELECT2,
		// // 		'label_block' => true,
		// // 		'multiple'    => true,
		// // 		'options' => $this->get_country_list(),
		// // 		'default' => '',
		// // 		'condition' => [
		// // 			'currency_type' => 'daynamic',
		// // 		],
		// // 	]
		// // );

		// $this->add_control(
		// 	'selected_icon',
		// 	[
		// 		'label' => __( 'Feature Icon', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::ICONS,
		// 		'label_block' => true,
		// 		'skin' => 'inline',
		// 		'exclude_inline_options' => [ 'svg' ],

		// 		//'fa4compatibility' => 'icon',
		// 		'default' => [
		// 			'value' => 'fas fa-check',
		// 			'library' => 'fa-solid',
		// 		],
		// 		'recommended' => [
		// 			'fa-regular' => [
		// 				'check-square',
		// 				'window-close',
		// 			],
		// 			'fa-solid' => [
		// 				'check',
		// 			]
		// 		]
		// 	]
		// );

		// $this->add_control(
		// 	'slider_style',
		// 	[
		// 		'label' => __( 'Range Slider', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'label_block' => true,
		// 		'multiple'    => true,
		// 		'options' => [
		// 			'style-1' => __( 'Slider 1', 'happy-addons-pro' ),
		// 			'style-2' => __( 'Slider 2', 'happy-addons-pro' ),
		// 			'style-3' => __( 'Slider 3', 'happy-addons-pro' ),
		// 		],
		// 		'default' => 'style-1'
		// 	]
		// );


		$repeater = new Repeater();

		$repeater->add_control(
			'plan_name',
			[
				'label'       => __( 'Plan Name', 'happy-addons-pro' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Plan Name', 'happy-addons-pro' ),
				'default' => __( 'Single 20GB', 'happy-addons-pro' ),
				// 'dynamic'     => [
				// 	'active' => true,
				// ],
				// 'condition'   => [
				// 	'content_type' => ['text','heading'],
				// ],
			]
		);

		$repeater->add_control(
			'price',
			[
				'label' => __( 'Price', 'happy-addons-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => '9.99',
				'dynamic' => [
					'active' => true
				]
			]
		);

		$repeater->add_control(
			'original_price',
			[
				'label' => __( 'Original Price', 'happy-addons-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => '8.99',
				'dynamic' => [
					'active' => true
				]
			]
		);

		$repeater->add_control(
			'period',
			[
				'label' => __( 'Period', 'happy-addons-pro' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'for the first month', 'happy-addons-pro' ),
				'dynamic' => [
					'active' => true
				]
			]
		);

		$repeater->add_control(
			'plan_related_icon',
			[
				'label' => __( 'Plan Tips Icon', 'happy-addons-pro' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'skin' => 'inline',
				'exclude_inline_options' => [ 'svg' ],
				//'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'huge huge-percent-circle',
					'library' => 'huge-icons',
				],
				'recommended' => [
					'fa-regular' => [
						'check-square',
						'window-close',
					],
					'fa-solid' => [
						'check',
					]
				]
			]
		);

		$repeater->add_control(
			'plan_related_text',
			[
				'label'       => __( 'Plan Tips', 'happy-addons-pro' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Plan Tips', 'happy-addons-pro' ),
				'default' => __( 'Best for single site', 'happy-addons-pro' ),
				// 'dynamic'     => [
				// 	'active' => true,
				// ],
				// 'condition'   => [
				// 	'content_type' => ['text','heading'],
				// ],
			]
		);

		$repeater->add_control(
			'features_desc',
			[
				'label' => __( 'Features', 'happy-addons-pro' ),
				'description' => __( 'Separate feature keys from tooltip using the | (pipe) character. Separate feature-tooltip pairs with a ~(tilde sign).', 'happy-addons-pro' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 10,
				'placeholder' => __( 'feature|tooltip', 'happy-addons-pro' ),
				'default' => __( 'Standard Feature~Another Great Feature|It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.~Obsolete Feature~Exciting Feature', 'happy-addons-pro' ),
				// 'dynamic' => [
				// 	'active' => true
				// ]
			]
		);

		// $repeater->add_control(
		// 	'features_desc',
		// 	[
		// 		'label'       => __( 'Features Description', 'happy-addons-pro' ),
		// 		'type'        => Controls_Manager::WYSIWYG,
		// 		'label_block' => true,
		// 		'placeholder' => __( 'Type your description here', 'happy-addons-pro' ),
		// 		// 'default' => __( 'Single 20GB', 'happy-addons-pro' ),
		// 		// 'dynamic'     => [
		// 		// 	'active' => true,
		// 		// ],
		// 		// 'condition'   => [
		// 		// 	'content_type' => ['text','heading'],
		// 		// ],
		// 	]
		// );

		// Button Content Start
		$repeater->add_control(
			'button_text',
			[
				'label'       => __( 'Button Title', 'happy-addons-pro' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Buy Now', 'happy-addons-pro' ),
				'placeholder' => __( 'Type your title here', 'happy-addons-pro' ),
				// 'condition'   => [
				// 	'content_type'    => 'button',
				// ],
			]
		);

		$repeater->add_control(
			'button_link',
			[
				'label'         => __( 'Link', 'happy-addons-pro' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'happy-addons-pro' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
				'dynamic' => [
					'active' => true,
				],
				// 'condition'   => [
				// 	'content_type'    => 'button',
				// ],
			]
		);

		// Price Content Start
		// $repeater->add_control(
		// 	'currency',
		// 	[
		// 		'label' => __( 'Currency', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'label_block' => false,
		// 		'options' => [
		// 			''             => __( 'None', 'happy-addons-pro' ),
		// 			'baht'         => '&#3647; ' . _x( 'Baht', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'bdt'          => '&#2547; ' . _x( 'BD Taka', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'dollar'       => '&#36; ' . _x( 'Dollar', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'euro'         => '&#128; ' . _x( 'Euro', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'franc'        => '&#8355; ' . _x( 'Franc', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'guilder'      => '&fnof; ' . _x( 'Guilder', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'krona'        => 'kr ' . _x( 'Krona', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'lira'         => '&#8356; ' . _x( 'Lira', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'peseta'       => '&#8359 ' . _x( 'Peseta', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'peso'         => '&#8369; ' . _x( 'Peso', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'pound'        => '&#163; ' . _x( 'Pound Sterling', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'real'         => 'R$ ' . _x( 'Real', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'ruble'        => '&#8381; ' . _x( 'Ruble', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'rupee'        => '&#8360; ' . _x( 'Rupee', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'indian_rupee' => '&#8377; ' . _x( 'Rupee (Indian)', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'shekel'       => '&#8362; ' . _x( 'Shekel', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'won'          => '&#8361; ' . _x( 'Won', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'yen'          => '&#165; ' . _x( 'Yen/Yuan', 'Currency Symbol', 'happy-addons-pro' ),
		// 			'custom'       => __( 'Custom', 'happy-addons-pro' ),
		// 		],
		// 		'default' => 'dollar',
		// 		'dynamic'     => [
		// 			'active' => true,
		// 		],
		// 		// 'condition'   => [
		// 		// 	'content_type' => 'price',
		// 		// ],
		// 	]
		// );

		// return $repeater;

		$this->add_control(
			'price_data',
			[
				'type'         => Controls_Manager::REPEATER,
				'fields'       => $repeater->get_controls(),
				'item_actions' => [
					'sort' => true,
				],
				'default'      => $this->default_value(),
				'title_field'  => '{{{ plan_name }}}',
				'max_items' => 10,
			]
		);

		$this->end_controls_section();

	}

	protected function default_value() {

		$default_value = [
			[
				'plan_name'     => __( 'Single 20GB', 'happy-addons-pro' ),
				'price'     => '0',
				'original_price'     => '30',
				'period'     => __( 'for the first month', 'happy-addons-pro' ),
				'plan_related_text'     => __( 'Pay 0 today for the first month', 'happy-addons-pro' ),
				'features_desc'     => __( '1 WordPress install~20GB Server bandwidth~125GB CDN bandwidth|CDN option you will have, which will help to speed optiomization~10GB Storage~Free migration|You dont have to migrate menually, it will be automatic.~14 days backup retention', 'happy-addons-pro' ),
				'button_text'     => __( 'Try Free', 'happy-addons-pro' ),
				'button_link'     => [
					'url'         => 'https://happyaddons.com/login/',
					'is_external' => true,
					'nofollow'    => true,
				],

			],
			[
				'plan_name'     => __( 'Single 40GB', 'happy-addons-pro' ),
				'price'     => '42',
				'original_price'     => '',
				'period'     => __( ' / month', 'happy-addons-pro' ),
				'plan_related_text'     => __( 'Good for single site', 'happy-addons-pro' ),
				'features_desc'     => __( '1 WordPress install~40GB Server bandwidth~250GB CDN bandwidth|CDN option you will have, which will help to speed optiomization~10GB Storage~Free migration|You dont have to migrate menually, it will be automatic.~14 days backup retention~', 'happy-addons-pro' ),
				'button_text'     => __( 'Sign Up', 'happy-addons-pro' ),
				'button_link'     => [
					'url'         => 'https://happyaddons.com/pricing/',
					'is_external' => true,
					'nofollow'    => true,
				]

			],
			[
				'plan_name'     => __( 'Single 65GB', 'happy-addons-pro' ),
				'price'     => '75',
				'original_price'     => '80',
				'period'     => __( ' / month', 'happy-addons-pro' ),
				'plan_related_text'     => __( 'Best for single site', 'happy-addons-pro' ),
				'features_desc'     => __( '1 WordPress install~65GB Server bandwidth~500GB CDN bandwidth|CDN option you will have, which will help to speed optiomization~10GB Storage~Free migration|You dont have to migrate menually, it will be automatic.~14 days backup retention~', 'happy-addons-pro' ),
				'button_text'     => __( 'Buy Now', 'happy-addons-pro' ),
				'button_link'     => [
					'url'         => 'https://happyaddons.com',
					'is_external' => true,
					'nofollow'    => true,
				]

			]
		];

		return $default_value;
	}

	protected function __footer_content_controls() {

		$this->start_controls_section(
			'_section_footer',
			[
				'label' => __( 'Footer', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		// $this->add_control(
		// 	'button_text',
		// 	[
		// 		'label' => __( 'Button Text', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::TEXT,
		// 		'default' => __( 'Subscribe', 'happy-addons-pro' ),
		// 		'placeholder' => __( 'Type button text here', 'happy-addons-pro' ),
		// 		'label_block' => false,
		// 		'dynamic' => [
		// 			'active' => true
		// 		]
		// 	]
		// );

		// $this->add_control(
		// 	'button_link',
		// 	[
		// 		'label' => __( 'Link', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::URL,
		// 		'label_block' => true,
		// 		'placeholder' => 'https://happyaddons.com/',
		// 		'default' => [
		// 			'url' => '#'
		// 		],
		// 		'dynamic' => [
		// 			'active' => true,
		// 		],
		// 	]
		// );

		$this->add_control(
			'footer_desc',
			[
				'label' => __( 'Footer Description', 'happy-addons-pro' ),
				'show_label' => true,
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	/**
     * Register widget style controls
     */
	protected function register_style_controls() {
		// $this->__general_style_controls();
		$this->__header_style_controls();
		$this->__plan_name_style_controls();
		$this->__pricing_style_controls();
		$this->__plan_related_text_style_controls();
		$this->__slider_style_1_controls();
		$this->__slider_style_2_controls();
		$this->__slider_style_3_controls();
		$this->__slider_style_4_controls();
		$this->__slider_style_5_controls();
		$this->__features_desc_style_controls();
		$this->__tooltip_style_controls();
		$this->__button_style_controls();
		$this->__footer_style_controls();
	}

	protected function __general_style_controls() {

		$this->start_controls_section(
			'_section_style_general',
			[
				'label' => __( 'General', 'happy-addons-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-pricing-table-icon,'
					. '{{WRAPPER}} .ha-pricing-table-title,'
					. '{{WRAPPER}} .ha-pricing-table-currency,'
					. '{{WRAPPER}} .ha-pricing-table-period,'
					. '{{WRAPPER}} .ha-pricing-table-features-title,'
					. '{{WRAPPER}} .ha-pricing-table-features-list li,'
					. '{{WRAPPER}} .ha-pricing-table-price-text,'
					. '{{WRAPPER}} .ha-pricing-table-description,'
					. '{{WRAPPER}} .ha-pricing-table-footer-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overflow',
			[
				'label' => __( 'Overflow', 'happy-addons-pro' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => false,
				'options' => [
					'' => __( 'Default', 'happy-addons-pro' ),
					'hidden' => __( 'Hidden', 'happy-addons-pro' ),
				],
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} > .elementor-widget-container' => 'overflow: {{VALUE}}',
					'{{WRAPPER}}:not(:has(.elementor-widget-container))' => 'overflow: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __header_style_controls() {

		$this->start_controls_section(
			'_section_style_header',
			[
				'label' => __( 'Header', 'happy-addons-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'header_area_header',
			[
				'label' => __( 'Container', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'header_area_padding',
			[
				'label' => __( 'Padding', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'header_area_background',
				'label' => __( 'Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-header',
			]
		);

		$this->add_control(
			'header_area_alignment',
			[
				'label' => __( 'Alignment', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-header' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'header_area_title',
			[
				'label' => __( 'Title', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'header_title_color',
			[
				'label' => __( 'Title Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'header_title_typography',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-title',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'header_title_margin',
			[
				'label' => __( 'Margin', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'header_area_subtitle',
			[
				'label' => __( 'Subtitle', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'header_subtitle_color',
			[
				'label' => __( 'Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'header_subtitle_typography',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-subtitle',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'header_subtitle_margin',
			[
				'label' => __( 'Margin', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();
	}

	protected function __plan_name_style_controls() {

		$this->start_controls_section(
			'_section_style_pricing_plan',
			[
				'label' => __( 'Plan', 'happy-addons-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pricing_plan_color',
			[
				'label' => __( 'Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-plan-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_plan_typography',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-plan-name',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'pricing_plan_margin',
			[
				'label' => __( 'Margin', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-plan-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pricing_plan_alignment',
			[
				'label' => __( 'Alignment', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-plan-name' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __pricing_style_controls() {

		$this->start_controls_section(
			'_section_style_pricing',
			[
				'label' => __( 'Pricing', 'happy-addons-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'_header_pricing_area',
			[
				'label' => __( 'Pricing Area', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'pricing_area_padding',
			[
				'label' => __( 'Padding', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-price-display' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'pricing_area_background',
				'label' => __( 'Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-price-display',
			]
		);

		$this->add_responsive_control(
			'price_area_spacing',
			[
				'label' => __( 'Bottom Spacing', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-price-display' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'price_area_alignment',
			[
				'label' => __( 'Alignment', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-price-display' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_heading_price',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Price', 'happy-addons-pro' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-current-price' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-adv-pricing-table-period-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-current-price',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_control(
			'_heading_currency',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Currency', 'happy-addons-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'currency_spacing',
			[
				'label' => __( 'Side Spacing', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-price-currency-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					// '{{WRAPPER}} .ha-pricing-table-currency.right-pos' => 'margin-left: {{SIZE}}{{UNIT}};margin-right:0;',
				],
			]
		);

		$this->add_responsive_control(
			'currency_position',
			[
				'label' => __( 'Position', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-current-price .ha-adv-pricing-table-price-currency-icon' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'currency_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-current-price .ha-adv-pricing-table-price-currency-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'currency_typography',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-current-price .ha-adv-pricing-table-price-currency-icon',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_control(
			'_heading_original_price',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Original Price', 'happy-addons-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'original_price_spacing',
			[
				'label' => __( 'Side Spacing', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-period-text' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'original_price_position',
			[
				'label' => __( 'Position', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					]
				],
				'selectors' => [
					// '{{WRAPPER}} .ha-pricing-table-original-price .ha-pricing-table-currency,'
				   '{{WRAPPER}} .ha-adv-pricing-table-original-price' => 'top: {{SIZE}}{{UNIT}};position:relative;',
				],
			]
		);


		$this->add_control(
			'original_price_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-original-price' => 'color: {{VALUE}};',
					// '{{WRAPPER}} .ha-pricing-table-original-price .ha-pricing-table-price-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'original_price_typography',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-original-price span',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_control(
			'_heading_period',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Period', 'happy-addons-pro' ),
				'separator' => 'before',
			]
		);

		// $this->add_responsive_control(
		// 	'period_spacing',
		// 	[
		// 		'label' => __( 'Bottom Spacing', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::SLIDER,
		// 		'size_units' => ['px'],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .ha-adv-pricing-table-period-text .ha-adv-pricing-table-currency-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
		// 		],
		// 	]
		// );

		$this->add_responsive_control(
			'period_position',
			[
				'label' => __( 'Position', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					]
				],
				'selectors' => [
				   '{{WRAPPER}} .ha-adv-pricing-table-period-text .ha-adv-pricing-table-currency-text' => 'top: {{SIZE}}{{UNIT}};position:relative;',
				],
			]
		);

		$this->add_control(
			'period_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-period-text .ha-adv-pricing-table-currency-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'period_typography',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-period-text .ha-adv-pricing-table-currency-text',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __plan_related_text_style_controls() {

		$this->start_controls_section(
			'_section_style_plan_related_text',
			[
				'label' => __( 'Plan Tips', 'happy-addons-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'plan_related_text_padding',
			[
				'label' => __( 'Padding', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-price-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'plan_related_text_border_radius',
			[
				'label' => __( 'Border Radius', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-price-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'plan_related_text_tooltip_border',
				'label' => __( 'Border', 'happy-addons-pro' ),
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-price-text',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'plan_related_text_tooltip_background',
				'label' => __( 'Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-price-text',
				'separator' => 'before',
				'exclude' => [
					'image',
				],
			]
		);

		$this->add_control(
			'plan_related_text_tooltip_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-price-text span' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'plan_related_text_tooltip_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-price-text span',
			]
		);

		$this->add_control(
			'_heading_plan_related_icon',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Icon', 'happy-addons-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'plan_related_icon_color',
			[
				'label' => __( 'Icon Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-price-text i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'plan_related_icon_size',
			[
				'label' => __( 'Size', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-price-text i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'plan_related_icon_spacing',
			[
				'label'                 => __( 'Icon Spacing', 'happy-addons-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px' 	=> [
						'max' => 50,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .ha-adv-pricing-table-price-text i' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __features_desc_style_controls() {

		$this->start_controls_section(
			'_section_style_features',
			[
				'label' => __( 'Features', 'happy-addons-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'_heading_features',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Features Container', 'happy-addons-pro' ),
			]
		);

		$this->add_responsive_control(
			'features_container_height',
			[
				'label' => __( 'Height', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-features-wrap' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'features_container_spacing',
			[
				'label' => __( 'Bottom Spacing', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-features-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'features_container_padding',
			[
				'label' => __( 'Padding', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-features-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'_heading_features_list',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'List', 'happy-addons-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'features_list_spacing',
			[
				'label' => __( 'Spacing Between', 'happy-addons-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-features-wrap ul > li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'features_list_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-features-wrap ul > li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'features_list_icon_color',
			[
				'label' => __( 'Icon Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-features-wrap ul > li i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'features_list_typography',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-features-wrap ul > li',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __tooltip_style_controls() {

		$this->start_controls_section(
			'_section_style_tooltip',
			[
				'label' => __( 'Features Tooltip', 'happy-addons-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'price_tooltip_padding',
			[
				'label' => __( 'Padding', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-feature-tooltip-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'price_tooltip_border_radius',
			[
				'label' => __( 'Border Radius', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-feature-tooltip-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'price_tooltip_border',
				'label' => __( 'Border', 'happy-addons-pro' ),
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-feature-tooltip-text',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'price_tooltip_background',
				'label' => __( 'Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-feature-tooltip-text',
				'separator' => 'before',
				'exclude' => [
					'image',
				],
			]
		);

		$this->add_control(
			'price_tooltip_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-feature-tooltip-text' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_tooltip_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-feature-tooltip-text',
			]
		);

		$this->end_controls_section();
	}

	protected function __button_style_controls() {

		$this->start_controls_section(
			'_section_style_button',
			[
				'label' => __( 'Button', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// $this->add_control(
		// 	'_heading_button',
		// 	[
		// 		'type' => Controls_Manager::HEADING,
		// 		'label' => __( 'Button', 'happy-addons-pro' ),
		// 	]
		// );

		// $this->add_responsive_control(
		// 	'button_width',
		// 	[
		// 		'label' => __( 'Width', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::SLIDER,
		// 		'size_units' => ['%'],
		// 		'range' => [
		// 			'%' => [
		// 				'min' => 0,
		// 				'max' => 100,
		// 			]
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .ha-pricing-table-btn' => 'width: {{SIZE}}%; text-align: center;',
		// 		],
		// 	]
		// );

		$this->add_responsive_control(
			'button_margin',
			[
				'label' => __( 'Margin', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-btn-area a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => __( 'Padding', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-btn-area a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-btn-area a',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-btn-area a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-btn-area a',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-btn-area a',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
			]
		);

		// $this->add_responsive_control(
		// 	'button_translate_y',
		// 	[
		// 		'label' => __( 'Offset Y', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::SLIDER,
		// 		'size_units' => ['px'],
		// 		'range' => [
		// 			'px' => [
		// 				'min' => -1000,
		// 				'max' => 1000,
		// 			]
		// 		],
		// 		'render_type' => 'ui',
		// 		'selectors' => [
		// 			'{{WRAPPER}} .ha-pricing-table-btn' => '--pricing-table-btn-translate-y: {{SIZE}}{{UNIT}};',
		// 		]
		// 	]
		// );

		// $this->add_control(
		// 	'hr',
		// 	[
		// 		'type' => Controls_Manager::DIVIDER,
		// 		'style' => 'thick',
		// 	]
		// );

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
					'{{WRAPPER}} .ha-adv-pricing-table-btn-area a' => 'color: {{VALUE}};',
				],
			]
		);

		// $this->add_control(
		// 	'button_bg_color',
		// 	[
		// 		'label' => __( 'Background Color', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .ha-adv-pricing-table-btn-area a' => 'background-color: {{VALUE}};',
		// 		],
		// 	]
		// );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_bg_color',
                'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
                'selector' => '{{WRAPPER}} .ha-adv-pricing-table-btn-area a',
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
					'{{WRAPPER}} .ha-adv-pricing-table-btn-area a:hover, {{WRAPPER}} .ha-adv-pricing-table-btn-area a:focus' => 'color: {{VALUE}};',
				],
			]
		);

		// $this->add_control(
		// 	'button_hover_bg_color',
		// 	[
		// 		'label' => __( 'Background Color', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .ha-adv-pricing-table-btn-area a:hover, {{WRAPPER}} .ha-adv-pricing-table-btn-area a:focus' => 'background-color: {{VALUE}};',
		// 		],
		// 	]
		// );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_hover_bg_color',
                'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
                'selector' => '{{WRAPPER}} .ha-adv-pricing-table-btn-area a:hover, {{WRAPPER}} .ha-adv-pricing-table-btn-area a:focus',
            ]
        );

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-btn-area a:hover, {{WRAPPER}} .ha-adv-pricing-table-btn-area a:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'button_alignment',
			[
				'label' => __( 'Alignment', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'separator' => 'before',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'happy-addons-pro' ),
						'icon' => 'eicon-text-align-right',
					]
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-btn-area' => 'text-align: {{VALUE}}'
				]
			]
		);

		$this->end_controls_section();
	}

	protected function __footer_style_controls() {

		$this->start_controls_section(
			'_section_style_footer',
			[
				'label' => __( 'Footer Description', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'footer_description_margin',
			[
				'label' => __( 'Margin', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-footer-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'footer_description_padding',
			[
				'label' => __( 'Padding', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-footer-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'footer_description_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-footer-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'footer_description_typography',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-footer-desc',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __slider_style_1_controls() {

		$this->start_controls_section(
			'_section_style_slider_style_1',
			[
				'label' => __( 'Slider', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'slider_style' => 'style-1'
				],
			]
		);

		$this->add_control(
			'style_1_slider_container_bg',
			[
				'label' => __( 'Container Background', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-1' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style_1_slider_container_border_color',
			[
				'label' => __( 'Container Border Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-1' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style_1_slider_pointer_bg',
			[
				'label' => __( 'Pointer Background', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-1 .ha-adv-pricing-table-slider-thumb' => 'background: {{VALUE}};',
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-1 .ha-adv-pricing-table-slider-dot.active span' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style_1_slider_pointer_shadow_bg',
			[
				'label' => __( 'Pointer Shadow Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-1 .ha-adv-pricing-table-slider-thumb span' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style_1_slider_pointer_color',
			[
				'label' => __( 'Pointer Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-1 .ha-adv-pricing-table-slider-thumb span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-1 .ha-adv-pricing-table-slider-thumb i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style_1_slider_dot_bg',
			[
				'label' => __( 'Dot Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-1 .ha-adv-pricing-table-slider-dot span' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __slider_style_2_controls() {

		$this->start_controls_section(
			'_section_style_slider_style_2',
			[
				'label' => __( 'Slider', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'slider_style' => 'style-2'
				],
			]
		);

		$this->add_control(
			'_header_style_2_slider_container',
			[
				'label' => __( 'Container Area', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'style_2_slider_container_size',
			[
				'label'       => __( 'Slider Size', 'happy-addons-pro' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1,
				'min'         => .5,
				'max'         => 1.5,
				'step'         => .1,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-2' => '--ha-adv-price-tbl-slider-style-2: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'style_2_slider_container_typography',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-2 .rangeslider__ruler',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'style_2_slider_container_txt_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-2 .rangeslider__ruler' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'style_2_slider_container_bg',
				'label' => __( 'Container Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-2 .rangeslider',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'style_2_slider_container_box_shadow',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-2 .rangeslider',
			]
		);

		$this->add_responsive_control(
			'style_2_slider_container_margin',
			[
				'label' => __( 'Margin', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'_header_style_2_slider_active_container',
			[
				'label' => __( 'Fill Area', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'style_2_slider_active_container_bg',
				'label' => __( 'Container Fill Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-2 .rangeslider__fill',
			]
		);

		$this->add_control(
			'_header_style_2_slider_pointer',
			[
				'label' => __( 'Pointer', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'style_2_slider_pointer_bg',
				'label' => __( 'Pointer Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-2 .rangeslider .rangeslider__handle',
			]
		);

		$this->add_control(
			'style_2_slider_pointer_border_color',
			[
				'label' => __( 'Border Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-2 .rangeslider .rangeslider__handle' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style_2_slider_pointer_border_radius',
			[
				'label'       => __( 'Border Radius', 'happy-addons-pro' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 50,
				'min'         => 0,
				'max'         => 100,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-2 .rangeslider .rangeslider__handle' => 'border-radius: {{VALUE}}%;',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'style_2_slider_pointer_box_shadow',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-2 .rangeslider .rangeslider__handle',
			]
		);

		$this->add_control(
			'_header_style_2_slider_pointer_inner',
			[
				'label' => __( 'Pointer Inner', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'style_2_slider_pointer_inner_bg',
				'label' => __( 'Pointer Inner Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-2 .rangeslider .rangeslider__handle:after',
			]
		);

		$this->end_controls_section();
	}

	protected function __slider_style_3_controls() {

		$this->start_controls_section(
			'_section_style_slider_style_3',
			[
				'label' => __( 'Slider', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'slider_style' => 'style-3'
				],
			]
		);

		$this->add_control(
			'_header_style_3_slider_container',
			[
				'label' => __( 'Container Area', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'style_3_slider_container_bg',
				'label' => __( 'Container Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-3 .ha-adv-pricing-table-slider-range-pipe',
			]
		);

		$this->add_responsive_control(
			'style_3_slider_container_margin',
			[
				'label' => __( 'Margin', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'_header_style_3_slider_active_container',
			[
				'label' => __( 'Fill Area', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'style_3_slider_active_container_bg',
				'label' => __( 'Container Fill Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-3 .ha-adv-pricing-table-slider-range-thumb',
			]
		);

		$this->add_control(
			'_header_style_3_slider_pointer',
			[
				'label' => __( 'Pointer', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'style_3_slider_pointer_bg',
				'label' => __( 'Pointer Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				// 'types' => [ 'classic' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-3 .ha-adv-pricing-table-slider-range-thumb span',
			]
		);

		$this->add_control(
			'style_3_slider_pointer_border_radius',
			[
				'label'       => __( 'Border Radius', 'happy-addons-pro' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 50,
				'min'         => 0,
				'max'         => 100,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-3 .ha-adv-pricing-table-slider-range-thumb span' => 'border-radius: {{VALUE}}%;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'style_3_slider_pointer_box_shadow',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-3 .ha-adv-pricing-table-slider-range-thumb span',
			]
		);

		$this->add_control(
			'_header_style_3_slider_segment_pointer',
			[
				'label' => __( 'Segment Pointer', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'style_3_slider_segment_pointer_bg',
				'label' => __( 'Segment Pointer Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				// 'types' => [ 'classic' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-3 .ha-adv-pricing-table-slider-dot span',
			]
		);

		$this->add_control(
			'style_3_slider_segment_pointer_border_radius',
			[
				'label'       => __( 'Border Radius', 'happy-addons-pro' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 50,
				'min'         => 0,
				'max'         => 100,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-3 .ha-adv-pricing-table-slider-dot span' => 'border-radius: {{VALUE}}%;'
				]
			]
		);

		$this->end_controls_section();
	}

	protected function __slider_style_4_controls() {

		$this->start_controls_section(
			'_section_style_slider_style_4',
			[
				'label' => __( 'Slider', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'slider_style' => 'style-4'
				],
			]
		);

		$this->add_control(
			'_header_style_4_slider_container',
			[
				'label' => __( 'Container Area', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'style_4_slider_container_border_color',
			[
				'label' => __( 'Border Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-4 .ha-adv-pricing-table-slider-range-pipe' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'style_4_slider_container_bg',
				'label' => __( 'Container Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-4 .ha-adv-pricing-table-slider-range-pipe',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'style_4_slider_container_box_shadow',
				'label' => __( 'Box Shadow', 'happy-addons-pro' ),
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-4 .ha-adv-pricing-table-slider-range-pipe',
			]
		);

		$this->add_responsive_control(
			'style_4_slider_container_margin',
			[
				'label' => __( 'Margin', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'_header_style_4_slider_active_container',
			[
				'label' => __( 'Fill Area', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'style_4_slider_active_container_bg',
				'label' => __( 'Container Fill Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-4 .ha-adv-pricing-table-slider-range-thumb',
				'fields_options' => [
					'background' => [
						'default' => 'gradient',
					],
					'color' => [
						'default' => '#d00000', // START COLOR
					],
					'color_b' => [
						'default' => '#ffba08', // END COLOR
					],
					'gradient_type' => [
						'default' => 'linear',
					],
					'gradient_angle' => [
						'default' => [
							'unit' => 'deg',
							'size' => 90, // 90deg
						],
					],
				]
			]
		);

		$this->add_control(
			'_header_style_4_slider_pointer',
			[
				'label' => __( 'Pointer', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'style_4_slider_pointer_border_color',
			[
				'label' => __( 'Border Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-4 .ha-adv-pricing-table-slider-range-thumb span' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'style_4_slider_pointer_bg',
				'label' => __( 'Pointer Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-4 .ha-adv-pricing-table-slider-range-thumb span',
			]
		);

		$this->add_control(
			'style_4_slider_pointer_border_radius',
			[
				'label'       => __( 'Border Radius', 'happy-addons-pro' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 50,
				'min'         => 0,
				'max'         => 100,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-4 .ha-adv-pricing-table-slider-range-thumb span' => 'border-radius: {{VALUE}}%;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'style_4_slider_pointer_box_shadow',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-4 .ha-adv-pricing-table-slider-range-thumb span',
			]
		);

		$this->add_control(
			'_header_style_4_slider_segment_line',
			[
				'label' => __( 'Segment Line', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		// $this->add_group_control(
		// 	Group_Control_Background::get_type(),
		// 	[
		// 		'name' => 'style_4_slider_segment_line_background',
		// 		'label' => __( 'Small Pipe Background', 'happy-addons-pro' ),
		// 		// 'types' => [ 'classic', 'gradient' ],
		// 		'types' => [ 'classic' ],
        //         'exclude' => [ 'image' ],
		// 		'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-4 .ha-adv-pricing-table-slider-dot span',
		// 	]
		// );

		$this->add_control(
			'style_4_slider_segment_line_background_color',
			[
				'label' => __( 'Background Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-4 .ha-adv-pricing-table-slider-dot span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __slider_style_5_controls() {

		$this->start_controls_section(
			'_section_style_slider_style_5',
			[
				'label' => __( 'Slider', 'happy-addons-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'slider_style' => 'style-5'
				],
			]
		);

		$this->add_control(
			'_header_style_5_slider_container',
			[
				'label' => __( 'Container Area', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		// $this->add_control(
		// 	'style_5_slider_container_border_color',
		// 	[
		// 		'label' => __( 'Border Color', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-5 .ha-adv-pricing-table-slider-range-pipe' => 'border-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'style_5_slider_container_bg',
				'label' => __( 'Container Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				// 'types' => [ 'gradient' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-5 .ha-adv-pricing-table-slider-range-pipe',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'style_5_slider_container_box_shadow',
				'label' => __( 'Box Shadow', 'happy-addons-pro' ),
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-5 .ha-adv-pricing-table-slider-range-pipe',
			]
		);

		$this->add_responsive_control(
			'style_5_slider_container_margin',
			[
				'label' => __( 'Margin', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-5' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'_header_style_5_slider_active_container',
			[
				'label' => __( 'Fill Area', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'style_5_slider_active_container_bg',
				'label' => __( 'Container Fill Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-5 .ha-adv-pricing-table-slider-range-thumb',
				'fields_options' => [
					'background' => [
						'default' => 'gradient',
					],
					'color' => [
						'default' => '#b1b2e9', // START COLOR
					],
					'color_b' => [
						'default' => '#6366f1', // END COLOR
					],
					'gradient_type' => [
						'default' => 'linear',
					],
					'gradient_angle' => [
						'default' => [
							'unit' => 'deg',
							'size' => 90, // 90deg
						],
					],
				]
			]
		);

		$this->add_control(
			'_header_style_5_slider_pointer',
			[
				'label' => __( 'Pointer', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		// $this->add_control(
		// 	'style_5_slider_pointer_border_color',
		// 	[
		// 		'label' => __( 'Border Color', 'happy-addons-pro' ),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-5 .ha-adv-pricing-table-slider-range-thumb span' => 'border-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'style_5_slider_pointer_bg',
				'label' => __( 'Pointer Background', 'happy-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-5 .ha-adv-pricing-table-slider-range-thumb span',
			]
		);

		$this->add_control(
			'style_5_slider_pointer_border_radius',
			[
				'label'       => __( 'Border Radius', 'happy-addons-pro' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 50,
				'min'         => 0,
				'max'         => 100,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-5 .ha-adv-pricing-table-slider-range-thumb span' => 'border-radius: {{VALUE}}%;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'style_5_slider_pointer_box_shadow',
				'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-5 .ha-adv-pricing-table-slider-range-thumb span',
			]
		);

		$this->add_control(
			'_header_style_5_slider_segment_line',
			[
				'label' => __( 'Segment Line', 'happy-addons-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		// $this->add_group_control(
		// 	Group_Control_Background::get_type(),
		// 	[
		// 		'name' => 'style_5_slider_small_pipe_background',
		// 		'label' => __( 'Small Pipe Background', 'happy-addons-pro' ),
		// 		// 'types' => [ 'classic', 'gradient' ],
		// 		'types' => [ 'classic' ],
        //         'exclude' => [ 'image' ],
		// 		'selector' => '{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-5 .ha-adv-pricing-table-slider-dot span',
		// 	]
		// );

		$this->add_control(
			'style_5_slider_segment_line_background_color',
			[
				'label' => __( 'Background Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-adv-pricing-table-slider-container.style-5 .ha-adv-pricing-table-slider-dot span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Get Countries
	 *
	 * @return array
	 */
	public function get_countrie_with_currency() {

		$countries = [
			'US' => ['country_name' => __( 'United States', 'happy-addons-pro' ), 'currency_code' => 'USD', 'currency_symbol' => '&#36;'],
			'AE' => ['country_name' => __( 'United Arab Emirates', 'happy-addons-pro' ), 'currency_code' => 'AED', 'currency_symbol' => '&#1583;.&#1573;'],
			'AF' => ['country_name' => __( 'Afghanistan', 'happy-addons-pro' ), 'currency_code' => 'AFN', 'currency_symbol' => '&#1547;'],
			'AL' => ['country_name' => __( 'Albania', 'happy-addons-pro' ), 'currency_code' => 'ALL', 'currency_symbol' => 'L'],
			'AM' => ['country_name' => __( 'Armenia', 'happy-addons-pro' ), 'currency_code' => 'AMD', 'currency_symbol' => '&#1423;'],
			'AN' => ['country_name' => __( 'Netherlands Antilles', 'happy-addons-pro' ), 'currency_code' => 'ANG', 'currency_symbol' => '&#402;'],
			'AO' => ['country_name' => __( 'Angola', 'happy-addons-pro' ), 'currency_code' => 'AOA', 'currency_symbol' => 'Kz'],
			'AR' => ['country_name' => __( 'Argentina', 'happy-addons-pro' ), 'currency_code' => 'ARS', 'currency_symbol' => '&#36;'],
			'AU' => ['country_name' => __( 'Australia', 'happy-addons-pro' ), 'currency_code' => 'AUD', 'currency_symbol' => '&#36;'],
			'AW' => ['country_name' => __( 'Aruba', 'happy-addons-pro' ), 'currency_code' => 'AWG', 'currency_symbol' => '&#402;'],
			'AZ' => ['country_name' => __( 'Azerbaijan', 'happy-addons-pro' ), 'currency_code' => 'AZN', 'currency_symbol' => '&#8380;'],
			'BA' => ['country_name' => __( 'Bosnia and Herzegovina', 'happy-addons-pro' ), 'currency_code' => 'BAM', 'currency_symbol' => 'KM'],
			'BB' => ['country_name' => __( 'Barbados', 'happy-addons-pro' ), 'currency_code' => 'BBD', 'currency_symbol' => '&#36;'],
			'BD' => ['country_name' => __( 'Bangladesh', 'happy-addons-pro' ), 'currency_code' => 'BDT', 'currency_symbol' => '&#2547;'],
			'BG' => ['country_name' => __( 'Bulgaria', 'happy-addons-pro' ), 'currency_code' => 'BGN', 'currency_symbol' => '&#1083;&#1074;'],
			'BH' => ['country_name' => __( 'Bahrain', 'happy-addons-pro' ), 'currency_code' => 'BHD', 'currency_symbol' => '.&#1583;.&#1576;'],
			'BI' => ['country_name' => __( 'Burundi', 'happy-addons-pro' ), 'currency_code' => 'BIF', 'currency_symbol' => 'Fr'],
			'BM' => ['country_name' => __( 'Bermuda', 'happy-addons-pro' ), 'currency_code' => 'BMD', 'currency_symbol' => '&#36;'],
			'BN' => ['country_name' => __( 'Brunei', 'happy-addons-pro' ), 'currency_code' => 'BND', 'currency_symbol' => '&#36;'],
			'BO' => ['country_name' => __( 'Bolivia', 'happy-addons-pro' ), 'currency_code' => 'BOB', 'currency_symbol' => 'Bs.'],
			'BR' => ['country_name' => __( 'Brazil', 'happy-addons-pro' ), 'currency_code' => 'BRL', 'currency_symbol' => '&#82;&#36;'],
			'BS' => ['country_name' => __( 'Bahamas', 'happy-addons-pro' ), 'currency_code' => 'BSD', 'currency_symbol' => '&#36;'],
			'BT' => ['country_name' => __( 'Bhutan', 'happy-addons-pro' ), 'currency_code' => 'BTN', 'currency_symbol' => 'Nu.'],
			'BW' => ['country_name' => __( 'Botswana', 'happy-addons-pro' ), 'currency_code' => 'BWP', 'currency_symbol' => 'P'],
			'BY' => ['country_name' => __( 'Belarus', 'happy-addons-pro' ), 'currency_code' => 'BYN', 'currency_symbol' => 'Br'],
			'BZ' => ['country_name' => __( 'Belize', 'happy-addons-pro' ), 'currency_code' => 'BZD', 'currency_symbol' => '&#36;'],
			'CA' => ['country_name' => __( 'Canada', 'happy-addons-pro' ), 'currency_code' => 'CAD', 'currency_symbol' => '&#36;'],
			'CD' => ['country_name' => __( 'Democratic Republic of the Congo', 'happy-addons-pro' ), 'currency_code' => 'CDF', 'currency_symbol' => 'Fr'],
			'CH' => ['country_name' => __( 'Switzerland', 'happy-addons-pro' ), 'currency_code' => 'CHF', 'currency_symbol' => '&#67;&#72;&#70;'],
			'CL' => ['country_name' => __( 'Chile', 'happy-addons-pro' ), 'currency_code' => 'CLP', 'currency_symbol' => '&#36;'],
			'CN' => ['country_name' => __( 'China', 'happy-addons-pro' ), 'currency_code' => 'CNY', 'currency_symbol' => '&#165;'],
			'CO' => ['country_name' => __( 'Colombia', 'happy-addons-pro' ), 'currency_code' => 'COP', 'currency_symbol' => '&#36;'],
			'CR' => ['country_name' => __( 'Costa Rica', 'happy-addons-pro' ), 'currency_code' => 'CRC', 'currency_symbol' => '&#8353;'],
			'CU' => ['country_name' => __( 'Cuba', 'happy-addons-pro' ), 'currency_code' => 'CUP', 'currency_symbol' => '&#8369;'],
			'CV' => ['country_name' => __( 'Cape Verde', 'happy-addons-pro' ), 'currency_code' => 'CVE', 'currency_symbol' => '&#36;'],
			'CZ' => ['country_name' => __( 'Czech Republic', 'happy-addons-pro' ), 'currency_code' => 'CZK', 'currency_symbol' => '&#75;&#269;'],
			'DJ' => ['country_name' => __( 'Djibouti', 'happy-addons-pro' ), 'currency_code' => 'DJF', 'currency_symbol' => 'Fr'],
			'DK' => ['country_name' => __( 'Denmark', 'happy-addons-pro' ), 'currency_code' => 'DKK', 'currency_symbol' => '&#107;&#114;'],
			'DO' => ['country_name' => __( 'Dominican Republic', 'happy-addons-pro' ), 'currency_code' => 'DOP', 'currency_symbol' => '&#36;'],
			'DZ' => ['country_name' => __( 'Algeria', 'happy-addons-pro' ), 'currency_code' => 'DZD', 'currency_symbol' => '&#1583;.&#1580;'],
			'EG' => ['country_name' => __( 'Egypt', 'happy-addons-pro' ), 'currency_code' => 'EGP', 'currency_symbol' => '&#163;'],
			'ER' => ['country_name' => __( 'Eritrea', 'happy-addons-pro' ), 'currency_code' => 'ERN', 'currency_symbol' => 'Nfk'],
			'ET' => ['country_name' => __( 'Ethiopia', 'happy-addons-pro' ), 'currency_code' => 'ETB', 'currency_symbol' => 'Br'],
			'FJ' => ['country_name' => __( 'Fiji', 'happy-addons-pro' ), 'currency_code' => 'FJD', 'currency_symbol' => '&#36;'],
			'FK' => ['country_name' => __( 'Falkland Islands', 'happy-addons-pro' ), 'currency_code' => 'FKP', 'currency_symbol' => '&#163;'],
			'FO' => ['country_name' => __( 'Faroe Islands', 'happy-addons-pro' ), 'currency_code' => 'FOK', 'currency_symbol' => 'kr'],
			'GB' => ['country_name' => __( 'United Kingdom', 'happy-addons-pro' ), 'currency_code' => 'GBP', 'currency_symbol' => '&#163;'],
			'GE' => ['country_name' => __( 'Georgia', 'happy-addons-pro' ), 'currency_code' => 'GEL', 'currency_symbol' => '&#8382;'],
			'GG' => ['country_name' => __( 'Guernsey', 'happy-addons-pro' ), 'currency_code' => 'GGP', 'currency_symbol' => '&#163;'],
			'GH' => ['country_name' => __( 'Ghana', 'happy-addons-pro' ), 'currency_code' => 'GHS', 'currency_symbol' => '&#8373;'],
			'GI' => ['country_name' => __( 'Gibraltar', 'happy-addons-pro' ), 'currency_code' => 'GIP', 'currency_symbol' => '&#163;'],
			'GM' => ['country_name' => __( 'Gambia', 'happy-addons-pro' ), 'currency_code' => 'GMD', 'currency_symbol' => 'D'],
			'GN' => ['country_name' => __( 'Guinea', 'happy-addons-pro' ), 'currency_code' => 'GNF', 'currency_symbol' => 'Fr'],
			'GT' => ['country_name' => __( 'Guatemala', 'happy-addons-pro' ), 'currency_code' => 'GTQ', 'currency_symbol' => 'Q'],
			'GY' => ['country_name' => __( 'Guyana', 'happy-addons-pro' ), 'currency_code' => 'GYD', 'currency_symbol' => '&#36;'],
			'HK' => ['country_name' => __( 'Hong Kong', 'happy-addons-pro' ), 'currency_code' => 'HKD', 'currency_symbol' => '&#36;'],
			'HN' => ['country_name' => __( 'Honduras', 'happy-addons-pro' ), 'currency_code' => 'HNL', 'currency_symbol' => 'L'],
			'HR' => ['country_name' => __( 'Croatia', 'happy-addons-pro' ), 'currency_code' => 'HRK', 'currency_symbol' => 'kn'],
			'HT' => ['country_name' => __( 'Haiti', 'happy-addons-pro' ), 'currency_code' => 'HTG', 'currency_symbol' => 'G'],
			'HU' => ['country_name' => __( 'Hungary', 'happy-addons-pro' ), 'currency_code' => 'HUF', 'currency_symbol' => '&#70;&#116;'],
			'ID' => ['country_name' => __( 'Indonesia', 'happy-addons-pro' ), 'currency_code' => 'IDR', 'currency_symbol' => '&#82;&#112;'],
			'IL' => ['country_name' => __( 'Israel', 'happy-addons-pro' ), 'currency_code' => 'ILS', 'currency_symbol' => '&#8362;'],
			'IM' => ['country_name' => __( 'Isle of Man', 'happy-addons-pro' ), 'currency_code' => 'IMP', 'currency_symbol' => '&#163;'],
			'IN' => ['country_name' => __( 'India', 'happy-addons-pro' ), 'currency_code' => 'INR', 'currency_symbol' => '&#8377;'],
			'IQ' => ['country_name' => __( 'Iraq', 'happy-addons-pro' ), 'currency_code' => 'IQD', 'currency_symbol' => '&#1593;.&#1583;'],
			'IR' => ['country_name' => __( 'Iran', 'happy-addons-pro' ), 'currency_code' => 'IRR', 'currency_symbol' => '&#65020;'],
			'IS' => ['country_name' => __( 'Iceland', 'happy-addons-pro' ), 'currency_code' => 'ISK', 'currency_symbol' => '&#107;&#114;'],
			'JE' => ['country_name' => __( 'Jersey', 'happy-addons-pro' ), 'currency_code' => 'JEP', 'currency_symbol' => '&#163;'],
			'JM' => ['country_name' => __( 'Jamaica', 'happy-addons-pro' ), 'currency_code' => 'JMD', 'currency_symbol' => '&#36;'],
			'JO' => ['country_name' => __( 'Jordan', 'happy-addons-pro' ), 'currency_code' => 'JOD', 'currency_symbol' => '&#1583;.&#1575;'],
			'JP' => ['country_name' => __( 'Japan', 'happy-addons-pro' ), 'currency_code' => 'JPY', 'currency_symbol' => '&#165;'],
			'KE' => ['country_name' => __( 'Kenya', 'happy-addons-pro' ), 'currency_code' => 'KES', 'currency_symbol' => 'Sh'],
			'KG' => ['country_name' => __( 'Kyrgyzstan', 'happy-addons-pro' ), 'currency_code' => 'KGS', 'currency_symbol' => '&#1083;&#1074;'],
			'KH' => ['country_name' => __( 'Cambodia', 'happy-addons-pro' ), 'currency_code' => 'KHR', 'currency_symbol' => '&#6107;'],
			'KI' => ['country_name' => __( 'Kiribati', 'happy-addons-pro' ), 'currency_code' => 'KID', 'currency_symbol' => '&#36;'],
			'KM' => ['country_name' => __( 'Comoros', 'happy-addons-pro' ), 'currency_code' => 'KMF', 'currency_symbol' => 'Fr'],
			'KR' => ['country_name' => __( 'South Korea', 'happy-addons-pro' ), 'currency_code' => 'KRW', 'currency_symbol' => '&#8361;'],
			'KW' => ['country_name' => __( 'Kuwait', 'happy-addons-pro' ), 'currency_code' => 'KWD', 'currency_symbol' => '&#1583;.&#1603;'],
			'KY' => ['country_name' => __( 'Cayman Islands', 'happy-addons-pro' ), 'currency_code' => 'KYD', 'currency_symbol' => '&#36;'],
			'KZ' => ['country_name' => __( 'Kazakhstan', 'happy-addons-pro' ), 'currency_code' => 'KZT', 'currency_symbol' => '&#8376;'],
			'LA' => ['country_name' => __( 'Laos', 'happy-addons-pro' ), 'currency_code' => 'LAK', 'currency_symbol' => '&#8365;'],
			'LB' => ['country_name' => __( 'Lebanon', 'happy-addons-pro' ), 'currency_code' => 'LBP', 'currency_symbol' => '&#163;'],
			'LK' => ['country_name' => __( 'Sri Lanka', 'happy-addons-pro' ), 'currency_code' => 'LKR', 'currency_symbol' => '&#82;&#115;'],
			'LR' => ['country_name' => __( 'Liberia', 'happy-addons-pro' ), 'currency_code' => 'LRD', 'currency_symbol' => '&#36;'],
			'LS' => ['country_name' => __( 'Lesotho', 'happy-addons-pro' ), 'currency_code' => 'LSL', 'currency_symbol' => 'L'],
			'LY' => ['country_name' => __( 'Libya', 'happy-addons-pro' ), 'currency_code' => 'LYD', 'currency_symbol' => '&#1604;.&#1583;'],
			'MA' => ['country_name' => __( 'Morocco', 'happy-addons-pro' ), 'currency_code' => 'MAD', 'currency_symbol' => '&#1583;.&#1605;'],
			'MD' => ['country_name' => __( 'Moldova', 'happy-addons-pro' ), 'currency_code' => 'MDL', 'currency_symbol' => 'L'],
			'MG' => ['country_name' => __( 'Madagascar', 'happy-addons-pro' ), 'currency_code' => 'MGA', 'currency_symbol' => 'Ar'],
			'MK' => ['country_name' => __( 'North Macedonia', 'happy-addons-pro' ), 'currency_code' => 'MKD', 'currency_symbol' => '&#1076;&#1077;&#1085;'],
			'MM' => ['country_name' => __( 'Myanmar', 'happy-addons-pro' ), 'currency_code' => 'MMK', 'currency_symbol' => 'K'],
			'MN' => ['country_name' => __( 'Mongolia', 'happy-addons-pro' ), 'currency_code' => 'MNT', 'currency_symbol' => '&#8366;'],
			'MO' => ['country_name' => __( 'Macau', 'happy-addons-pro' ), 'currency_code' => 'MOP', 'currency_symbol' => 'P'],
			'MR' => ['country_name' => __( 'Mauritania', 'happy-addons-pro' ), 'currency_code' => 'MRU', 'currency_symbol' => 'UM'],
			'MU' => ['country_name' => __( 'Mauritius', 'happy-addons-pro' ), 'currency_code' => 'MUR', 'currency_symbol' => '&#8360;'],
			'MV' => ['country_name' => __( 'Maldives', 'happy-addons-pro' ), 'currency_code' => 'MVR', 'currency_symbol' => 'Rf'],
			'MW' => ['country_name' => __( 'Malawi', 'happy-addons-pro' ), 'currency_code' => 'MWK', 'currency_symbol' => 'MK'],
			'MX' => ['country_name' => __( 'Mexico', 'happy-addons-pro' ), 'currency_code' => 'MXN', 'currency_symbol' => '&#36;'],
			'MY' => ['country_name' => __( 'Malaysia', 'happy-addons-pro' ), 'currency_code' => 'MYR', 'currency_symbol' => '&#82;&#77;'],
			'MZ' => ['country_name' => __( 'Mozambique', 'happy-addons-pro' ), 'currency_code' => 'MZN', 'currency_symbol' => 'MT'],
			'NA' => ['country_name' => __( 'Namibia', 'happy-addons-pro' ), 'currency_code' => 'NAD', 'currency_symbol' => '&#36;'],
			'NG' => ['country_name' => __( 'Nigeria', 'happy-addons-pro' ), 'currency_code' => 'NGN', 'currency_symbol' => '&#8358;'],
			'NI' => ['country_name' => __( 'Nicaragua', 'happy-addons-pro' ), 'currency_code' => 'NIO', 'currency_symbol' => 'C&#36;'],
			'NO' => ['country_name' => __( 'Norway', 'happy-addons-pro' ), 'currency_code' => 'NOK', 'currency_symbol' => '&#107;&#114;'],
			'NP' => ['country_name' => __( 'Nepal', 'happy-addons-pro' ), 'currency_code' => 'NPR', 'currency_symbol' => '&#8360;'],
			'NZ' => ['country_name' => __( 'New Zealand', 'happy-addons-pro' ), 'currency_code' => 'NZD', 'currency_symbol' => '&#36;'],
			'OM' => ['country_name' => __( 'Oman', 'happy-addons-pro' ), 'currency_code' => 'OMR', 'currency_symbol' => '&#65020;'],
			'PA' => ['country_name' => __( 'Panama', 'happy-addons-pro' ), 'currency_code' => 'PAB', 'currency_symbol' => 'B/.'],
			'PE' => ['country_name' => __( 'Peru', 'happy-addons-pro' ), 'currency_code' => 'PEN', 'currency_symbol' => 'S/'],
			'PG' => ['country_name' => __( 'Papua New Guinea', 'happy-addons-pro' ), 'currency_code' => 'PGK', 'currency_symbol' => 'K'],
			'PH' => ['country_name' => __( 'Philippines', 'happy-addons-pro' ), 'currency_code' => 'PHP', 'currency_symbol' => '&#8369;'],
			'PK' => ['country_name' => __( 'Pakistan', 'happy-addons-pro' ), 'currency_code' => 'PKR', 'currency_symbol' => '&#8360;'],
			'PL' => ['country_name' => __( 'Poland', 'happy-addons-pro' ), 'currency_code' => 'PLN', 'currency_symbol' => '&#122;&#322;'],
			'PY' => ['country_name' => __( 'Paraguay', 'happy-addons-pro' ), 'currency_code' => 'PYG', 'currency_symbol' => '&#8370;'],
			'QA' => ['country_name' => __( 'Qatar', 'happy-addons-pro' ), 'currency_code' => 'QAR', 'currency_symbol' => '&#65020;'],
			'RO' => ['country_name' => __( 'Romania', 'happy-addons-pro' ), 'currency_code' => 'RON', 'currency_symbol' => '&#108;&#101;&#105;'],
			'RS' => ['country_name' => __( 'Serbia', 'happy-addons-pro' ), 'currency_code' => 'RSD', 'currency_symbol' => '&#1076;&#1080;&#1085;'],
			'RU' => ['country_name' => __( 'Russia', 'happy-addons-pro' ), 'currency_code' => 'RUB', 'currency_symbol' => '&#8381;'],
			'RW' => ['country_name' => __( 'Rwanda', 'happy-addons-pro' ), 'currency_code' => 'RWF', 'currency_symbol' => 'Fr'],
			'SA' => ['country_name' => __( 'Saudi Arabia', 'happy-addons-pro' ), 'currency_code' => 'SAR', 'currency_symbol' => '&#65020;'],
			'SB' => ['country_name' => __( 'Solomon Islands', 'happy-addons-pro' ), 'currency_code' => 'SBD', 'currency_symbol' => '&#36;'],
			'SC' => ['country_name' => __( 'Seychelles', 'happy-addons-pro' ), 'currency_code' => 'SCR', 'currency_symbol' => '&#8360;'],
			'SD' => ['country_name' => __( 'Sudan', 'happy-addons-pro' ), 'currency_code' => 'SDG', 'currency_symbol' => '&#163;'],
			'SE' => ['country_name' => __( 'Sweden', 'happy-addons-pro' ), 'currency_code' => 'SEK', 'currency_symbol' => '&#107;&#114;'],
			'SG' => ['country_name' => __( 'Singapore', 'happy-addons-pro' ), 'currency_code' => 'SGD', 'currency_symbol' => '&#36;'],
			'SH' => ['country_name' => __( 'Saint Helena', 'happy-addons-pro' ), 'currency_code' => 'SHP', 'currency_symbol' => '&#163;'],
			'SL' => ['country_name' => __( 'Sierra Leone', 'happy-addons-pro' ), 'currency_code' => 'SLE', 'currency_symbol' => 'Le'],
			'SO' => ['country_name' => __( 'Somalia', 'happy-addons-pro' ), 'currency_code' => 'SOS', 'currency_symbol' => 'Sh'],
			'SR' => ['country_name' => __( 'Suriname', 'happy-addons-pro' ), 'currency_code' => 'SRD', 'currency_symbol' => '&#36;'],
			'SS' => ['country_name' => __( 'South Sudan', 'happy-addons-pro' ), 'currency_code' => 'SSP', 'currency_symbol' => '&#163;'],
			'ST' => ['country_name' => __( 'São Tomé and Príncipe', 'happy-addons-pro' ), 'currency_code' => 'STN', 'currency_symbol' => 'Db'],
			'SY' => ['country_name' => __( 'Syria', 'happy-addons-pro' ), 'currency_code' => 'SYP', 'currency_symbol' => '&#163;'],
			'SZ' => ['country_name' => __( 'Eswatini', 'happy-addons-pro' ), 'currency_code' => 'SZL', 'currency_symbol' => 'L'],
			'TH' => ['country_name' => __( 'Thailand', 'happy-addons-pro' ), 'currency_code' => 'THB', 'currency_symbol' => '&#3647;'],
			'TJ' => ['country_name' => __( 'Tajikistan', 'happy-addons-pro' ), 'currency_code' => 'TJS', 'currency_symbol' => '&#1089;&#1084;'],
			'TM' => ['country_name' => __( 'Turkmenistan', 'happy-addons-pro' ), 'currency_code' => 'TMT', 'currency_symbol' => 'm'],
			'TN' => ['country_name' => __( 'Tunisia', 'happy-addons-pro' ), 'currency_code' => 'TND', 'currency_symbol' => '&#1583;.&#1578;'],
			'TO' => ['country_name' => __( 'Tonga', 'happy-addons-pro' ), 'currency_code' => 'TOP', 'currency_symbol' => 'T&#36;'],
			'TR' => ['country_name' => __( 'Turkey', 'happy-addons-pro' ), 'currency_code' => 'TRY', 'currency_symbol' => '&#8378;'],
			'TT' => ['country_name' => __( 'Trinidad and Tobago', 'happy-addons-pro' ), 'currency_code' => 'TTD', 'currency_symbol' => '&#36;'],
			'TV' => ['country_name' => __( 'Tuvalu', 'happy-addons-pro' ), 'currency_code' => 'TVD', 'currency_symbol' => '&#36;'],
			'TW' => ['country_name' => __( 'Taiwan', 'happy-addons-pro' ), 'currency_code' => 'TWD', 'currency_symbol' => '&#36;'],
			'TZ' => ['country_name' => __( 'Tanzania', 'happy-addons-pro' ), 'currency_code' => 'TZS', 'currency_symbol' => 'Sh'],
			'UA' => ['country_name' => __( 'Ukraine', 'happy-addons-pro' ), 'currency_code' => 'UAH', 'currency_symbol' => '&#8372;'],
			'UG' => ['country_name' => __( 'Uganda', 'happy-addons-pro' ), 'currency_code' => 'UGX', 'currency_symbol' => 'Sh'],
			'UY' => ['country_name' => __( 'Uruguay', 'happy-addons-pro' ), 'currency_code' => 'UYU', 'currency_symbol' => '&#36;'],
			'UZ' => ['country_name' => __( 'Uzbekistan', 'happy-addons-pro' ), 'currency_code' => 'UZS', 'currency_symbol' => '&#1083;&#1074;'],
			'VE' => ['country_name' => __( 'Venezuela', 'happy-addons-pro' ), 'currency_code' => 'VES', 'currency_symbol' => 'Bs.'],
			'VN' => ['country_name' => __( 'Vietnam', 'happy-addons-pro' ), 'currency_code' => 'VND', 'currency_symbol' => '&#8363;'],
			'VU' => ['country_name' => __( 'Vanuatu', 'happy-addons-pro' ), 'currency_code' => 'VUV', 'currency_symbol' => 'Vt'],
			'WS' => ['country_name' => __( 'Samoa', 'happy-addons-pro' ), 'currency_code' => 'WST', 'currency_symbol' => 'T'],
			'XK' => ['country_name' => __( 'Kosovo', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'YE' => ['country_name' => __( 'Yemen', 'happy-addons-pro' ), 'currency_code' => 'YER', 'currency_symbol' => '&#65020;'],
			'ZA' => ['country_name' => __( 'South Africa', 'happy-addons-pro' ), 'currency_code' => 'ZAR', 'currency_symbol' => 'R'],
			'ZM' => ['country_name' => __( 'Zambia', 'happy-addons-pro' ), 'currency_code' => 'ZMW', 'currency_symbol' => 'ZK'],
			'ZW' => ['country_name' => __( 'Zimbabwe', 'happy-addons-pro' ), 'currency_code' => 'ZWL', 'currency_symbol' => '&#36;'],
		];

		// Eurozone countries using EUR
		$eurozone_countries = [
			'AD' => ['country_name' => __( 'Andorra', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'AT' => ['country_name' => __( 'Austria', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'BE' => ['country_name' => __( 'Belgium', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'CY' => ['country_name' => __( 'Cyprus', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'EE' => ['country_name' => __( 'Estonia', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'FI' => ['country_name' => __( 'Finland', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'FR' => ['country_name' => __( 'France', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'DE' => ['country_name' => __( 'Germany', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'GR' => ['country_name' => __( 'Greece', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'IE' => ['country_name' => __( 'Ireland', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'IT' => ['country_name' => __( 'Italy', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'LV' => ['country_name' => __( 'Latvia', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'LT' => ['country_name' => __( 'Lithuania', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'LU' => ['country_name' => __( 'Luxembourg', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'MT' => ['country_name' => __( 'Malta', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'MC' => ['country_name' => __( 'Monaco', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'ME' => ['country_name' => __( 'Montenegro', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'NL' => ['country_name' => __( 'Netherlands', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'PT' => ['country_name' => __( 'Portugal', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'SM' => ['country_name' => __( 'San Marino', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'SK' => ['country_name' => __( 'Slovakia', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'SI' => ['country_name' => __( 'Slovenia', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'ES' => ['country_name' => __( 'Spain', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
			'VA' => ['country_name' => __( 'Vatican City', 'happy-addons-pro' ), 'currency_code' => 'EUR', 'currency_symbol' => '&#8364;'],
		];

		// Merge eurozone countries into main array
		$all_countries = array_merge( $countries, $eurozone_countries );

		return $all_countries;
	}

	public function get_currency_code( $country_code ) {

		// error_log( print_r( $key , 1 ) );

		$all_countries = $this->get_countrie_with_currency();

		if ( array_key_exists( $country_code, $all_countries ) ) {
			return $all_countries[ $country_code ]['currency_code'];
		} else {
			return '';
		}
	}

	public function get_currency_symbol( $country_code ) {

		// error_log( print_r( $key , 1 ) );

		$all_countries = $this->get_countrie_with_currency();

		if ( array_key_exists( $country_code, $all_countries ) ) {
			return $all_countries[ $country_code ]['currency_symbol'];
		} else {
			return '';
		}
	}

	public function get_country_details( $country_code ) {

		// error_log( print_r( $key , 1 ) );

		$all_countries = $this->get_countrie_with_currency();

		if ( array_key_exists( $country_code, $all_countries ) ) {
			return $all_countries[ $country_code ];
		} else {
			return '';
		}
	}

	public function get_currency_symbol_list() {

		$all_countries = $this->get_countrie_with_currency();
		// $default_country = [ '' => __( 'Select Currency', 'happy-addons-pro' ) ];

		// Sort by country code
		// ksort($all_countries);

		$all_countries = array_map( function( $country ) {
			return  '  ' . $country['country_name'] . ' (' . $country['currency_code'] . ') -- ' . $country['currency_symbol'];
		}, $all_countries );


		// $all_countries = array_merge( $default_country, $all_countries );

		// return count($countries);
		return $all_countries;
	}

	public function get_country_list() {

		$all_countries = $this->get_countrie_with_currency();
		$default_country = [ 'all' => __( 'All Country', 'happy-addons-pro' ) ];

		// Sort by country code
		// ksort($all_countries);

		$all_countries = array_map( function( $country ) {
			return  $country['country_name'];
		}, $all_countries );


		// $all_countries = array_merge( $default_country, $all_countries );

		// return count($countries);
		return $all_countries;
	}

	public function get_currency_test() {

		$all_countries = $this->get_countrie_with_currency();
		// $default_country = [ '' => __( 'Select Currency', 'happy-addons-pro' ) ];

		// Sort by country code
		// ksort($all_countries);

		$all_countries = array_map( function( $country ) {
			// return  '  ' . $country['country_name'] . ' (' . $country['currency_code'] . ') -- ' . $country['currency_symbol'];
			return  $country['currency_code'];
		}, $all_countries );


		// $all_countries = array_merge( $default_country, $all_countries );

		// return count($countries);
		return $all_countries;
	}



	private static function get_currency_symbol_old( $symbol_name ) {
		$symbols = [
			'baht'         => '&#3647;',
			'bdt'          => '&#2547;',
			'dollar'       => '&#36;',
			'euro'         => '&#128;',
			'franc'        => '&#8355;',
			'guilder'      => '&fnof;',
			'indian_rupee' => '&#8377;',
			'pound'        => '&#163;',
			'peso'         => '&#8369;',
			'peseta'       => '&#8359',
			'lira'         => '&#8356;',
			'ruble'        => '&#8381;',
			'shekel'       => '&#8362;',
			'rupee'        => '&#8360;',
			'real'         => 'R$',
			'krona'        => 'kr',
			'won'          => '&#8361;',
			'yen'          => '&#165;',
		];

		return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
	}

	private function get_link_attributes(array $url_control) {

        $attributes = [];

        if (!empty($url_control['url'])) {
            $attributes['href'] = $url_control['url'];
        }

        if (!empty($url_control['is_external'])) {
            $attributes['target'] = '_blank';
        }

        if (!empty($url_control['nofollow'])) {
            $attributes['rel'] = 'nofollow';
        }

        if (!empty($url_control['custom_attributes'])) {
            // Custom URL attributes should come as a string of comma-delimited key|value pairs
            $custom_attributes = explode(',', $url_control['custom_attributes']);
            $blacklist = ['onclick', 'onfocus', 'onblur', 'onchange', 'onresize', 'onmouseover', 'onmouseout', 'onkeydown', 'onkeyup'];

            foreach ($custom_attributes as $attribute) {
                // Trim in case users inserted unwanted spaces
                list($attr_key, $attr_value) = explode('|', $attribute);

                // Cover cases where key/value have spaces both before and/or after the actual value
                $attr_key = trim($attr_key);
                $attr_value = trim($attr_value);

                // Implement attribute blacklist
                if (!in_array(strtolower($attr_key), $blacklist, true)) {
                    $attributes[$attr_key] = $attr_value;
                }
            }
        }

		return $attributes;
    }

	private function get_feature_list( $description_text, $icon = '' ) {
        $feature_list = [];

        if ( !empty( $description_text ) ) {
            // Custom URL attributes should come as a string of comma-delimited key|value pairs
            $custom_attributes = explode('~', $description_text);

            foreach ( $custom_attributes as $attribute ) {

				if ( empty( $attribute ) ) {
					continue;
				}

                // Trim in case users inserted unwanted spaces
                // list($feature, $tooltip) = explode('|', $attribute);
                $list = explode('|', $attribute);

                // Cover cases where key/value have spaces both before and/or after the actual value
                $feature = isset( $list[0] ) ? trim( $list[0] ) : '';
                $tooltip = isset( $list[1] ) ? trim( $list[1] ) : '';
				$feature_list[] =[
					'icon' => $icon,
					'feature' => $feature,
					'tooltip' => $tooltip,
				];
            }
        }

		return $feature_list;
    }

	protected function get_api_data( $url ) {

		$response = wp_remote_get( $url, [
			'headers' => [
				'Accept' => 'application/json',
			],
		] );

		// Network or transport-level errors
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			//error_log( "Request failed: {$error_message}" );
			//error_log( "Request to this url : {$url}" );
			return new \WP_Error( 'api_error', 'Request failed: ' . $error_message );
		}

		// Check HTTP response code
		$response_code = wp_remote_retrieve_response_code( $response );
		if ( 200 !== $response_code ) {
			// error_log( "Unexpected HTTP code: {$response_code}" );
			return new \WP_Error( 'http_error', "Unexpected HTTP code: {$response_code}" );
		}

		// Get response body
		$body = wp_remote_retrieve_body( $response );
		if ( empty( $body ) ) {
			return new \WP_Error( 'empty_body', 'Empty response body received from API.' );
		}

		// Decode JSON safely
		$data = json_decode( $body, true );
		if ( json_last_error() !== JSON_ERROR_NONE ) {
			return new \WP_Error( 'json_error', 'Invalid JSON response: ' . json_last_error_msg() );
		}

		// Return parsed data
		return $data;
    }

	protected function get_cached_api_data( $url, $cache_key = '', $cache_time = '' ) {
		//$cache_key = '_ha_adv_pricing_table_exchange_rates';
		if ( ! $cache_time ) {
			$cache_time = (24 * HOUR_IN_SECONDS); // 24 hours
		}
		$cached = get_transient( $cache_key );

		if ( false !== $cached ) {
			//error_log( print_r( 'cached found' , 1 ) );
			return $cached;
		}
		//error_log( print_r( 'api hit' , 1 ) );

		$api_data = $this->get_api_data( $url );

		// Only cache if request succeeded
		if ( ! is_wp_error( $api_data ) ) {
			set_transient( $cache_key, $api_data, $cache_time );
		}

		return $api_data;
	}

	public function get_client_ip() {
		$ipaddress = '';
		if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif ( isset( $_SERVER['HTTP_X_FORWARDED'] ) ) {
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		} elseif ( isset( $_SERVER['HTTP_FORWARDED_FOR'] ) ) {
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		} elseif ( isset( $_SERVER['HTTP_FORWARDED'] ) ) {
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		} elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		}

		if ( '::1' == $ipaddress ) {
			$ipaddress = '';
		}
		return $ipaddress;
	}

	public function get_user_location() {
		$ip      = $this->get_client_ip();
		// $ip      = $this->get_rand_ip();
		$url     = $ip ? "https://ipinfo.io/{$ip}/json" : 'https://ipinfo.io/json';
		$ipdat = $this->get_api_data( $url );
		$country = 'US';
		// error_log( print_r( $ip , 1 ) );
		// error_log( print_r( $ipdat , 1 ) );
		if ( is_wp_error( $ipdat ) ) {
			return $country;
		} else {
			$country = is_array( $ipdat ) && array_key_exists( 'country', $ipdat ) ? $ipdat['country'] : 'US';
		}
		return $country;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$currency_symbol = '&#36;';
		$currency_code = 'USD';
		$user_location = 'US';
		$base_amount = 1;
		$exchange_rate_amount = 1;

		// error_log( print_r( $this->get_country_list() , 1 ) );
		// $currency = self::get_currency_symbol( $settings['currency'] );


		if ( 'static' == $settings['currency_type'] ) {
			$currency_symbol = $this->get_currency_symbol( $settings['currency_symbol'] );
			$currency_code = $this->get_currency_code( $settings['currency_symbol'] );
		}

		if ( 'daynamic' == $settings['currency_type'] ) {
			$user_location = $this->get_user_location();

			if ( 'all' == $settings['country'] ) {
				if ( ! is_array( $this->get_country_details( $user_location ) ) ) {
					$user_location = 'US'; // if country is not exist in our array
				}
			}

			if ( 'include' == $settings['country']  && ! empty( $settings['country_include'] ) && is_array( $settings['country_include'] ) ) {
				if ( ! in_array( $user_location, $settings['country_include'] ) ) {
					$user_location = 'US'; // default to US if not in include list
				}
			}

			if ( 'exclude' == $settings['country']  && ! empty( $settings['country_exclude'] ) && is_array( $settings['country_exclude'] ) ) {
				if ( in_array( $user_location, $settings['country_exclude'] ) ) {
					$user_location = 'US'; // default to US if in exclude list
				}
			}

			$currency_symbol = $this->get_currency_symbol( $user_location );
			$currency_code = $this->get_currency_code( $user_location );


			$url = 'https://exchange-rates-api.happymonster.dev/rates/USD';
			$cached_key = '_ha_adv_pricing_table_exchange_rates';
			// $exchange_rates = $this->get_api_data( $url );
			$exchange_rates = $this->get_cached_api_data( $url, $cached_key );

			if ( is_wp_error( $exchange_rates ) ) {
				// Handle API failure
				//error_log( 'Exchange Rates API Error: ' . $exchange_rates->get_error_message() );
				$exchange_rates = false;
			}

			if ( $exchange_rates && is_array( $exchange_rates ) && array_key_exists( 'rates', $exchange_rates ) ) {
				$rates = $exchange_rates['rates'];
				//  if $currency_code exist in rates array then set the exchange rate amount or default to 1
				if ( array_key_exists( $currency_code, $rates ) ) {
					$exchange_rate_amount = $rates[ $currency_code ];
				}
			}

			//error_log( print_r( $user_location , 1 ) );
			//error_log( print_r( $exchange_rate_amount , 1 ) );
			//error_log( print_r( $rates , 1 ) );
		}

		$feature_icon = ! empty( $settings['selected_icon'] ) ? $settings['selected_icon']['value'] : '';

		$this->add_render_attribute( 'wrapper', 'class', 'ha-adv-pricing-table-wrap' );
		$this->add_render_attribute( 'title', 'class', 'ha-adv-pricing-table-title' );
		$this->add_render_attribute( 'sub_title', 'class', 'ha-adv-pricing-table-subtitle' );

		$data = ( is_array( $settings['price_data'] )  && 0 != count($settings['price_data']) ) ? $settings['price_data'] : [];

		/* $query_settings = [
			[
			'user_id' => $settings['title'],
			'view_style' => $settings['title']
			],
			[
			'user_id' => $settings['title'],
			'view_style' => $settings['title']
			]
		]; */

		$query_settings = [];
		$repeaters_count = is_array( $settings['price_data'] ) ? count( $settings['price_data'] ) : 0;
		$max_input = ( $repeaters_count > 0 ) ? ( $repeaters_count - 1 ) : 0;

		if ( is_array( $settings['price_data'] )  && 0 != $repeaters_count ) {
			foreach ( $settings['price_data'] as $key => $item ) {

				if ( 'daynamic' == $settings['currency_type'] ) {
					$item['price'] = floatval( $item['price'] ) * floatval( $exchange_rate_amount );
					$item['original_price'] = floatval( $item['original_price'] ) * floatval( $exchange_rate_amount );
					$item['original_price'] = 0 != $item['original_price'] ? $item['original_price'] : '';
				}


				$this->add_render_attribute( 'button_text', 'class', 'ha-pricing-table-btn' );
				$this->add_link_attributes( 'button_text', $item['button_link'] );
				// $btn_attr = $this->get_render_attribute_string( 'button_text' );

				$btn_attr = $this->get_link_attributes( $item['button_link'] );
				// $btn_txt = esc_html( $item['button_text'] );
				$plan_related_icon = ! empty( $item['plan_related_icon'] ) ? $item['plan_related_icon']['value'] : '';

				$query_settings[] = [
					'plan_name'         => esc_html( $item['plan_name'] ),
					'price'             => esc_html( $item['price'] ),
					'original_price'    => esc_html( $item['original_price'] ),
					'period'            => esc_html( $item['period'] ),
					'plan_related_text' => esc_html( $item['plan_related_text'] ),
					'plan_related_icon' => esc_html( $plan_related_icon ),
					// 'features_desc' 	=>  wp_kses_post( $item['features_desc'] ),
					'features_desc' 	=>  $this->get_feature_list( $item['features_desc'], $feature_icon ),
					'button_text'       => esc_html( $item['button_text'] ),
					'button_attr'       => $btn_attr,
					'symbol'       => $currency_symbol,
					'currency_code'     => esc_html( $currency_code ),
				];
			}
		}

		$query_settings = json_encode($query_settings, true);
		$this->add_render_attribute( 'wrapper', 'data-price-settings', $query_settings );

		$this->add_render_attribute( 'footer_desc', 'class', 'ha-adv-pricing-table-footer-desc' );

		?>

		<div <?php $this->print_render_attribute_string( 'wrapper' );?> id="pricing-card-1">
			<?php if ( $settings['title'] || $settings['sub_title']) : ?>
			<!-- Header -->
			<div class="ha-adv-pricing-table-header">
				<?php if ( $settings['title'] ) : ?>
					<?php
						printf(
							'<%1$s %2$s>%3$s</%1$s>',
							ha_escape_tags( $settings['title_tag'] ),
							$this->get_render_attribute_string( 'title' ),
							ha_kses_basic( $settings['title'] )
						);
					?>
				<?php endif; ?>
				<?php if ( $settings['sub_title'] ) : ?>
					<?php
						printf(
							'<p %1$s>%2$s</p>',
							$this->get_render_attribute_string( 'sub_title' ),
							ha_kses_basic( $settings['sub_title'] )
						);
					?>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<!-- Plan Name & Price -->
			<div class="ha-adv-pricing-table-plan-name" data-plan-name></div>


			<div class="ha-adv-pricing-table-price-display">

				<div class="ha-adv-pricing-table-current-price">
					<span class="ha-adv-pricing-table-price-currency-icon" data-currency></span>
					<span class="ha-adv-pricing-table-price" data-price></span>
				</div>

				<div class="ha-adv-pricing-table-period-text">
					<div class="ha-adv-pricing-table-original-price">
						<span class="ha-adv-pricing-table-price-currency-icon" data-currency></span>
						<span class="ha-adv-pricing-table-price" data-original-price></span>
					</div>
					<div class="ha-adv-pricing-table-currency-text">
						<span class="ha-adv-pricing-table-price-currency-name"><?php echo esc_html( $currency_code ); ?></span>
						<span class="ha-adv-pricing-table-price-period" data-price-period></span>
					</div>
				</div>

				<!-- <span class="ha-adv-pricing-table-original-price" data-original-price style="display: none;">$25</span> -->
			</div>

			<?php if ( ! empty( $settings['button_pos'] ) && 'after-price' ==  $settings['button_pos'] ) : ?>
				<!-- CTA Button -->
				<div class="ha-adv-pricing-table-btn-area">
					<a class="ha-adv-pricing-table-btn" href="#" data-cta-button></a>
				</div>
			 <?php endif; ?>


			 <!-- Savings Badge -->
			<div class="ha-adv-pricing-table-price-text" data-savings></div>

			<?php if ( $repeaters_count &&  $repeaters_count > 1 && 'style-1' ==  $settings['slider_style'] ) : ?>
				<!-- Slider style 1 -->
				<div class="ha-adv-pricing-table-slider-container style-1">
					<div class="ha-adv-pricing-table-slider-wrap">
						<div class="ha-adv-pricing-table-slider-track" id="sliderTrack">
							<input type="range" id="priceSlider" min="0" max="<?php echo esc_attr( $max_input );?>" value="0" step="1">
							<div class="ha-adv-pricing-table-slider-thumb" id="sliderThumb"><i class="fas fa-arrows-alt-h"></i></div>
						</div>
					</div>
						<div class="ha-adv-pricing-table-slider-dots-container" id="sliderDots">
						<?php for ($i = 1; $i <= $repeaters_count; $i++) : ?>
							<div class="ha-adv-pricing-table-slider-dot <?php echo (1 == $i) ? 'active' : '';?>"><span></span></div>
						<?php endfor; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $repeaters_count &&  $repeaters_count > 1 && 'style-2' ==  $settings['slider_style'] ) : ?>
				<!-- Slider style 2 -->
				<div class="ha-adv-pricing-table-slider-container style-2">
					<input type="range" min="0" max="<?php echo esc_attr( $max_input );?>" value="0" step="1">
				</div>
			<?php endif; ?>

			<?php if ( $repeaters_count &&  $repeaters_count > 1 && 'style-3' ==  $settings['slider_style'] ) : ?>
				<!-- Slider style 3-->
				<!--
				Redmi A3x
				 -->
				<div class="ha-adv-pricing-table-slider-container style-3 slider-5" id="slider-5">
					<div class="ha-adv-pricing-table-slider-range-wrap">
						<input type="range" min="0" max="<?php echo esc_attr( $max_input );?>" value="0" step="1">
						<div class="ha-adv-pricing-table-slider-range-pipe"></div>
						<div class="ha-adv-pricing-table-slider-range-thumb"><span></span></div>
					</div>

					<!-- <div class="ha-adv-pricing-table-slider-dot-container">
						<div class="ha-adv-pricing-table-slider-dot active"><span></span></div>
						<div class="ha-adv-pricing-table-slider-dot"><span></span></div>
						<div class="ha-adv-pricing-table-slider-dot"><span></span></div>
						<div class="ha-adv-pricing-table-slider-dot"><span></span></div>
						<div class="ha-adv-pricing-table-slider-dot"><span></span></div>
					</div> -->
					<div class="ha-adv-pricing-table-slider-dots-container">
						<?php for ($i = 1; $i <= $repeaters_count; $i++) : ?>
							<div class="ha-adv-pricing-table-slider-dot <?php echo (1 == $i) ? 'active' : '';?>"><span></span></div>
						<?php endfor; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $repeaters_count &&  $repeaters_count > 1 && 'style-4' ==  $settings['slider_style'] ) : ?>
				<!-- Slider style 4-->
				<div class="ha-adv-pricing-table-slider-container style-4">
					<div class="ha-adv-pricing-table-slider-range-wrap">
						<input type="range" min="0" max="<?php echo esc_attr( $max_input );?>" value="0" step="1">
						<div class="ha-adv-pricing-table-slider-range-pipe"></div>
						<div class="ha-adv-pricing-table-slider-range-thumb"><span></span></div>
					</div>
					<div class="ha-adv-pricing-table-slider-dots-container">
						<?php for ($i = 1; $i <= $repeaters_count; $i++) : ?>
							<div class="ha-adv-pricing-table-slider-dot <?php echo (1 == $i) ? 'active' : '';?>"><span></span></div>
						<?php endfor; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $repeaters_count &&  $repeaters_count > 1 && 'style-5' ==  $settings['slider_style'] ) : ?>
				<!-- Slider style 5-->
				<div class="ha-adv-pricing-table-slider-container style-5">
					<div class="ha-adv-pricing-table-slider-range-wrap">
						<input type="range" min="0" max="<?php echo esc_attr( $max_input );?>" value="0" step="1">
						<div class="ha-adv-pricing-table-slider-range-pipe"></div>
						<div class="ha-adv-pricing-table-slider-range-thumb"><span></span></div>
					</div>
					<div class="ha-adv-pricing-table-slider-dots-container">
						<?php for ($i = 1; $i <= $repeaters_count; $i++) : ?>
							<div class="ha-adv-pricing-table-slider-dot <?php echo (1 == $i) ? 'active' : '';?>"><span></span></div>
						<?php endfor; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $settings['button_pos'] ) && 'after-slider' ==  $settings['button_pos'] ) : ?>
				<!-- CTA Button -->
				<div class="ha-adv-pricing-table-btn-area">
					<a class="ha-adv-pricing-table-btn" href="#" data-cta-button></a>
				</div>
			 <?php endif; ?>

			<!-- Features List -->
			<div class="ha-adv-pricing-table-features-wrap" data-features></div>

			<?php if ( ! empty( $settings['button_pos'] ) && 'after-feature' ==  $settings['button_pos'] ) : ?>
				<!-- CTA Button -->
				<div class="ha-adv-pricing-table-btn-area">
					<a class="ha-adv-pricing-table-btn" href="#" data-cta-button></a>
				</div>
			 <?php endif; ?>

			<?php if ( $settings['footer_desc'] ) : ?>
				<div <?php $this->print_render_attribute_string( 'footer_desc' ); ?>><?php echo ha_kses_intermediate( $settings['footer_desc'] ); ?></div>
			<?php endif; ?>

		</div>

	<?php
	}

	protected function get_rand_ip() {
		$ip_array = [
			'103.102.221.255', // Afghanistan => AF => Kabul
			'194.112.15.255', // Aland Islands => AX => Mariehamn
			'1.159.255.255', // Australia => AU => Perth
			'103.10.55.255', // Bangladesh => BD => Dhaka
			'102.165.46.0', // Brazil => BR => Muriaé
			'103.129.62.0', // Bhutan => BT => Thimphu
			'104.132.215.255', // Bhutan => FI => Hamina
			'102.177.124.255', // United Arab Emirates => AE => Al Fujairah City
			'1.178.94.0', // United Kingdom => GB => London
			'101.46.144.0', // Saudi Arabia => SA => Riyadh
			'157.167.86.0', // Kuwait => KW => Kuwait City
			'1.10.10.255', // India => IN => Mumbai
			'101.50.131.255', // Pakistan => PK => Islamabad
		];
		$rand_key = rand(0,12);
		return $ip_array[$rand_key];

		// return '102.165.46.0'; // Brazil
		// return '102.177.124.255'; // United Arab Emirates
		// return '103.102.221.255'; // Afghanistan
		// return '101.50.131.255'; // Pakistan

		// return array_rand( $ip_array, 1 );
	}
}
