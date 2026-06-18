<?php
/**
 * Business Hour widget class
 *
 * @package Happy_Addons
 */

namespace Happy_Addons_Pro\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

defined('ABSPATH') || die();

class Scroll_Tabs extends Base {
	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title() {
		return __('Scroll Tabs', 'happy-addons-pro');
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
		return 'hm hm-up-down';
	}

	public function get_keywords() {
		return ['scroll-tabs','scroll','tabs',];
	}

	/**
     * Register widget content controls
     */
	protected function register_content_controls() {
		$this->__tabs_content_content_controls();
		$this->__settings_content_controls();
	}

	protected function __tabs_content_content_controls() {

		$this->start_controls_section(
			'scroll_tabs_content_section',
			[
				'label' => __('Tabs Content', 'happy-addons-pro'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __('Title', 'happy-addons-pro'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __('HappyAddon', 'happy-addons-pro'),
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'description',
			[
				'label' => __('Description', 'happy-addons-pro'),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => __('Our years of experience on designs and development helps to bring you an well crafted sets of widgets that brings some elegant look and feel to your websites, and that comes without spending too much time.', 'happy-addons-pro'),
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'nav_text',
			[
				'label' => __('Nav Text', 'happy-addons-pro'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __('Presets', 'happy-addons-pro'),
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'nav_icon',
			[
				'label' => __('Nav Icon', 'happy-addons-pro'),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'skin' => 'inline',
				// 'exclude_inline_options' => [ 'svg' ],
				'default' => [
					'value' => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [
					'nav_text!' => '',
				],
			]
		);

		$repeater->add_control(
			'content_type',
			[
				'label' => __('Content Type', 'happy-addons-pro'),
				'type' => Controls_Manager::SELECT,
				'default' => 'editor',
				'options' => [
					'editor' => __('Editor', 'happy-addons-pro'),
					'template' => __('Template', 'happy-addons-pro'),
				],
			]
		);

		$repeater->add_control(
			'editor',
			[
				'label' => __('Editor', 'happy-addons-pro'),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __('Select any pre-made design sets to customize and compare among different appearances possible for a happy widget. Just click on the presets from the drop-down menu and see the magic.', 'happy-addons-pro'),
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'content_type' => 'editor',
				],
			]
		);

		$repeater->add_control(
            'template_id',
            [
                'label' => __('Choose Template', 'happy-addons-pro'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => false,
                'options' => ha_pro_get_elementor_templates(),
                'condition' => [
                    'content_type' => 'template'
                ],
            ]
        );

		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'section_item_background',
				'label' => __('Background', 'happy-addons-pro'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ha-scroll-tab-content-wrapper {{CURRENT_ITEM}}.ha-scroll-tab-content-section',
				'separator' => 'before',
                'style_transfer' => true,
			]
		);

		$this->add_control(
			'scroll_tabs_list',
			[
				'show_label' => false,
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ nav_text }}}',
				'default' => [
					[
						'nav_text' => __('Presets', 'happy-addons-pro'),
						'nav_icon' => [
							'value' => 'fas fa-arrow-right',
							'library' => 'fa-solid',
						],
						'content_type' => 'editor',
						'editor' => __('Select any pre-made design sets to customize and compare among different appearances possible for a happy widget. Just click on the presets from the drop-down menu and see the magic.', 'happy-addons-pro'),
					],
					[
						'nav_text' => __('Cross Domain Copy Paste', 'happy-addons-pro'),
						'nav_icon' => [
							'value' => 'fas fa-arrow-right',
							'library' => 'fa-solid',
						],
						'content_type' => 'editor',
						'editor' => __('Working on multiple websites? Easily copy anything from one site and paste them to others on different domains to save yourself from repetitive work. How cool is that?', 'happy-addons-pro'),
					],
					[
						'nav_text' => __('Live Copy', 'happy-addons-pro'),
						'nav_icon' => [
							'value' => 'fas fa-arrow-right',
							'library' => 'fa-solid',
						],
						'content_type' => 'editor',
						'editor' => __('There is a common complaint, it\'s impossible to make the exact demo-like design on a personal website. Well, this won\'t be the case anymore. With the LiveCopy now you can copy any design from HappyAddons Demo site to your site. The magic is you will be able to copy from frontend to elementor edit panel. Isn\'t it amazing?', 'happy-addons-pro'),
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __settings_content_controls() {

		$this->start_controls_section(
			'scroll_tabs_content_settings',
			[
				'label' => __('Settings', 'happy-addons-pro'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'nav_panel_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Nav Panel', 'happy-addons-pro' ),
				// 'separator' => 'after',
			]
		);

		$this->add_control(
			'nav_panel_width',
			[
				'label'          => __( 'Width (%)', 'happy-addons-pro' ),
				'type'           => Controls_Manager::SLIDER,
				'range'          => [
					'%'  => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors'      => [
					'{{WRAPPER}}.ha-scroll-tabs' => '--haScrollTabLeftPanelWidth: {{SIZE}}%;',
				],
                'style_transfer' => true,
			]
		);

		$this->add_responsive_control(
			'nav_panel_position',
			[
				'label' => __( 'Position', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'description' => __('Choose the position of the navigation panel.', 'happy-addons-pro'),
				'options' => [
					'left' => [
						'title' => __( 'Left', 'happy-addons-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'happy-addons-pro' ),
						'icon' => 'eicon-h-align-right',
					]
				],
				'default' => 'left',
				'toggle' => false,
				'prefix_class' => 'ha-scroll-tab-nav-pos-',
				'selectors_dictionary' => [
					'left' => 'order: 0',
					'right' => 'order: 1',
				],
				'selectors' => [
					'{{WRAPPER}} .ha-scroll-tab-left-panel' => '{{VALUE}}',
				],
                'style_transfer' => true,
			]
		);

		$this->add_responsive_control(
			'nav_panel_var_alignment',
			[
				'label' => __( 'Vertical Alignment', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'flex-start' => [
						'title' => __( 'Top', 'happy-addons-pro' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Center', 'happy-addons-pro' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => __( 'Bottom', 'happy-addons-pro' ),
						'icon' => 'eicon-v-align-bottom',
					]
				],
				'default' => 'flex-start',
				'toggle' => false,
				'prefix_class' => 'ha-scroll-tab-nav-panel-vertical-align-',
				'selectors' => [
					'{{WRAPPER}} .ha-scroll-tab-left-panel ' => 'justify-content: {{VALUE}}',
				],
                'style_transfer' => true,
			]
		);

		$this->add_control(
			'content_panel_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Content Panel', 'happy-addons-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'content_panel_inner_section_height',
			[
				'label'          => __( 'Height (px)', 'happy-addons-pro' ),
				'type'           => Controls_Manager::SLIDER,
				'range'          => [
					'px'  => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors'      => [
					'{{WRAPPER}}.ha-scroll-tabs .ha-scroll-tab-content-wrapper' => 'height: {{SIZE}}{{UNIT}};',
				],
                'style_transfer' => true,
			]
		);

		$this->add_responsive_control(
			'content_panel_hor_alignment',
			[
				'label' => __( 'Alignment', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'description' => __('This will apply only to content type editor.', 'happy-addons-pro'),
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
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .ha-scroll-tab-right-panel .ha-scroll-tab-content-section.content-type-editor' => 'text-align: {{VALUE}}',
				],
                'style_transfer' => true,
			]
		);

		$this->add_responsive_control(
			'content_panel_var_alignment',
			[
				'label' => __( 'Vertical Alignment', 'happy-addons-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'flex-start' => [
						'title' => __( 'Top', 'happy-addons-pro' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Center', 'happy-addons-pro' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => __( 'Bottom', 'happy-addons-pro' ),
						'icon' => 'eicon-v-align-bottom',
					]
				],
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}}.ha-scroll-tabs .ha-scroll-tab-content-section ' => 'justify-content: {{VALUE}}',
				],
                'style_transfer' => true,
			]
		);

		$this->end_controls_section();
	}

	/**
     * Register widget style controls
     */
	protected function register_style_controls() {
		$this->__nav_panel_style_controls();
		$this->__content_panel_style_controls();
		$this->__scroll_section_style_controls();
	}

	protected function __nav_panel_style_controls() {

		$this->start_controls_section(
			'nav_panel_style_section',
			[
				'label' => __('Nav Panel', 'happy-addons-pro'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'nav_panel_area_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Nav Area', 'happy-addons-pro' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'nav_panel_background',
				'label' => __('Background', 'happy-addons-pro'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ha-scroll-tab-left-panel',
			]
		);

		$this->add_responsive_control(
			'nav_panel_border_radius',
			[
				'label' => __('Border Radius', 'happy-addons-pro'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ha-scroll-tab-left-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_panel_padding',
			[
				'label' => __('Padding', 'happy-addons-pro'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ha-scroll-tab-left-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'nav_panel_title_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Title', 'happy-addons-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Color', 'happy-addons-pro'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-scroll-tab-left-panel h2' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .ha-scroll-tab-left-panel h2',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => __('Margin', 'happy-addons-pro'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ha-scroll-tab-left-panel h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'nav_panel_desc_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Description', 'happy-addons-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => __('Color', 'happy-addons-pro'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-scroll-tab-left-panel p' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'selector' => '{{WRAPPER}} .ha-scroll-tab-left-panel p',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_responsive_control(
			'desc_margin',
			[
				'label' => __('Margin', 'happy-addons-pro'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ha-scroll-tab-left-panel p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'nav_panel_nav_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Nav Item', 'happy-addons-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'nav_item_typography',
				'selector' => '{{WRAPPER}} li.ha-scroll-tab-nav-item',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_responsive_control(
			'nav_item_margin',
			[
				'label' => __('Margin', 'happy-addons-pro'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} li.ha-scroll-tab-nav-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_item_padding',
			[
				'label' => __('Padding', 'happy-addons-pro'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} li.ha-scroll-tab-nav-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'nav_item_border',
				'selector' => '{{WRAPPER}} li.ha-scroll-tab-nav-item',
			]
		);

		$this->add_responsive_control(
			'nav_item_border_radius',
			[
				'label' => __( 'Border Radius', 'happy-addons-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} li.ha-scroll-tab-nav-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( '_nav_panel_nav_item' );
		$this->start_controls_tab(
			'_nav_panel_nav_item_normal',
			[
				'label' => __( 'Normal', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'nav_item_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} li.ha-scroll-tab-nav-item' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_item_bg_color',
			[
				'label' => __( 'Background Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} li.ha-scroll-tab-nav-item' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_nav_panel_nav_item_hover',
			[
				'label' => __( 'Hover', 'happy-addons-pro' ),
			]
		);

		$this->add_control(
			'nav_item_hover_color',
			[
				'label' => __( 'Text Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} li.ha-scroll-tab-nav-item:hover, {{WRAPPER}} li.ha-scroll-tab-nav-item.active, {{WRAPPER}} li.ha-scroll-tab-nav-item.active:hover, {{WRAPPER}} li.ha-scroll-tab-nav-item:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_item_bg_hover_color',
			[
				'label' => __( 'Background Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} li.ha-scroll-tab-nav-item:hover, {{WRAPPER}} li.ha-scroll-tab-nav-item.active, {{WRAPPER}} li.ha-scroll-tab-nav-item.active:hover, {{WRAPPER}} li.ha-scroll-tab-nav-item:focus' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_item_bg_hover_border_color',
			[
				'label' => __( 'Border Color', 'happy-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'nav_item_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} li.ha-scroll-tab-nav-item:hover, {{WRAPPER}} li.ha-scroll-tab-nav-item.active, {{WRAPPER}} li.ha-scroll-tab-nav-item.active:hover, {{WRAPPER}} li.ha-scroll-tab-nav-item:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function __content_panel_style_controls() {

		$this->start_controls_section(
			'content_panel_style_section',
			[
				'label' => __('Content Panel', 'happy-addons-pro'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_panel_color',
			[
				'label' => __('Text Color', 'happy-addons-pro'),
				'description' => __('This style will apply only to editor type content', 'happy-addons-pro'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-scroll-tab-right-panel .content-type-editor p' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_panel_typography',
				'selector' => '{{WRAPPER}} .ha-scroll-tab-right-panel .ha-scroll-tab-content-section.content-type-editor',
				'description' => __('This style will apply only to editor type content', 'happy-addons-pro'),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'content_panel_bg',
                'selector' => '{{WRAPPER}} .ha-scroll-tab-right-panel',
            ]
        );

		$this->add_responsive_control(
			'content_panel_border_radius',
			[
				'label' => __('Border Radius', 'happy-addons-pro'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ha-scroll-tab-right-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_panel_padding',
			[
				'label' => __('Padding', 'happy-addons-pro'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
					'top' => 40,
					'right' => 30,
					'bottom' => 40,
					'left' => 30,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .ha-scroll-tab-right-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __scroll_section_style_controls() {

		$this->start_controls_section(
			'scroll_section_style_section',
			[
				'label' => __('Scroll Section', 'happy-addons-pro'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'scroll_section_bg',
                'types' => [ 'classic', 'gradient' ],
                // 'exclude' => [ 'image' ],
                'selector' => '{{WRAPPER}}.ha-scroll-tabs .ha-scroll-tab-content-section',
            ]
        );

		$this->add_responsive_control(
			'scroll_section_padding',
			[
				'label' => __('Padding', 'happy-addons-pro'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default' => [
					'top' => 40,
					'right' => 30,
					'bottom' => 40,
					'left' => 30,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}}.ha-scroll-tabs .ha-scroll-tab-content-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'scroll_section_border_radius',
			[
				'label' => __('Border Radius', 'happy-addons-pro'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ha-scroll-tab-right-panel .ha-scroll-tab-content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>

			<div class="ha-scroll-tab-container">
				<div class="ha-scroll-tab-left-panel">
					<?php if ( $settings['title'] ) : ?>
						<h2 class="ha-scroll-tab-title"> <?php echo esc_html( $settings['title'] ); ?> </h2>
					<?php endif; ?>

					<?php if( $settings['description'] ) : ?>
						<p class="ha-scroll-tab-description"> <?php echo ha_kses_basic( $settings['description'] ); ?> </p>
					<?php endif; ?>

					<?php if ( is_array($settings['scroll_tabs_list']) && 0 != count($settings['scroll_tabs_list'])) : ?>
						<ul class="ha-scroll-tab-nav-menu">
							<?php foreach ( $settings['scroll_tabs_list'] as $key => $item ) : ?>
								<?php $cls = ( 0 == $key ) ? 'ha-scroll-tab-nav-item active' : 'ha-scroll-tab-nav-item'; ?>
								<li class="<?php echo esc_attr( $cls ); ?>" data-section="<?php echo esc_attr( $key ); ?>">
									<?php ha_render_icon( $item, false, 'nav_icon' ); ?>
									<?php if ( $item['nav_text'] ) : ?>
										<span><?php echo esc_html( $item['nav_text'] ); ?></span>
									<?php else: ?>
										<span><?php echo esc_html__('Nav Item', 'happy-addons-pro') + $key; ?></span>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>

				<div class="ha-scroll-tab-right-panel">
					<div class="ha-scroll-tab-content-wrapper" id="contentWrapper">

						<?php if ( is_array($settings['scroll_tabs_list']) && 0 != count($settings['scroll_tabs_list'])) : ?>
							<?php foreach ( $settings['scroll_tabs_list'] as $key => $item ) : ?>
								<?php
									$section_cls = 'ha-scroll-tab-content-section';
									$section_cls .= ' content-type-' . $item['content_type'];
									$section_cls .= ' elementor-repeater-item-' . $item['_id'];
								?>
								<div class="<?php echo esc_attr( $section_cls );?>" data-section="<?php echo esc_attr( $key ); ?>">
									<?php
									if ( $item['content_type'] === 'editor' && $item['editor'] ) :
										echo $this->parse_text_editor( $item['editor'] );
									elseif ( $item['content_type'] === 'template' && $item['template_id'] ) :
										$saved_template = apply_filters('wpml_object_id', $item['template_id'], 'elementor_library');
										echo ha_elementor()->frontend->get_builder_content_for_display( $saved_template );
									else:
										echo esc_html__('No content available', 'happy-addons-pro');
									endif;
									?>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>

					</div>
				</div>

			</div>
		<?php
	}

}
