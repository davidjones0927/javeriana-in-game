<?php

/**
 * Advanced Search Widget
 *
 * @package Happy_Addons_Pro
 */

namespace Happy_Addons_Pro\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Icons_Manager;

defined('ABSPATH') || die();

/**
 * Class Advanced_Search
 *
 * Advanced Search Widget for Elementor
 * Provides a comprehensive search interface with multiple post types, categories, and styling options
 *
 * @since 3.5.0
 */
class Advanced_Search extends Base {

    /**
     * Get widget title
     *
     * @since 3.5.0
     * @access public
     * @return string Widget title
     */
    public function get_title() {
        return __('Advanced Search', 'happy-addons-pro');
    }

    public function get_custom_help_url() {
        return 'https://happyaddons.com/docs/happy-addons-for-elementor-pro/happy-effects-pro/advanced-search/';
    }

    /**
     * Get widget icon
     *
     * @since 3.5.0
     * @access public
     * @return string Widget icon
     */
    public function get_icon() {
        return 'hm hm-search';
    }

    /**
     * Get widget keywords
     *
     * @since 3.5.0
     * @access public
     * @return array Widget keywords
     */
    public function get_keywords() {
        return ['card', 'fancy', 'box', 'search', 'advanced'];
    }

    /**
     * Register widget content controls
     *
     * @since 3.5.0
     * @access protected
     */
    protected function register_content_controls() {
        $this->__search_settings_controls();
        $this->__search_fields_text_controls();
        $this->__layout2_category_date_icon_controls();
        $this->__search_button_text_controls();
        $this->__date_custom_text_controls();
        $this->__search_result_text_controls();
    }

    /**
     * Search Settings Controls
     *
     * Controls for configuring search behavior and display options
     *
     * @since 3.5.0
     * @access protected
     */
    protected function __search_settings_controls() {
        $this->start_controls_section(
            '_section_search_layout',
            [
                'label' => __('Search Layout', 'happy-addons-pro'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'search_layout',
            [
                'label' => __('Search Layout', 'happy-addons-pro'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'layout-1' => __('Layout 1', 'happy-addons-pro'),
                    'layout-2' => __('Layout 2', 'happy-addons-pro'),
                    'layout-3' => __('Layout 3', 'happy-addons-pro'),
                    'layout-4' => __('Layout 4', 'happy-addons-pro'),
                ],
                'default' => 'layout-1',
                'prefix_class' => 'ha-advanced-search-search-layout-',
                'render_type' => 'template',
                'frontend_available' => true,
            ]
        );

        $this->end_controls_section();

        // Get available post types
        $post_types = get_post_types(['public' => true], 'objects');

        $post_type_options = [];
        foreach ($post_types as $post_type) {
            $post_type_options[$post_type->name] = $post_type->labels->name;
        }

        $this->start_controls_section(
            '_section_search_settings_layout1',
            [
                'label' => __('Search Settings ', 'happy-addons-pro'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'search_layout' => 'layout-1',
                ],
            ]
        );

        $this->add_control(
            'post_types',
            [
                'label' => __('Select Search Types', 'happy-addons-pro'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $post_type_options,
                'default' => ['post', 'page'],
                'label_block' => true,
                'description' => __('Choose which search types to search through', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'initial_results_count',
            [
                'label' => __('Show Initial Results', 'happy-addons-pro'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'description' => __('Number of initial results to display', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'show_category_list',
            [
                'label' => __('Show Category List', 'happy-addons-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'happy-addons-pro'),
                'label_off' => __('Hide', 'happy-addons-pro'),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );


        $this->add_control(
            'show_date_filter',
            [
                'label' => __('Show Date Filter', 'happy-addons-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'happy-addons-pro'),
                'label_off' => __('Hide', 'happy-addons-pro'),
                'default' => 'yes',
                'return_value' => 'yes',
                'condition' => [
                    'search_layout!' => ['layout-3', 'layout-4'],
                ],
            ]
        );



        $this->add_control(
            'show_popular_keyword',
            [
                'label' => __('Show Popular Keywords', 'happy-addons-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'happy-addons-pro'),
                'label_off' => __('Hide', 'happy-addons-pro'),
                'default' => 'yes',
                'return_value' => 'yes',
                'condition' => [
                    'search_layout!' => ['layout-3', 'layout-4'],
                ],
            ]
        );
        $this->add_control(
            'popular_keywords_limit',
            [
                'label'       => __('Popular Keywords Limit', 'happy-addons-pro'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 10,
                'min'         => 1,
                'max'         => 10,
                'step'        => 1,
                'condition'  => [
                    'show_popular_keyword' => 'yes',
                    'search_layout!' => ['layout-3', 'layout-4'],
                ],
            ]
        );

        $this->add_control(
            'show_content_image',
            [
                'label' => __('Show Content Image', 'happy-addons-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'happy-addons-pro'),
                'label_off' => __('Hide', 'happy-addons-pro'),
                'default' => 'yes',
                'return_value' => 'yes',
                'condition' => [
                    'search_layout!' => ['layout-3', 'layout-4'],
                ],
            ]
        );

        $this->add_control(
            'layout_order_heading',
            [
                'label' => __('Search Filters', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'     => 'show_date_filter',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'show_category_list',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'total_position',
            [
                'label' => __('Filter Position', 'happy-addons-pro'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'right',
                'toggle'  => false,
                'prefix_class' => 'ha-advanced-search-total-pos-',
                'condition' => [
                    'search_layout!' => ['layout-3', 'layout-4'],
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'     => 'show_date_filter',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'show_category_list',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'date_position',
            [
                'label' => __('Date Position', 'happy-addons-pro'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left (Date First)', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right (Date After)', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'right',
                'toggle'  => false,
                'prefix_class' => 'ha-advanced-search-date-pos-',
                'condition' => [
                    'show_date_filter' => 'yes',
                    'search_layout!' => ['layout-3', 'layout-4'],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_search_settings_layout2',
            [
                'label' => __('Search Settings ', 'happy-addons-pro'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'search_layout' => 'layout-2',
                ],
            ]
        );

        $this->add_control(
            'layout2_post_types',
            [
                'label' => __('Select Search Types', 'happy-addons-pro'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $post_type_options,
                'default' => ['post', 'page'],
                'label_block' => true,
                'description' => __('Choose which search types to search through', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout2_initial_results_count',
            [
                'label' => __('Show Initial Results', 'happy-addons-pro'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'description' => __('Number of initial results to display', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout2_show_category_list',
            [
                'label' => __('Show Category List', 'happy-addons-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'happy-addons-pro'),
                'label_off' => __('Hide', 'happy-addons-pro'),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'layout2_show_date_filter',
            [
                'label' => __('Show Date Filter', 'happy-addons-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'happy-addons-pro'),
                'label_off' => __('Hide', 'happy-addons-pro'),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );


        $this->add_control(
            'layout2_show_popular_keyword',
            [
                'label' => __('Show Popular Keywords', 'happy-addons-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'happy-addons-pro'),
                'label_off' => __('Hide', 'happy-addons-pro'),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'layout2_popular_keywords_limit',
            [
                'label'       => __('Popular Keywords Limit', 'happy-addons-pro'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 10,
                'min'         => 1,
                'max'         => 10,
                'step'        => 1,
                'condition'  => [
                    'layout2_show_popular_keyword' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'layout2_show_content_image',
            [
                'label' => __('Show Content Image', 'happy-addons-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'happy-addons-pro'),
                'label_off' => __('Hide', 'happy-addons-pro'),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'layout2_looking_for_label',
            [
                'label' => __('Looking For Label', 'happy-addons-pro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Looking for', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout2_category_label',
            [
                'label' => __('Category Label', 'happy-addons-pro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Category', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout2_date_label',
            [
                'label' => __('Date Label', 'happy-addons-pro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Date', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout2_button_inline',
            [
                'label' => __('Button Inline', 'happy-addons-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'happy-addons-pro'),
                'label_off' => __('No', 'happy-addons-pro'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'layout2_layout_order_heading',
            [
                'label' => __('Search Filters', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'     => 'layout2_show_date_filter',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'layout2_show_category_list',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'layout2_total_position',
            [
                'label' => __('Filter Position', 'happy-addons-pro'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'right',
                'toggle'  => false,
                'prefix_class' => 'ha2-total-pos-',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'     => 'layout2_show_date_filter',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'layout2_show_category_list',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'layout2_date_position',
            [
                'label' => __('Date Position', 'happy-addons-pro'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left (Date First)', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right (Date After)', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'right',
                'toggle'  => false,
                'prefix_class' => 'ha2-date-pos-',
                'condition' => [
                    'layout2_show_date_filter' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_search_settings_layout3',
            [
                'label' => __('Search Settings ', 'happy-addons-pro'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'search_layout' => 'layout-3',
                ],
            ]
        );

        $this->add_control(
            'layout3_post_types',
            [
                'label' => __('Select Search Types', 'happy-addons-pro'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $post_type_options,
                'default' => ['post', 'page'],
                'label_block' => true,
                'description' => __('Choose which search types to search through', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout3_initial_results_count',
            [
                'label' => __('Show Initial Results', 'happy-addons-pro'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'description' => __('Number of initial results to display', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout3_show_category_list',
            [
                'label' => __('Show Category List', 'happy-addons-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'happy-addons-pro'),
                'label_off' => __('Hide', 'happy-addons-pro'),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'layout3_show_search_field',
            [
                'label' => __('Show Search Field', 'happy-addons-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'happy-addons-pro'),
                'label_off' => __('Hide', 'happy-addons-pro'),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'layout3_show_popular_keyword',
            [
                'label' => __('Show Popular Keywords', 'happy-addons-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'happy-addons-pro'),
                'label_off' => __('Hide', 'happy-addons-pro'),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'layout3_popular_keywords_limit',
            [
                'label'       => __('Popular Keywords Limit', 'happy-addons-pro'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 10,
                'min'         => 1,
                'max'         => 10,
                'step'        => 1,
                'condition'  => [
                    'layout3_show_popular_keyword' => 'yes',
                ],
            ]
        );



        $this->end_controls_section();

        $this->start_controls_section(
            '_section_search_settings_layout4',
            [
                'label' => __('Search Settings ', 'happy-addons-pro'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'search_layout' => 'layout-4',
                ],
            ]
        );

        $this->add_control(
            'layout4_post_types',
            [
                'label' => __('Select Search Types', 'happy-addons-pro'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $post_type_options,
                'default' => ['post', 'page'],
                'label_block' => true,
                'description' => __('Choose which search types to search through', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout4_initial_results_count',
            [
                'label' => __('Show Initial Results', 'happy-addons-pro'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'description' => __('Number of initial results to display', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout4_show_category_list',
            [
                'label' => __('Show Category List', 'happy-addons-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'happy-addons-pro'),
                'label_off' => __('Hide', 'happy-addons-pro'),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'layout4_show_search_field',
            [
                'label' => __('Show Search Field', 'happy-addons-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'happy-addons-pro'),
                'label_off' => __('Hide', 'happy-addons-pro'),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );



        $this->add_control(
            'layout4_show_content_image',
            [
                'label' => __('Show Content Image', 'happy-addons-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'happy-addons-pro'),
                'label_off' => __('Hide', 'happy-addons-pro'),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Layout 2 Category/Date Icon Controls
     *
     * @since 3.5.0
     * @access protected
     */
    protected function __layout2_category_date_icon_controls() {
        $this->start_controls_section(
            '_section_layout2_category_date_icon',
            [
                'label' => __('Category and Date Icon', 'happy-addons-pro'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'search_layout' => 'layout-2',
                ],
            ]
        );

        $this->add_control(
            'layout2_category_select_icon',
            [
                'label' => __('Category Icon', 'happy-addons-pro'),
                'type'  => Controls_Manager::ICONS,
                'skin'  => 'inline',
                'default' => [
                    'library' => 'hm',
                    'value'   => 'hm hm-location-pointer',
                ],
                'condition' => [
                    'layout2_show_category_list' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'layout2_date_select_icon',
            [
                'label' => __('Date Icon', 'happy-addons-pro'),
                'type'  => Controls_Manager::ICONS,
                'skin'  => 'inline',
                'default' => [
                    'library' => 'hm',
                    'value'   => 'hm hm-location-pointer',
                ],
                'condition' => [
                    'layout2_show_date_filter' => 'yes',
                ],
            ]
        );


        $this->end_controls_section();
    }

    /**
     * Search Fields Text Controls
     *
     * Controls for customizing text labels in search fields
     *
     * @since 3.5.0
     * @access protected
     */
    protected function __search_fields_text_controls() {
        $this->start_controls_section(
            '_section_search_fields_text',
            [
                'label' => __('Search Field', 'happy-addons-pro'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'search_icon',
            [
                'label' => __('Search Icon', 'happy-addons-pro'),
                'type'  => Controls_Manager::ICONS,
                'skin'  => 'inline',
                'default' => [
                    'library' => 'solid',
                    'value'   => 'fas fa-search',
                ],
                'condition' => [
                    'search_layout' => 'layout-1',
                ],
            ]
        );

        $this->add_responsive_control(
            'search_icon_position',
            [
                'label' => __('Icon Position', 'happy-addons-pro'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'ha1-field-icon-pos-',
                'default' => 'left',
                'toggle'  => false,
                'selectors_dictionary' => [
                    'left'  => 'flex-direction: row; --ha-advanced-search-l1-icon-ml: 20px; --ha-advanced-search-l1-icon-mr: 20px; --ha-advanced-search-l1-clear-right: 20px;',
                    'right' => 'flex-direction: row-reverse; --ha-advanced-search-l1-icon-ml: 10px; --ha-advanced-search-l1-icon-mr: 20px; --ha-advanced-search-l1-clear-right: 60px;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_input_wrapper' => '{{VALUE}}',
                    '{{WRAPPER}} .ha_advanced_search_input_wrapper .ha_advanced_search_search_icon' => 'margin-left: var(--ha-advanced-search-l1-icon-ml, 20px); margin-right: var(--ha-advanced-search-l1-icon-mr, 10px);',
                    '{{WRAPPER}} .ha_advanced_search_input_wrapper .ha_advanced_search_clear_button' => 'right: var(--ha-advanced-search-l1-clear-right, 20px)',
                ],
                'condition' => [
                    'search_layout' => 'layout-1',
                    'search_icon[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'layout2_search_icon',
            [
                'label' => __('Search Icon', 'happy-addons-pro'),
                'type'  => Controls_Manager::ICONS,
                'skin'  => 'inline',
                'default' => [
                    'library' => 'solid',
                    'value'   => 'fas fa-search',
                ],
                'condition' => [
                    'search_layout' => 'layout-2',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout2_search_icon_position',
            [
                'label' => __('Icon Position', 'happy-addons-pro'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'ha2-s-field-icon-pos-',
                'default' => 'left',
                'toggle'  => false,
                'selectors_dictionary' => [
                    'left'  => '--ha-advanced-search-l2-icon-order: 1; --ha-advanced-search-l2-input-order: 2; --ha-advanced-search-l2-icon-ml: 0px; --ha-advanced-search-l2-icon-mr: 12px;',
                    'right' => '--ha-advanced-search-l2-icon-order: 2; --ha-advanced-search-l2-input-order: 1; --ha-advanced-search-l2-icon-ml: 10px; --ha-advanced-search-l2-icon-mr: 0px;',
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2' => '{{VALUE}}',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_group_wide .ha_advanced_search_layout2_input_wrapper .ha_advanced_search_layout2_icon' => 'order: var(--ha-advanced-search-l2-icon-order, 1); margin-right: var(--ha-advanced-search-l2-icon-mr, 12px); margin-left: var(--ha-advanced-search-l2-icon-ml, 0px);',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_group_wide .ha_advanced_search_layout2_input_wrapper .ha_advanced_search_search_input' => 'order: var(--ha-advanced-search-l2-input-order, 2);',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_group_wide .ha_advanced_search_layout2_input_wrapper .ha_advanced_search_clear_button' => 'order: 3;',
                ],
                'condition' => [
                    'search_layout' => 'layout-2',
                    'layout2_search_icon[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'layout3_search_icon',
            [
                'label' => __('Search Icon', 'happy-addons-pro'),
                'type'  => Controls_Manager::ICONS,
                'skin'  => 'inline',
                'default' => [
                    'library' => 'solid',
                    'value'   => 'fas fa-search',
                ],
                'condition' => [
                    'search_layout' => 'layout-3',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout3_search_icon_position',
            [
                'label' => __('Icon Position', 'happy-addons-pro'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle'  => false,
                'prefix_class' => 'ha3-field-icon-pos-',
                'selectors_dictionary' => [
                    'left'  => '--ha-advanced-search-l3-trigger-dir: row; --ha-advanced-search-l3-icon-mr: 10px; --ha-advanced-search-l3-icon-ml: 0px;',
                    'right' => '--ha-advanced-search-l3-trigger-dir: row-reverse; --ha-advanced-search-l3-icon-mr: 0px; --ha-advanced-search-l3-icon-ml: 10px;',
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '{{VALUE}}',
                ],
                'render_type' => 'template',
                'condition' => [
                    'search_layout' => 'layout-3',
                    'layout3_search_icon[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'layout4_search_icon',
            [
                'label' => __('Search Icon', 'happy-addons-pro'),
                'type'  => Controls_Manager::ICONS,
                'skin'  => 'inline',
                'default' => [
                    'library' => 'solid',
                    'value'   => 'fas fa-search',
                ],
                'condition' => [
                    'search_layout' => 'layout-4',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout4_search_icon_position',
            [
                'label' => __('Icon Position', 'happy-addons-pro'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle'  => false,
                'prefix_class' => 'ha4-field-icon-pos-',
                'selectors_dictionary' => [
                    'left'  => '--ha-advanced-search-l4-trigger-dir: row; --ha-advanced-search-l4-icon-mr: 10px; --ha-advanced-search-l4-icon-ml: 0px;',
                    'right' => '--ha-advanced-search-l4-trigger-dir: row-reverse; --ha-advanced-search-l4-icon-mr: 0px; --ha-advanced-search-l4-icon-ml: 10px;',
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '{{VALUE}}',
                ],
                'render_type' => 'template',
                'condition' => [
                    'search_layout' => 'layout-4',
                    'layout4_search_icon[value]!' => '',
                ],
            ]
        );



        $this->add_control(
            'layout1_placeholder_text',
            [
                'label' => __('Placeholder Text', 'happy-addons-pro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Search', 'happy-addons-pro'),
                'placeholder' => __('Enter placeholder text', 'happy-addons-pro'),
                'condition' => [
                    'search_layout' => 'layout-1',
                ],
            ]
        );

        $this->add_control(
            'layout2_placeholder_text',
            [
                'label' => __('Placeholder Text', 'happy-addons-pro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Search', 'happy-addons-pro'),
                'placeholder' => __('Enter placeholder text', 'happy-addons-pro'),
                'condition' => [
                    'search_layout' => 'layout-2',
                ],
            ]
        );

        $this->add_control(
            'layout3_placeholder_text',
            [
                'label' => __('Placeholder Text', 'happy-addons-pro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Search', 'happy-addons-pro'),
                'placeholder' => __('Enter placeholder text', 'happy-addons-pro'),
                'condition' => [
                    'search_layout' => 'layout-3',
                ],
            ]
        );

        $this->add_control(
            'layout4_placeholder_text',
            [
                'label' => __('Placeholder Text', 'happy-addons-pro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Search', 'happy-addons-pro'),
                'placeholder' => __('Enter placeholder text', 'happy-addons-pro'),
                'condition' => [
                    'search_layout' => 'layout-4',
                ],
            ]
        );

        $this->add_control(
            'layout3_search_field_drawer_heading',
            [
                'label' => __('Drawer', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'condition' => [
                    'search_layout' => 'layout-3',
                ],
            ]
        );


        $this->add_control(
            'layout3_search_field_icon',
            [
                'label' => __('Search Field Icon', 'happy-addons-pro'),
                'type'  => Controls_Manager::ICONS,
                'skin'  => 'inline',
                'default' => [
                    'library' => 'solid',
                    'value'   => 'fas fa-search',
                ],
                'condition' => [
                    'search_layout' => 'layout-3',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout3_search_field_icon_position',
            [
                'label' => __('Icon Position', 'happy-addons-pro'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle'  => false,
                'prefix_class' => 'ha3-field-drawer-icon-pos-',
                'selectors_dictionary' => [
                    'left'  => '--ha-advanced-search-l3-drawer-input-order: 2; --ha-advanced-search-l3-drawer-icon-order: 1;',
                    'right' => '--ha-advanced-search-l3-drawer-input-order: 1; --ha-advanced-search-l3-drawer-icon-order: 2;',
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-form-wrapper' => '{{VALUE}}',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-form-wrapper .ha_advanced_search_search-icon-input' => 'order: var(--ha-advanced-search-l3-drawer-icon-order, 1);',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-form-wrapper .ha_advanced_search_search_input' => 'order: var(--ha-advanced-search-l3-drawer-input-order, 2);',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-form-wrapper .ha_advanced_search_search-clear-btn' => 'order: 3;',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-form-wrapper .ha_advanced_search_search-category-container' => 'order: 4;',
                ],
                'condition' => [
                    'search_layout' => 'layout-3',
                ],
            ]
        );

        $this->add_control(
            'layout3_search_field_placeholder_text',
            [
                'label' => __('Placeholder Text', 'happy-addons-pro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Enter Search', 'happy-addons-pro'),
                'placeholder' => __('Enter placeholder text', 'happy-addons-pro'),
                'condition' => [
                    'search_layout' => 'layout-3',
                ],
            ]
        );


        $this->add_control(
            'layout4_search_input_text',
            [
                'label' => __('Search Input Text', 'happy-addons-pro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Start typing', 'happy-addons-pro'),
                'placeholder' => __('Enter search input text', 'happy-addons-pro'),
                'condition' => [
                    'search_layout' => 'layout-4',
                ],
            ]
        );


        $this->add_control(
            'layout4_logo_icon',
            [
                'label' => __('Logo Icon', 'happy-addons-pro'),
                'type'  => Controls_Manager::ICONS,
                'skin'  => 'inline',
                'default' => [
                    'library' => 'solid',
                    'value'   => 'fas fa-search',
                ],
                'condition' => [
                    'search_layout' => 'layout-4',
                    'layout4_logo_type' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'helper_text',
            [
                'label'       => __('Helper Text', 'happy-addons-pro'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __('Start typing to see instant results.', 'happy-addons-pro'),
                'placeholder' => __('Enter helper text', 'happy-addons-pro'),
                'rows'        => 3,
                'condition' => [
                    'search_layout!' => ['layout-3', 'layout-4'],
                ],
            ]
        );


        $this->end_controls_section();
    }
    /**
     * Search Button Text Controls
     *
     * Controls for customizing text labels in search fields
     *
     * @since 3.5.0
     * @access protected
     */
    protected function __search_button_text_controls() {
        $this->start_controls_section(
            '_section_search_button_text',
            [
                'label' => __('Search Button', 'happy-addons-pro'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'search_layout!' => ['layout-3', 'layout-4'],
                ],
            ]
        );

        $this->add_control(
            'search_button_icon',
            [
                'label' => __('Search Icon', 'happy-addons-pro'),
                'type'  => Controls_Manager::ICONS,
                'skin'  => 'inline',
                'default' => [
                    'library' => 'solid',
                    'value'   => 'fas fa-search',
                ],
            ]
        );

        $this->add_responsive_control(
            'search_button_icon_position',
            [
                'label' => __('Icon Position', 'happy-addons-pro'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle'  => false,
                'selectors_dictionary' => [
                    'left'  => 'row',
                    'right' => 'row-reverse',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_button' => 'flex-direction: {{VALUE}};',
                ],

                // only show if icon selected
                'condition' => [
                    'search_button_icon[value]!' => '',
                ],
            ]
        );
        $this->add_control(
            'layout1_search_button_text',
            [
                'label' => __('Search Button Text', 'happy-addons-pro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Search', 'happy-addons-pro'),
                'placeholder' => __('Enter button text', 'happy-addons-pro'),
                'condition' => [
                    'search_layout' => 'layout-1',
                ],
            ]
        );

        $this->add_control(
            'layout1_empty_search_term_text',
            [
                'label' => __('Empty Search Text', 'happy-addons-pro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Please enter a search term', 'happy-addons-pro'),
                'placeholder' => __('Enter empty search text', 'happy-addons-pro'),
                'condition' => [
                    'search_layout' => 'layout-1',
                ],
            ]
        );

        $this->add_control(
            'layout2_search_button_text',
            [
                'label' => __('Search Button Text', 'happy-addons-pro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Search', 'happy-addons-pro'),
                'placeholder' => __('Enter button text', 'happy-addons-pro'),
                'condition' => [
                    'search_layout' => 'layout-2',
                ],
            ]
        );

        $this->add_control(
            'layout2_empty_search_term_text',
            [
                'label' => __('Empty Search Text', 'happy-addons-pro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Please enter a search term', 'happy-addons-pro'),
                'placeholder' => __('Enter empty search text', 'happy-addons-pro'),
                'condition' => [
                    'search_layout' => 'layout-2',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Date
     *
     * Controls for customizing text labels in search fields
     *
     * @since 3.5.0
     * @access protected
     */
    protected function __date_custom_text_controls() {


        $this->start_controls_section(
            '_section_date_custom_text',
            [
                'label' => __('Custom Date', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'layout2_show_date_filter',
                                    'operator' => '==',
                                    'value' => 'yes',
                                ],
                                [
                                    'name' => 'search_layout',
                                    'operator' => '==',
                                    'value' => 'layout-2',
                                ],
                            ],
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'show_date_filter',
                                    'operator' => '==',
                                    'value' => 'yes',
                                ],
                                [
                                    'name' => 'search_layout',
                                    'operator' => '==',
                                    'value' => 'layout-1',
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );


        // (Optional) Calendar/Icon for date panel if you need it
        $this->add_control(
            'date_panel_icon',
            [
                'label'   => __('Custom Date Icon', 'happy-addons-pro'),
                'type'    => Controls_Manager::ICONS,
                'skin'    => 'inline',
                'default' => [
                    'library' => 'solid',
                    'value'   => 'fas fa-calendar-alt',
                ],
            ]
        );



        // Start Date label text
        $this->add_control(
            'date_start_label_text',
            [
                'label'       => __('Start Date Text', 'happy-addons-pro'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Start Date', 'happy-addons-pro'),
                'placeholder' => __('Enter start label', 'happy-addons-pro'),
            ]
        );

        // End Date label text
        $this->add_control(
            'date_end_label_text',
            [
                'label'       => __('End Date Text', 'happy-addons-pro'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('End Date', 'happy-addons-pro'),
                'placeholder' => __('Enter end label', 'happy-addons-pro'),
            ]
        );

        $this->end_controls_section();
    }


    /**
     * Search Result Text Controls
     *
     * Controls for customizing text labels in search results
     *
     * @since 3.5.0
     * @access protected
     */
    protected function __search_result_text_controls() {

        $this->start_controls_section(
            '_section_search_popup_text',
            [
                'label' => __('Search Popup', 'happy-addons-pro'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'search_layout' => 'layout-4',
                ],
            ]
        );


        $this->add_control(
            'layout4_logo_image',
            [
                'label' => __('Logo Image', 'happy-addons-pro'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'search_layout' => 'layout-4',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_search_result_text',
            [
                'label' => __('Search Result', 'happy-addons-pro'),
                'tab' => Controls_Manager::TAB_CONTENT,


            ]
        );

        $this->add_control(
            'load_more_text',
            [
                'label' => __('Load More Text', 'happy-addons-pro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Load More', 'happy-addons-pro'),
                'placeholder' => __('Enter load more text', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'not_found_text',
            [
                'label' => __('Not Found Text', 'happy-addons-pro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('No results found', 'happy-addons-pro'),
                'placeholder' => __('Enter not found text', 'happy-addons-pro'),
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register widget style controls
     *
     * @since 3.5.0
     * @access protected
     */
    protected function register_style_controls() {
        $this->__search_container_controls();
        $this->__search_field_style_controls();
        $this->__search_button_style_controls();
        $this->__category_dropdown_style_controls();
        $this->__date_dropdown_style_controls();
        $this->__search_results_style_controls();
        $this->__popular_search_style_controls();
        $this->__search_container_controls_layout2();
        $this->__search_field_style_controls_layout2();
        $this->__search_button_style_controls_layout2();
        $this->__category_dropdown_style_controls_layout2();
        $this->__date_dropdown_style_controls_layout2();
        $this->__search_results_style_controls_layout2();
        $this->__popular_search_style_controls_layout2();
        $this->__search_container_controls_layout3();
        $this->__search_drawer_controls_layout3();
        $this->__search_results_style_controls_layout3();
        $this->__search_container_controls_layout4();
        $this->__search_popup_controls_layout4();
        $this->__search_results_style_controls_layout4();
    }

    /**
     * Search Container Style Controls
     *
     * Controls for styling search container elements
     *
     * @since 3.5.0
     * @access protected
     */
    protected function __search_container_controls() {

        $this->start_controls_section(
            'section_container_style',
            [
                'label' => __('Search Container', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-1',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_max_width',
            [
                'label' => __('Max Width', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => ['min' => 200, 'max' => 1400],
                    '%'  => ['min' => 10,  'max' => 100],
                    'vw' => ['min' => 10,  'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_box' => 'max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ha_advanced_search_date_range' => 'max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ha_advanced_search_results_container'  => 'max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ha-advanced-search-popular-search-section' => 'max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ha_advanced_search_helper_text' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'container_gap',
            [
                'label' => __('Gap', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100],
                    '%'  => ['min' => 0,  'max' => 100],
                    'vw' => ['min' => 0,  'max' => 100],
                ],
                'default' => [
                    'size' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_box' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        /* Background (classic/gradient/video supported by Elementor) */
        $this->add_control(
            'container_background',
            [
                'label' => __('Background', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_box' => 'background-color: {{VALUE}};',
                ],
            ]
        );



        $this->add_responsive_control(
            'container_align',
            [
                'label' => __('Alignment', 'happy-addons-pro'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle'  => false,

                // 👇 This is the key
                'prefix_class' => 'ha-advanced-search-align-',

                'selectors_dictionary' => [
                    'left'   => 'margin-right:auto;',
                    'center' => 'margin-left:auto;margin-right:auto;',
                    'right'  => 'margin-left:auto;',
                ],

                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_box' => '{{VALUE}}',

                    '{{WRAPPER}} .ha-advanced-search-popular-search-section' => '{{VALUE}}',
                    '{{WRAPPER}} .ha_advanced_search_helper_text' => '{{VALUE}}',
                ],
            ]
        );


        /* Padding */
        $this->add_responsive_control(
            'container_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_search_box' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        /* Margin */
        $this->add_responsive_control(
            'container_margin',
            [
                'label'      => __('Margin', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_search_box' =>
                    'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        /* Border */
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'container_border',
                'label'    => __('Border', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}} .ha_advanced_search_search_box',
            ]
        );

        /* Border Radius */
        $this->add_responsive_control(
            'container_border_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_search_box' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('container_box_shadow_tabs');

        $this->start_controls_tab(
            'container_box_shadow_tab_normal',
            [
                'label' => __('Normal', 'happy-addons-pro'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'container_box_shadow',
                'label'    => __('Box Shadow', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}} .ha_advanced_search_search_box',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'container_box_shadow_tab_hover',
            [
                'label' => __('Hover', 'happy-addons-pro'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'container_box_shadow_hover',
                'label'    => __('Box Shadow', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}} .ha_advanced_search_search_box:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'container_box_shadow_tab_focus',
            [
                'label' => __('Focus', 'happy-addons-pro'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'container_box_shadow_focus',
                'label'    => __('Box Shadow', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}} .ha_advanced_search_search_box:focus-within',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();






        $this->end_controls_section();
    }

    /**
     * Search Result Style Controls
     *
     * Controls for styling search result text elements
     *
     * @since 3.5.0
     * @access protected
     */



    protected function __search_container_controls_layout2() {

        $this->start_controls_section(
            'section_container_style_layout2',
            [
                'label' => __('Search Container ', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-2',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout2_container_max_width',
            [
                'label' => __('Max Width', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => ['min' => 200, 'max' => 1400],
                    '%'  => ['min' => 10,  'max' => 100],
                    'vw' => ['min' => 10,  'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_box' => 'max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_range' => 'max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_results_container' => 'max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-popular-search-section' => 'max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_helper_text' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'layout2_container_gap',
            [
                'label' => __('Gap', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100],
                    '%'  => ['min' => 0,  'max' => 100],
                    'vw' => ['min' => 0,  'max' => 100],
                ],
                'default' => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2  .ha_advanced_search_search_box' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        /* Background (classic/gradient/video supported by Elementor) */
        $this->add_control(
            'layout2_container_background',
            [
                'label' => __('Background', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_box' => 'background-color: {{VALUE}};',
                ],
            ]
        );



        $this->add_responsive_control(
            'layout2_container_align',
            [
                'label' => __('Alignment', 'happy-addons-pro'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle'  => false,
                'prefix_class' => 'ha-advanced-search-align-',
                'selectors_dictionary' => [
                    'left'   => 'margin-right:auto;',
                    'center' => 'margin-left:auto;margin-right:auto;',
                    'right'  => 'margin-left:auto;',
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_box' => '{{VALUE}}',

                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-popular-search-section' => '{{VALUE}}',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_helper_text' => '{{VALUE}}',
                ],
            ]
        );

        /* Padding */
        $this->add_responsive_control(
            'layout2_container_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_box' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        /* Margin */
        $this->add_responsive_control(
            'layout2_container_margin',
            [
                'label'      => __('Margin', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_box' =>
                    'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        /* Border */
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_container_border',
                'label'    => __('Border', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_box',
            ]
        );

        /* Border Radius */
        $this->add_responsive_control(
            'layout2_container_border_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_box' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_input_header_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_layout2_label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs('layout2_container_box_shadow_tabs');

        $this->start_controls_tab(
            'layout2_container_box_shadow_tab_normal',
            [
                'label' => __('Normal', 'happy-addons-pro'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_container_box_shadow',
                'label'    => __('Box Shadow', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_box',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'layout2_container_box_shadow_tab_hover',
            [
                'label' => __('Hover', 'happy-addons-pro'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_container_box_shadow_hover',
                'label'    => __('Box Shadow', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_box:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'layout2_container_box_shadow_tab_focus',
            [
                'label' => __('Focus', 'happy-addons-pro'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_container_box_shadow_focus',
                'label'    => __('Box Shadow', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_box:focus-within',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();






        $this->end_controls_section();
    }

    /**
     * Search Result Style Controls
     *
     * Controls for styling search result text elements
     *
     * @since 3.5.0
     * @access protected
     */


    protected function __search_results_style_controls() {

        $this->start_controls_section(
            '_section_search_results_style',
            [
                'label' => __('Search Results', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-1',
                ],
            ]
        );

        // Height
        $this->add_responsive_control(
            'search_results_height_layout1',
            [
                'label'      => __('Height', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range'      => [
                    'px' => ['min' => 100, 'max' => 1000, 'step' => 10],
                ],
                'default' => [
                    'size' => 430,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-1 .ha_advanced_search_results_container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'results_container_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_results_container' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'results_container_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_results_container' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'results_container_margin',
            [
                'label'      => __('Margin', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_results_container' =>
                    'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'results_container_border',
                'selector' => '{{WRAPPER}} .ha_advanced_search_results_container',
            ]
        );

        $this->add_responsive_control(
            'results_container_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_results_container' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'results_container_shadow',
                'selector' => '{{WRAPPER}} .ha_advanced_search_results_container',
            ]
        );


        $this->add_control(
            'results_container_divider',
            ['type' => Controls_Manager::DIVIDER]
        );

        /**
         * =========================
         * Results Header
         * =========================
         */
        $this->add_control(
            'results_header_heading',
            [
                'label' => __('Results Title', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'results_header_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_results_header' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'results_header_typo',
                'selector' => '{{WRAPPER}} .ha_advanced_search_results_label',
            ]
        );

        $this->add_control(
            'results_header_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_results_header, {{WRAPPER}} .ha_advanced_search_results_label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'results_header_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_results_header' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'results_list_divider',
            ['type' => Controls_Manager::DIVIDER]
        );

        /**
         * =========================
         * Results List Items
         * =========================
         */
        $this->add_control(
            'results_items_heading',
            [
                'label' => __('Result Items', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        // Typography (optional separate for title)
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'results_item_title_typo',
                'label'    => __('Title Typography', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}} .ha_advanced_search_result_item .ha_advanced_search_result_name',
            ]
        );

        // Typography (optional separate for other)
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'results_item_rest_typo',
                'label'    => __('Description Typography', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}} .ha_advanced_search_result_item .ha_advanced_search_result_category, {{WRAPPER}} .ha_advanced_search_result_item .ha_advanced_search_result_excerpt',
            ]
        );


        // Item padding/margin/border/radius/shadow
        $this->add_responsive_control(
            'results_item_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_result_item' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'results_item_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_result_item' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Spacing between items (recommended)
        $this->add_responsive_control(
            'results_items_gap',
            [
                'label'      => __('Items Gap', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 40, 'step' => 1],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_results_list' => 'display:flex;flex-direction:column;gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'results_item_divider',
            ['type' => Controls_Manager::DIVIDER]
        );

        // Tabs: Normal / Hover
        $this->start_controls_tabs('results_item_tabs');

        /**
         * Normal
         */
        $this->start_controls_tab(
            'results_item_normal',
            ['label' => __('Normal', 'happy-addons-pro')]
        );

        // Item background
        $this->add_control(
            'results_item_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_result_item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Title / meta / excerpt colors
        $this->add_control(
            'results_item_title_color',
            [
                'label' => __('Title Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_result_item .ha_advanced_search_result_name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'results_item_meta_color',
            [
                'label' => __('Meta Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_result_item .ha_advanced_search_result_category' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'results_item_excerpt_color',
            [
                'label' => __('Excerpt Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_result_item .ha_advanced_search_result_excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'results_item_border',
                'selector' => '{{WRAPPER}} .ha_advanced_search_result_item',
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'results_item_shadow',
                'selector' => '{{WRAPPER}} .ha_advanced_search_result_item',
            ]
        );

        $this->end_controls_tab();

        /**
         * Hover
         */
        $this->start_controls_tab(
            'results_item_hover',
            ['label' => __('Hover', 'happy-addons-pro')]
        );

        // Item background hover
        $this->add_control(
            'results_item_bg_hover',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_result_item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Title/meta/excerpt hover colors
        $this->add_control(
            'results_item_title_color_hover',
            [
                'label' => __('Title Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_result_item:hover .ha_advanced_search_result_name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'results_item_meta_color_hover',
            [
                'label' => __('Meta Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_result_item:hover .ha_advanced_search_result_category' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'results_item_excerpt_color_hover',
            [
                'label' => __('Excerpt Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_result_item:hover .ha_advanced_search_result_excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Hover border/shadow
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'results_item_border_hover',
                'selector' => '{{WRAPPER}} .ha_advanced_search_result_item:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'results_item_shadow_hover',
                'selector' => '{{WRAPPER}} .ha_advanced_search_result_item:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        /**
         * =========================
         * Load More Button
         * =========================
         */
        $this->add_control(
            'results_load_more_headerdivider',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_control(
            'results_load_more_heading',
            [
                'label' => __('Load More', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'results_footer_load_more_bg_layout1',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_results_footer' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'results_load_more_typo',
                'selector' => '{{WRAPPER}} .ha_advanced_search_view_all_link',
            ]
        );

        // Alignment (footer)
        $this->add_responsive_control(
            'results_load_more_align',
            [
                'label'   => __('Alignment', 'happy-addons-pro'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_results_footer' => 'text-align: {{VALUE}};',
                ],
            ]
        );



        // Padding
        $this->add_responsive_control(
            'results_load_more_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_results_footer' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'results_load_more_border',
                'selector' => '{{WRAPPER}} .ha_advanced_search_view_all_link',
            ]
        );


        $this->add_control(
            'results_load_more_divider',
            ['type' => Controls_Manager::DIVIDER]
        );



        // Tabs Normal / Hover
        $this->start_controls_tabs('results_load_more_tabs');

        // Normal
        $this->start_controls_tab(
            'results_load_more_normal',
            ['label' => __('Normal', 'happy-addons-pro')]
        );

        $this->add_control(
            'results_load_more_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_view_all_link' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'results_load_more_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_view_all_link' => 'color: {{VALUE}};',
                ],
            ]
        );
        // Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'results_load_more_shadow',
                'selector' => '{{WRAPPER}} .ha_advanced_search_view_all_link',
            ]
        );

        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab(
            'results_load_more_hover',
            ['label' => __('Hover', 'happy-addons-pro')]
        );

        $this->add_control(
            'results_load_more_bg_hover',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_view_all_link:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'results_load_more_text_color_hover',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_view_all_link:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        // inside results_load_more_hover tab
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'results_load_more_shadow_hover',
                'selector' => '{{WRAPPER}} .ha_advanced_search_view_all_link:hover',
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        /**
         * =========================
         * Not Found Message
         * =========================
         */
        $this->add_control(
            'results_not_found_divider',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_control(
            'results_not_found_heading',
            [
                'label' => __('Not Found Message', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'results_not_found_typo',
                'selector' => '{{WRAPPER}} .ha_advanced_search_no_results',
            ]
        );


        $this->add_control(
            'results_not_found_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_no_results' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Alignment (text-align on the message)
        $this->add_responsive_control(
            'results_not_found_align',
            [
                'label'   => __('Alignment', 'happy-addons-pro'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_no_results' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Padding
        $this->add_responsive_control(
            'results_not_found_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_no_results' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Search Field Style Controls
     *
     * Controls for styling search field elements
     *
     * @since 3.5.0
     * @access protected
     */



    protected function __search_results_style_controls_layout2() {

        $this->start_controls_section(
            '_section_search_results_style_layout2',
            [
                'label' => __('Search Results ', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-2',
                ],
            ]
        );
        $this->add_responsive_control(
            'search_results_height_layout2',
            [
                'label'      => __('Height', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range'      => [
                    'px' => ['min' => 100, 'max' => 1000, 'step' => 10],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_results_container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_results_container_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_results_container' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout2_results_container_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_results_container' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout2_results_container_margin',
            [
                'label'      => __('Margin', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_results_container' =>
                    'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_results_container_border',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_results_container',
            ]
        );

        $this->add_responsive_control(
            'layout2_results_container_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_results_container' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_results_container_shadow',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_results_container',
            ]
        );

        $this->add_control(
            'layout2_results_container_divider',
            ['type' => Controls_Manager::DIVIDER]
        );


        /**
         * =========================
         * Results List Items
         * =========================
         */
        $this->add_control(
            'layout2_results_items_heading',
            [
                'label' => __('Result Items', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        // Typography (optional separate for title)
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout2_results_item_title_typo',
                'label'    => __('Title Typography', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item .ha_advanced_search_result-info h3',
            ]
        );

        // Typography (optional separate for other)
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout2_results_item_rest_typo',
                'label'    => __('Description Typography', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item .ha_advanced_search_result-info p',
            ]
        );


        // Item padding/margin/border/radius/shadow
        $this->add_responsive_control(
            'layout2_results_item_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout2_results_item_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Spacing between items (recommended)
        $this->add_responsive_control(
            'layout2_results_items_gap',
            [
                'label'      => __('Items Gap', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 40, 'step' => 1],
                ],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_results_list' => 'display:flex;flex-direction:column;gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'layout2_results_item_divider',
            ['type' => Controls_Manager::DIVIDER]
        );

        // Tabs: Normal / Hover
        $this->start_controls_tabs('layout2_results_item_tabs');

        /**
         * Normal
         */
        $this->start_controls_tab(
            'layout2_results_item_normal',
            ['label' => __('Normal', 'happy-addons-pro')]
        );

        // Item background
        $this->add_control(
            'layout2_results_item_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Title / meta / excerpt colors
        $this->add_control(
            'layout2_results_item_title_color',
            [
                'label' => __('Title Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item .ha_advanced_search_result_name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_results_item_meta_color',
            [
                'label' => __('Meta Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item .ha_advanced_search_result_category' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_results_item_excerpt_color',
            [
                'label' => __('Excerpt Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item .ha_advanced_search_result_excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_results_item_border',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item',
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_results_item_shadow',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item',
            ]
        );

        $this->end_controls_tab();

        /**
         * Hover
         */
        $this->start_controls_tab(
            'layout2_results_item_hover',
            ['label' => __('Hover', 'happy-addons-pro')]
        );

        // Item background hover
        $this->add_control(
            'layout2_results_item_bg_hover',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Title/meta/excerpt hover colors
        $this->add_control(
            'layout2_results_item_title_color_hover',
            [
                'label' => __('Title Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item:hover .ha_advanced_search_result_name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_results_item_meta_color_hover',
            [
                'label' => __('Meta Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item:hover .ha_advanced_search_result_category' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_results_item_excerpt_color_hover',
            [
                'label' => __('Excerpt Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item:hover .ha_advanced_search_result_excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Hover border/shadow
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_results_item_border_hover',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_results_item_shadow_hover',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_result_item:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        /**
         * =========================
         * Load More Button
         * =========================
         */
        $this->add_control(
            'layout2_results_load_more_headerdivider',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_control(
            'layout2_results_load_more_heading',
            [
                'label' => __('Load More', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'results_footer_load_more_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_results_footer' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout2_results_load_more_typo',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_view_all_link',
            ]
        );

        // Alignment (footer)
        $this->add_responsive_control(
            'layout2_results_load_more_align',
            [
                'label'   => __('Alignment', 'happy-addons-pro'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_results_footer' => 'text-align: {{VALUE}};',
                ],
            ]
        );



        // Padding
        $this->add_responsive_control(
            'layout2_results_load_more_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_view_all_link' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_results_load_more_border',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_view_all_link',
            ]
        );


        $this->add_control(
            'layout2_results_load_more_divider',
            ['type' => Controls_Manager::DIVIDER]
        );



        // Tabs Normal / Hover
        $this->start_controls_tabs('layout2_results_load_more_tabs');

        // Normal
        $this->start_controls_tab(
            'layout2_results_load_more_normal',
            ['label' => __('Normal', 'happy-addons-pro')]
        );

        $this->add_control(
            'layout2_results_load_more_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_view_all_link' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_results_load_more_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_view_all_link' => 'color: {{VALUE}};',
                ],
            ]
        );
        // Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_results_load_more_shadow',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_view_all_link',
            ]
        );

        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab(
            'layout2_results_load_more_hover',
            ['label' => __('Hover', 'happy-addons-pro')]
        );

        $this->add_control(
            'layout2_results_load_more_bg_hover',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_view_all_link:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_results_load_more_text_color_hover',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_view_all_link:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        // inside results_load_more_hover tab
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_results_load_more_shadow_hover',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_view_all_link:hover',
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        /**
         * =========================
         * Not Found Message
         * =========================
         */
        $this->add_control(
            'layout2_results_not_found_divider',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_control(
            'layout2_results_not_found_heading',
            [
                'label' => __('Not Found Message', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout2_results_not_found_typo',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_no_results',
            ]
        );


        $this->add_control(
            'layout2_results_not_found_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_no_results' => 'color: {{VALUE}};',
                ],
            ]
        );





        // Alignment (text-align on the message)
        $this->add_responsive_control(
            'layout2_results_not_found_align',
            [
                'label'   => __('Alignment', 'happy-addons-pro'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_no_results' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Padding
        $this->add_responsive_control(
            'layout2_results_not_found_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_no_results' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Search Field Style Controls
     *
     * Controls for styling search field elements
     *
     * @since 3.5.0
     * @access protected
     */


    protected function __search_field_style_controls() {

        $this->start_controls_section(
            '_section_search_field_style',
            [
                'label' => __('Search Field', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-1',
                ],
            ]
        );



        // Background (Field)
        $this->add_control(
            'sf_field_bg',
            [
                'label' => __('Background', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_input_wrapper' => 'background-color: {{VALUE}};',
                ],

            ]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'sf_text_typo',
                'selector' => '{{WRAPPER}} .ha_advanced_search_search_input',
            ]
        );

        // Text Color
        $this->add_control(
            'sf_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_input' => 'color: {{VALUE}};',
                ],
            ]
        );



        // Placeholder Color
        $this->add_control(
            'sf_placeholder_color',
            [
                'label' => __('Placeholder Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_input::placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_search_input::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_search_input::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_search_input:-ms-input-placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );


        // Alignment
        $this->add_responsive_control(
            'sf_text_align',
            [
                'label' => __('Alignment', 'happy-addons-pro'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_input' => 'text-align: {{VALUE}};',
                ],
            ]
        );





        // Padding (wrapper)
        $this->add_responsive_control(
            'sf_field_padding',
            [
                'label' => __('Padding', 'happy-addons-pro'),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_input_wrapper' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'sf_field_border',
                'label'    => __('Border', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}} .ha_advanced_search_input_wrapper',
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'sf_field_radius',
            [
                'label' => __('Border Radius', 'happy-addons-pro'),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_input_wrapper' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Optional shadow (often requested for field)
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'sf_field_shadow',
                'selector' => '{{WRAPPER}} .ha_advanced_search_input_wrapper',
            ]
        );

        /**
         * Separator
         */
        $this->add_control(
            'sf_sep_1',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );


        /**
         * ICON
         * Targets: .ha_advanced_search_search_icon i (and svg if you ever switch)
         */
        $this->add_control(
            'sf_icon_heading',
            [
                'label' => __('Icon', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );
        // Icon color
        $this->add_control(
            'sf_icon_color',
            [
                'label' => __('Icon Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_icon'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_search_icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_search_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );


        // Icon size
        $this->add_responsive_control(
            'sf_icon_size',
            [
                'label' => __('Icon Size', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 80],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ha_advanced_search_search_icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Optional: spacing between icon and input text
        $this->add_responsive_control(
            'sf_icon_gap',
            [
                'label' => __('Icon Gap', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_input_wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
    }


    /**
     * Search Button Style Controls
     *
     * Controls for styling search button
     *
     * @since 3.5.0
     * @access protected
     */


    protected function __search_field_style_controls_layout2() {

        $this->start_controls_section(
            '_section_search_field_style_layout2',
            [
                'label' => __('Search Field ', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-2',
                ],
            ]
        );



        // Background (Field)
        $this->add_control(
            'layout2_sf_field_bg',
            [
                'label' => __('Background', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_search_input_wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout2_sf_text_typo',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_input',
            ]
        );

        // Text Color
        $this->add_control(
            'layout2_sf_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_input' => 'color: {{VALUE}};',
                ],
            ]
        );



        // Placeholder Color
        $this->add_control(
            'layout2_sf_placeholder_color',
            [
                'label' => __('Placeholder Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_input::placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_input::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_input::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_input:-ms-input-placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );


        // Alignment
        $this->add_responsive_control(
            'layout2_sf_text_align',
            [
                'label' => __('Alignment', 'happy-addons-pro'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_input' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        // Padding (wrapper)
        $this->add_responsive_control(
            'layout2_sf_field_padding',
            [
                'label' => __('Padding', 'happy-addons-pro'),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_search_input_wrapper' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_sf_field_border',
                'label'    => __('Border', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_search_input_wrapper',
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'layout2_sf_field_radius',
            [
                'label' => __('Border Radius', 'happy-addons-pro'),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_search_input_wrapper' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Optional shadow (often requested for field)
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_sf_field_shadow',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_search_input_wrapper',
            ]
        );

        /**
         * Separator
         */
        $this->add_control(
            'layout2_sf_sep_1',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        /**
         * ICON
         * Targets: .ha_advanced_search_layout2_icon i (and svg if you ever switch)
         */
        $this->add_control(
            'layout2_sf_icon_heading',
            [
                'label' => __('Icon', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );
        // Icon color
        $this->add_control(
            'layout2_sf_icon_color',
            [
                'label' => __('Icon Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_search_input_wrapper .ha_advanced_search_layout2_icon'   => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_search_input_wrapper .ha_advanced_search_layout2_icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_search_input_wrapper.ha_advanced_search_layout2_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );


        // Icon size
        $this->add_responsive_control(
            'layout2_sf_icon_size',
            [
                'label' => __('Icon Size', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 80],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_search_input_wrapper  .ha_advanced_search_layout2_icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_search_input_wrapper .ha_advanced_search_layout2_icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Optional: spacing between icon and input text
        $this->add_responsive_control(
            'layout2_sf_icon_gap',
            [
                'label' => __('Icon Gap', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_search_input_wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
    }


    /**
     * Search Button Style Controls
     *
     * Controls for styling search button
     *
     * @since 3.5.0
     * @access protected
     */

    protected function __search_button_style_controls() {

        $this->start_controls_section(
            '_section_search_button_style',
            [
                'label' => __('Search Button', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-1',
                ],
            ]
        );


        // Width
        $this->add_responsive_control(
            'search_button_width',
            [
                'label'      => __('Width', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range'      => [
                    'px' => ['min' => 40, 'max' => 600, 'step' => 5],
                    '%'  => ['min' => 5,  'max' => 100],
                    'vw' => ['min' => 5,  'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_button' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Height
        $this->add_responsive_control(
            'search_button_height',
            [
                'label'      => __('Height', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range'      => [
                    'px' => ['min' => 28, 'max' => 120, 'step' => 1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_button' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'search_button_typography',
                'selector' => '{{WRAPPER}} .ha_advanced_search_search_button',
                'global'   => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT,
                ],
            ]
        );


        // Padding
        $this->add_responsive_control(
            'search_button_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_search_button' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        // Border Radius placed here (before icon controls)
        $this->add_responsive_control(
            'search_button_border_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_search_button' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Flex alignment always (prevents icon "upper" issue)
        $this->add_control(
            'search_button_display_flex',
            [
                'type'    => Controls_Manager::HIDDEN,
                'default' => '1',
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_button' => 'display:flex;align-items:center;justify-content:center;',
                    '{{WRAPPER}} .ha_advanced_search_search_button .ha_advanced_search_button_icon' => 'display:inline-flex;align-items:center;line-height:1;',
                    '{{WRAPPER}} .ha_advanced_search_search_button .ha_advanced_search_button_text' => 'line-height:1;',
                ],
            ]
        );

        // Button content alignment (icon + text)
        $this->add_responsive_control(
            'search_button_content_alignment',
            [
                'label'   => __('Content Alignment', 'happy-addons-pro'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_button' => 'justify-content: {{VALUE}};',
                ],
            ]
        );


        // Tabs
        $this->start_controls_tabs('search_button_style_tabs');

        /**
         * NORMAL TAB
         */
        $this->start_controls_tab(
            'search_button_tab_normal',
            ['label' => __('Normal', 'happy-addons-pro')]
        );

        $this->add_control(
            'search_button_bg_color',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'search_button_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_button' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Border (normal) - has native reset
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'search_button_border',
                'selector' => '{{WRAPPER}} .ha_advanced_search_search_button',
            ]
        );





        // Box shadow (normal)
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'search_button_shadow',
                'selector' => '{{WRAPPER}} .ha_advanced_search_search_button',
            ]
        );

        // ---- ICON (Normal) ----
        $this->add_control(
            'search_button_icon_heading',
            [
                'label'     => __('Icon', 'happy-addons-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'search_button_icon_color',
            [
                'label' => __('Icon Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_button .ha_advanced_search_button_icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_search_button .ha_advanced_search_button_icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_search_button .ha_advanced_search_button_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'search_button_icon_size',
            [
                'label' => __('Icon Size', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 8, 'max' => 80],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_button .ha_advanced_search_button_icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ha_advanced_search_search_button .ha_advanced_search_button_icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'search_button_icon_gap',
            [
                'label' => __('Icon Gap', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 40],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_button' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        /**
         * HOVER TAB
         */
        $this->start_controls_tab(
            'search_button_tab_hover',
            ['label' => __('Hover', 'happy-addons-pro')]
        );

        $this->add_control(
            'search_button_bg_color_hover',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'search_button_text_color_hover',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Hover box shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'search_button_shadow_hover',
                'selector' => '{{WRAPPER}} .ha_advanced_search_search_button:hover',
            ]
        );

        $this->add_control(
            'search_button_icon_color_hover',
            [
                'label' => __('Icon Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_search_button:hover .ha_advanced_search_button_icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_search_button:hover .ha_advanced_search_button_icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_search_button:hover .ha_advanced_search_button_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }



    /**
     * Category List Style Controls
     *
     * Controls for styling category list elements
     *
     * @since 3.5.0
     * @access protected
     */



    protected function __search_button_style_controls_layout2() {

        $this->start_controls_section(
            '_section_search_button_style_layout2',
            [
                'label' => __('Search Button ', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-2',
                ],
            ]
        );


        // Width
        $this->add_responsive_control(
            'layout2_search_button_width',
            [
                'label'      => __('Width', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range'      => [
                    'px' => ['min' => 40, 'max' => 600, 'step' => 5],
                    '%'  => ['min' => 5,  'max' => 100],
                    'vw' => ['min' => 5,  'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Height
        $this->add_responsive_control(
            'layout2_search_button_height',
            [
                'label'      => __('Height', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range'      => [
                    'px' => ['min' => 28, 'max' => 120, 'step' => 1],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout2_search_button_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button',
                'global'   => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT,
                ],
            ]
        );


        // Padding
        $this->add_responsive_control(
            'layout2_search_button_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        // Border Radius placed here (before icon controls)
        $this->add_responsive_control(
            'layout2_search_button_border_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout2_search_button_alignment',
            [
                'label' => __('Alignment', 'happy-addons-pro'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => ['title' => __('Left', 'happy-addons-pro'),   'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => __('Center', 'happy-addons-pro'), 'icon' => 'eicon-text-align-center'],
                    'right'  => ['title' => __('Right', 'happy-addons-pro'),  'icon' => 'eicon-text-align-right'],
                ],
                'default' => 'left',

                // adds class on wrapper:
                // ha-advanced-search-layout2-btn-align-left / center / right
                'prefix_class' => 'ha-advanced-search-layout2-btn-align-',

                'condition' => [
                    'layout2_button_inline!' => 'yes',
                    'search_layout' => 'layout-2', // add this too
                ],
            ]
        );

        // Button content alignment (icon + text)
        $this->add_responsive_control(
            'layout2_search_button_content_alignment',
            [
                'label'   => __('Content Alignment', 'happy-addons-pro'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button' => 'justify-content: {{VALUE}};',
                ],
            ]
        );


        // Tabs
        $this->start_controls_tabs('layout2_search_button_style_tabs');

        /**
         * NORMAL TAB
         */
        $this->start_controls_tab(
            'layout2_search_button_tab_normal',
            ['label' => __('Normal', 'happy-addons-pro')]
        );

        $this->add_control(
            'layout2_search_button_bg_color',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_search_button_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Border (normal) - has native reset
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_search_button_border',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button',
            ]
        );





        // Box shadow (normal)
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_search_button_shadow',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button',
            ]
        );

        // ---- ICON (Normal) ----
        $this->add_control(
            'layout2_search_button_icon_heading',
            [
                'label'     => __('Icon', 'happy-addons-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'layout2_search_button_icon_color',
            [
                'label' => __('Icon Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button .ha_advanced_search_button_icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button .ha_advanced_search_button_icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button .ha_advanced_search_button_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout2_search_button_icon_size',
            [
                'label' => __('Icon Size', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 8, 'max' => 80],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button .ha_advanced_search_button_icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button .ha_advanced_search_button_icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout2_search_button_icon_gap',
            [
                'label' => __('Icon Gap', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 40],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        /**
         * HOVER TAB
         */
        $this->start_controls_tab(
            'layout2_search_button_tab_hover',
            ['label' => __('Hover', 'happy-addons-pro')]
        );

        $this->add_control(
            'layout2_search_button_bg_color_hover',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_search_button_text_color_hover',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Hover box shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_search_button_shadow_hover',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button:hover',
            ]
        );

        $this->add_control(
            'layout2_search_button_icon_color_hover',
            [
                'label' => __('Icon Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button:hover .ha_advanced_search_button_icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button:hover .ha_advanced_search_button_icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_search_button:hover .ha_advanced_search_button_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }



    /**
     * Category List Style Controls
     *
     * Controls for styling category list elements
     *
     * @since 3.5.0
     * @access protected
     */


    protected function __category_dropdown_style_controls() {

        $this->start_controls_section(
            '_section_category_dropdown_style',
            [
                'label' => __('Category List', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_category_list' => 'yes',
                    'search_layout' => 'layout-1',
                ],
            ]
        );


        // Width
        $this->add_responsive_control(
            'category_dropdown_width',
            [
                'label'      => __('Width', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => ['min' => 50, 'max' => 600, 'step' => 1],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_category_select' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );



        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'category_dropdown_typography',
                'selector' => '{{WRAPPER}} .ha_advanced_search_category_select',
                'global'   => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        // Category select text alignment
        $this->add_responsive_control(
            'category_dropdown_text_alignment',
            [
                'label'   => __('Text Alignment', 'happy-addons-pro'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_category_select' => 'text-align: {{VALUE}}; text-align-last: {{VALUE}};',
                ],
            ]
        );



        // Padding
        $this->add_responsive_control(
            'category_dropdown_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_category_select' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'category_dropdown_border_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_category_select' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'category_dropdown_box_shadow',
                'selector' => '{{WRAPPER}} .ha_advanced_search_category_select',
            ]
        );

        // Divider before tabs
        $this->add_control(
            'category_dropdown_divider_states',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        /**
         * Tabs: Normal / Hover / Focus
         */
        $this->start_controls_tabs('category_dropdown_tabs');

        /**
         * NORMAL
         */
        $this->start_controls_tab(
            'category_dropdown_normal',
            ['label' => __('Normal', 'happy-addons-pro')]
        );

        $this->add_control(
            'category_dropdown_bg_color',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_category_select' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'category_dropdown_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_category_select' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_category_wrapper::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        // Border (type/width/color)
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'category_dropdown_border',
                'selector' => '{{WRAPPER}} .ha_advanced_search_category_select',
            ]
        );

        $this->end_controls_tab();

        /**
         * HOVER
         */
        $this->start_controls_tab(
            'category_dropdown_hover',
            ['label' => __('Hover', 'happy-addons-pro')]
        );

        $this->add_control(
            'category_dropdown_bg_color_hover',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_category_select:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'category_dropdown_text_color_hover',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_category_select:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_category_wrapper:hover::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        /**
         * FOCUS
         */
        $this->start_controls_tab(
            'category_dropdown_focus',
            ['label' => __('Focus', 'happy-addons-pro')]
        );

        $this->add_control(
            'category_dropdown_bg_color_focus',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_category_select:focus-within' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'category_dropdown_text_color_focus',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_category_select:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_category_wrapper:focus-within::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }



    protected function __category_dropdown_style_controls_layout2() {

        $this->start_controls_section(
            '_section_category_dropdown_style_layout2',
            [
                'label' => __('Category List', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-2',
                    'layout2_show_category_list' => 'yes',
                ],
            ]
        );


        // Width
        $this->add_responsive_control(
            'layout2_category_dropdown_width',
            [
                'label'      => __('Width', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => ['min' => 50, 'max' => 600, 'step' => 1],
                    '%'  => ['min' => 10, 'max' => 100, 'step' => 1],
                ],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_category_select' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );



        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout2_category_dropdown_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_category_select',
                'global'   => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        // Category select text alignment
        $this->add_responsive_control(
            'layout2_category_dropdown_text_alignment',
            [
                'label'   => __('Text Alignment', 'happy-addons-pro'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_category_select' => 'text-align: {{VALUE}}; text-align-last: {{VALUE}};',
                ],
            ]
        );



        // Padding
        $this->add_responsive_control(
            'layout2_category_dropdown_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_category' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'layout2_category_dropdown_border_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_category' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_category_dropdown_box_shadow',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_category_select',
            ]
        );

        // Divider before tabs
        $this->add_control(
            'layout2_category_dropdown_divider_states',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        /**
         * Tabs: Normal / Hover / Focus
         */
        $this->start_controls_tabs('layout2_category_dropdown_tabs');

        /**
         * NORMAL
         */
        $this->start_controls_tab(
            'layout2_category_dropdown_normal',
            ['label' => __('Normal', 'happy-addons-pro')]
        );

        $this->add_control(
            'layout2_category_dropdown_bg_color',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_category' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'layout2_category_dropdown_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_category_select' => 'color: {{VALUE}};',
                ],
            ]
        );


        // Border (type/width/color)
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_category_dropdown_border',
                //'selector' => 
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_category',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_category:focus',
                ],
            ]
        );

        $this->end_controls_tab();

        /**
         * HOVER
         */
        $this->start_controls_tab(
            'layout2_category_dropdown_hover',
            ['label' => __('Hover', 'happy-addons-pro')]
        );

        $this->add_control(
            'layout2_category_dropdown_bg_color_hover',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_category:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_category_dropdown_text_color_hover',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_category_select:hover' => 'color: {{VALUE}};',
                ],
            ]
        );



        // Hover border (type/width/color)
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_category_dropdown_border_hover',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_category:hover',
            ]
        );

        $this->end_controls_tab();

        /**
         * FOCUS
         */
        $this->start_controls_tab(
            'layout2_category_dropdown_focus',
            ['label' => __('Focus', 'happy-addons-pro')]
        );

        $this->add_control(
            'layout2_category_dropdown_bg_color_focus',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_category:focus-within' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_category_dropdown_text_color_focus',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_category_select:focus' => 'color: {{VALUE}};',
                ],
            ]
        );


        // Remove default outline/box-shadow on focus (optional but usually needed)
        $this->add_control(
            'layout2_category_dropdown_focus_reset_outline',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => '1',
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_category_select:focus' => 'outline: none;',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        /**
         * ICON
         * Targets: .ha_advanced_search_layout2_icon i (and svg if you ever switch)
         */

        $this->add_control(
            'layout2_category_logo_divider',
            ['type' => Controls_Manager::DIVIDER]
        );
        $this->add_control(
            'layout2_sf_icon_heading_category',
            [
                'label' => __('Icon', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );
        // Icon color
        $this->add_control(
            'layout2_sf_icon_color_category',
            [
                'label' => __('Icon Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_category .ha_advanced_search_layout2_icon'   => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_category .ha_advanced_search_layout2_icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_category .ha_advanced_search_layout2_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );


        // Icon size
        $this->add_responsive_control(
            'layout2_sf_icon_size_category',
            [
                'label' => __('Icon Size', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 80],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_category  .ha_advanced_search_layout2_icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_category .ha_advanced_search_layout2_icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Optional: spacing between icon and input text
        $this->add_responsive_control(
            'layout2_sf_icon_gap_category',
            [
                'label' => __('Icon Gap', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_category' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function __date_dropdown_style_controls() {
        $this->start_controls_section(
            '_section_date_list_style',
            [
                'label' => __('Date Filter', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_date_filter' => 'yes',
                    'search_layout' => 'layout-1',
                ],
            ]
        );

        /**
         * =========================
         * DATE SELECT (.ha_advanced_search_date_select)
         * =========================
         */

        // Width
        $this->add_responsive_control(
            'date_dropdown_width',
            [
                'label'      => __('Width', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => ['min' => 50, 'max' => 600, 'step' => 1],

                ],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_date_select' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'date_dropdown_typography',
                'selector' => '{{WRAPPER}} .ha_advanced_search_date_select',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        // Date select text alignment
        $this->add_responsive_control(
            'date_dropdown_text_alignment',
            [
                'label'   => __('Text Alignment', 'happy-addons-pro'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_date_select' => 'text-align: {{VALUE}}; text-align-last: {{VALUE}};',
                ],
            ]
        );



        // Padding
        $this->add_responsive_control(
            'date_dropdown_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_date_select' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'date_dropdown_border_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_date_select' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box Shadow (shared)
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'date_dropdown_box_shadow',
                'selector' => '{{WRAPPER}} .ha_advanced_search_date_select',
            ]
        );

        $this->add_control('date_dropdown_divider_states', ['type' => Controls_Manager::DIVIDER]);

        // Tabs for select: Normal / Hover / Focus
        $this->start_controls_tabs('date_dropdown_tabs');

        // Normal
        $this->start_controls_tab('date_dropdown_normal', ['label' => __('Normal', 'happy-addons-pro')]);
        $this->add_control(
            'date_dropdown_bg_color',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_date_select' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'date_dropdown_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_date_select' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_date_wrapper::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );



        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'date_dropdown_border',
                'selector' => '{{WRAPPER}} .ha_advanced_search_date_select',
            ]
        );

        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab('date_dropdown_hover', ['label' => __('Hover', 'happy-addons-pro')]);

        $this->add_control(
            'date_dropdown_bg_color_hover',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_date_select:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'date_dropdown_text_color_hover',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_date_select:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_date_wrapper:hover::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Focus
        $this->start_controls_tab('date_dropdown_focus', ['label' => __('Focus', 'happy-addons-pro')]);



        $this->add_control(
            'date_dropdown_bg_color_focus',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_date_select:focus-within' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'date_dropdown_text_color_focus',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_date_select:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_date_wrapper:focus-within::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        /**
         * =========================
         * DATE RANGE WRAPPER (.ha_advanced_search_date_range)
         * =========================
         */
        $this->add_control(
            'date_range_divider',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_control(
            'date_range_heading',
            [
                'label' => __('Date Range', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'date_range_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_date_range' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // (Optional) Apply label color from Elementor too
        $this->add_control(
            'date_label_color',
            [
                'label' => __('Label Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_date_label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'date_icon_color',
            [
                'label' => __('Icon Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_date_icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_date_icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ha_advanced_search_date_icon svg' => 'fill: {{VALUE}};',

                ],
            ]
        );


        $this->add_responsive_control(
            'date_range_margin_top',
            [
                'label'      => __('Top Spacing', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 60, 'step' => 1],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_date_range' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'date_range_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_date_range' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'date_range_border',
                'selector' => '{{WRAPPER}} .ha_advanced_search_date_range',
            ]
        );

        $this->add_responsive_control(
            'date_range_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_date_range' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'date_range_shadow',
                'selector' => '{{WRAPPER}} .ha_advanced_search_date_range',
            ]
        );

        /**
         * =========================
         * DATE INPUTS (.ha_advanced_search_date_from, .ha_advanced_search_date_to)
         * =========================
         */
        $this->add_control(
            'date_inputs_divider',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_control(
            'date_inputs_heading',
            [
                'label' => __('Date Inputs', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        // Width for each input
        $this->add_responsive_control(
            'date_input_width',
            [
                'label'      => __('Input Width', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => ['min' => 80, 'max' => 600, 'step' => 1],
                    '%'  => ['min' => 10, 'max' => 100, 'step' => 1],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_date_input_wrap' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        // Typography (inputs)
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'date_inputs_typo',
                'selector' => '{{WRAPPER}} .ha_advanced_search_date_from, {{WRAPPER}} .ha_advanced_search_date_to',
            ]
        );


        // Padding
        $this->add_responsive_control(
            'date_input_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_date_from, {{WRAPPER}} .ha_advanced_search_date_to' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border radius (inputs)
        $this->add_responsive_control(
            'date_input_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .ha_advanced_search_date_from, {{WRAPPER}} .ha_advanced_search_date_to' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Shadow (inputs) - shared
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'date_input_shadow',
                'selector' => '{{WRAPPER}} .ha_advanced_search_date_from, {{WRAPPER}} .ha_advanced_search_date_to',
            ]
        );

        $this->add_control(
            'date_input_divider',
            ['type' => Controls_Manager::DIVIDER]
        );

        // Tabs: Normal / Focus (for inputs)
        $this->start_controls_tabs('date_inputs_tabs');

        // Normal
        $this->start_controls_tab('date_inputs_normal', ['label' => __('Normal', 'happy-addons-pro')]);
        $this->add_control(
            'date_input_bg_color',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_date_from, {{WRAPPER}} .ha_advanced_search_date_to' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'date_input_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_date_from, {{WRAPPER}} .ha_advanced_search_date_to' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'date_input_border',
                'selector' => '{{WRAPPER}} .ha_advanced_search_date_from, {{WRAPPER}} .ha_advanced_search_date_to',
            ]
        );

        $this->end_controls_tab();

        // Focus
        $this->start_controls_tab('date_inputs_focus', ['label' => __('Focus', 'happy-addons-pro')]);


        $this->add_control(
            'date_input_bg_color_focus',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_date_from:focus, {{WRAPPER}} .ha_advanced_search_date_to:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'date_input_text_color_focus',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_date_from:focus, {{WRAPPER}} .ha_advanced_search_date_to:focus' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'date_input_border_focus',
                'selector' => '{{WRAPPER}} .ha_advanced_search_date_from:focus, {{WRAPPER}} .ha_advanced_search_date_to:focus',
            ]
        );

        // Remove default outline
        $this->add_control(
            'date_input_focus_reset_outline',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => '1',
                'selectors' => [
                    '{{WRAPPER}} .ha_advanced_search_date_from:focus, {{WRAPPER}} .ha_advanced_search_date_to:focus' => 'outline: none;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }


    /**
     * Popular Search  Style Controls
     *
     * Controls for styling popular search text elements
     *
     * @since 3.5.0
     * @access protected
     */



    protected function __date_dropdown_style_controls_layout2() {
        $this->start_controls_section(
            '_section_date_list_style_layout2',
            [
                'label' => __('Date Filter ', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-2',
                    'layout2_show_date_filter' => 'yes',
                ],
            ]
        );

        /**
         * =========================
         * DATE SELECT (.ha_advanced_search_date_select)
         * =========================
         */

        // Width
        $this->add_responsive_control(
            'layout2_date_dropdown_width',
            [
                'label'      => __('Width', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => ['min' => 50, 'max' => 600, 'step' => 1],
                    '%'  => ['min' => 10, 'max' => 100, 'step' => 1],
                ],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_select' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'layout2_date_dropdown_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_select',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        // Date select text alignment
        $this->add_responsive_control(
            'layout2_date_dropdown_text_alignment',
            [
                'label'   => __('Text Alignment', 'happy-addons-pro'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_select' => 'text-align: {{VALUE}}; text-align-last: {{VALUE}};',
                ],
            ]
        );



        // Padding
        $this->add_responsive_control(
            'layout2_date_dropdown_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_date' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'layout2_date_dropdown_border_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_date' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box Shadow (shared)
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_date_dropdown_box_shadow',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_select',
            ]
        );

        $this->add_control('layout2_date_dropdown_divider_states', ['type' => Controls_Manager::DIVIDER]);

        // Tabs for select: Normal / Hover / Focus
        $this->start_controls_tabs('layout2_date_dropdown_tabs');

        // Normal
        $this->start_controls_tab('layout2_date_dropdown_normal', ['label' => __('Normal', 'happy-addons-pro')]);
        $this->add_control(
            'layout2_date_dropdown_bg_color',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_date' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_date_dropdown_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_select' => 'color: {{VALUE}};',
                ],
            ]
        );



        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_date_dropdown_border',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_date',
            ]
        );

        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab('layout2_date_dropdown_hover', ['label' => __('Hover', 'happy-addons-pro')]);

        $this->add_control(
            'layout2_date_dropdown_bg_color_hover',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_date:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'layout2_date_dropdown_text_color_hover',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_select:hover' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_date_dropdown_border_hover',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_date:hover',
            ]
        );

        $this->end_controls_tab();

        // Focus
        $this->start_controls_tab('layout2_date_dropdown_focus', ['label' => __('Focus', 'happy-addons-pro')]);



        $this->add_control(
            'layout2_date_dropdown_bg_color_focus',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_date:focus-within' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'layout2_date_dropdown_text_color_focus',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_select:focus' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_date_dropdown_border_focus',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_select:focus',
            ]
        );

        // Remove default outline (keep Elementor controls styling clean)
        $this->add_control(
            'layout2_date_dropdown_focus_reset_outline',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => '1',
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_select:focus' => 'outline: none;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        /* ICON
         * Targets: .ha_advanced_search_layout2_icon i (and svg if you ever switch)
         */

        $this->add_control(
            'layout2_date_logo_divider',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_control(
            'layout2_sf_icon_heading_date',
            [
                'label' => __('Icon', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );
        // Icon color
        $this->add_control(
            'layout2_sf_icon_color_date',
            [
                'label' => __('Icon Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_date .ha_advanced_search_layout2_icon'   => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_date .ha_advanced_search_layout2_icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_date .ha_advanced_search_layout2_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );


        // Icon size
        $this->add_responsive_control(
            'layout2_sf_icon_size_date',
            [
                'label' => __('Icon Size', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 80],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_date  .ha_advanced_search_layout2_icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_date .ha_advanced_search_layout2_icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Optional: spacing between icon and input text
        $this->add_responsive_control(
            'layout2_sf_icon_gap_date',
            [
                'label' => __('Icon Gap', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_layout2_select_wrapper_date' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );



        /**
         * =========================
         * DATE RANGE WRAPPER (.ha_advanced_search_date_range)
         * =========================
         */
        $this->add_control(
            'layout2_date_range_divider',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_control(
            'layout2_date_range_heading',
            [
                'label' => __('Date Range', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'layout2_date_range_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_range' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // (Optional) Apply label color from Elementor too
        $this->add_control(
            'layout2_date_label_color',
            [
                'label' => __('Label Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_date_icon_color',
            [
                'label' => __('Icon Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_icon svg' => 'fill: {{VALUE}};',

                ],
            ]
        );


        $this->add_responsive_control(
            'layout2_date_range_margin_top',
            [
                'label'      => __('Top Spacing', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 60, 'step' => 1],
                ],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_range' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout2_date_range_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_range' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_date_range_border',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_range',
            ]
        );

        $this->add_responsive_control(
            'layout2_date_range_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_range' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_date_range_shadow',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_range',
            ]
        );

        /**
         * =========================
         * DATE INPUTS (.ha_advanced_search_date_from, .ha_advanced_search_date_to)
         * =========================
         */
        $this->add_control(
            'layout2_date_inputs_divider',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_control(
            'layout2_date_inputs_heading',
            [
                'label' => __('Date Inputs', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        // Width for each input
        $this->add_responsive_control(
            'layout2_date_input_width',
            [
                'label'      => __('Input Width', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => ['min' => 80, 'max' => 600, 'step' => 1],
                    '%'  => ['min' => 10, 'max' => 100, 'step' => 1],
                ],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_input_wrap' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        // Typography (inputs)
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'layout2_date_inputs_typo',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_from, {{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_to',
            ]
        );


        // Padding
        $this->add_responsive_control(
            'layout2_date_input_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_from, {{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_to' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border radius (inputs)
        $this->add_responsive_control(
            'layout2_date_input_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_from, {{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_to' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Shadow (inputs) - shared
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_date_input_shadow',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_from, {{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_to',
            ]
        );

        $this->add_control(
            'layout2_date_input_divider',
            ['type' => Controls_Manager::DIVIDER]
        );

        // Tabs: Normal / Focus (for inputs)
        $this->start_controls_tabs('layout2_date_inputs_tabs');

        // Normal
        $this->start_controls_tab('layout2_date_inputs_normal', ['label' => __('Normal', 'happy-addons-pro')]);
        $this->add_control(
            'layout2_date_input_bg_color',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_from, {{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_to' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_date_input_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_from, {{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_to' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_date_input_border',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_from, {{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_to',
            ]
        );

        $this->end_controls_tab();

        // Focus
        $this->start_controls_tab('layout2_date_inputs_focus', ['label' => __('Focus', 'happy-addons-pro')]);


        $this->add_control(
            'layout2_date_input_bg_color_focus',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_from:focus, {{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_to:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'layout2_date_input_text_color_focus',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_from:focus, {{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_to:focus' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_date_input_border_focus',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_from:focus, {{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_to:focus',
            ]
        );

        // Remove default outline
        $this->add_control(
            'layout2_date_input_focus_reset_outline',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => '1',
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_from:focus, {{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha_advanced_search_date_to:focus' => 'outline: none;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }


    /**
     * Popular Search  Style Controls
     *
     * Controls for styling popular search text elements
     *
     * @since 3.5.0
     * @access protected
     */


    protected function __popular_search_style_controls() {

        $this->start_controls_section(
            '_section_popular_search_style',
            [
                'label' => __('Popular Search', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-1',
                ],
            ]
        );

        $this->add_control(
            'ps_container_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha-advanced-search-popular-search-section' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'ps_container_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ha-advanced-search-popular-search-section' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border (includes width/style/color)
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'ps_container_border',
                'selector' => '{{WRAPPER}} .ha-advanced-search-popular-search-section',
            ]
        );

        $this->add_responsive_control(
            'ps_container_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .ha-advanced-search-popular-search-section' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        /**
         * =========================
         * Title
         * =========================
         */
        $this->add_control(
            'ps_title_heading',
            [
                'label'     => __('Title', 'happy-addons-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'ps_title_typography',
                'selector' => '{{WRAPPER}} .ha-advanced-search-popular-search-title',
            ]
        );

        $this->add_control(
            'ps_title_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha-advanced-search-popular-search-title' => 'color: {{VALUE}};',
                ],
            ]
        );



        $this->add_responsive_control(
            'ps_section_align',
            [
                'label'   => __('Alignment', 'happy-addons-pro'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'space-between' => [
                        'title' => __('Space Between', 'happy-addons-pro'),
                        'icon'  => 'eicon-justify-space-between-h',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .ha-advanced-search-popular-search-section' =>
                    'display:flex;align-items:center;justify-content: {{VALUE}};',
                ],
            ]
        );

        /**
         * =========================
         * Keyword Item
         * =========================
         */
        $this->add_control(
            'ps_keyword_heading',
            [
                'label'     => __('Keyword Item', 'happy-addons-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );




        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'ps_keyword_typography',
                'selector' => '{{WRAPPER}} .ha-advanced-search-keyword',
            ]
        );

        $this->add_responsive_control(
            'ps_keyword_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ha-advanced-search-keyword' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'ps_keyword_margin',
            [
                'label'      => __('Margin', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ha-advanced-search-keyword' =>
                    'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border (includes width/style/color)
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'ps_keyword_border',
                'selector' => '{{WRAPPER}} .ha-advanced-search-keyword',
            ]
        );

        $this->add_responsive_control(
            'ps_keyword_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .ha-advanced-search-keyword' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'ps_keyword_1',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        // Normal / Hover
        $this->start_controls_tabs('ps_keyword_tabs');

        // Normal
        $this->start_controls_tab(
            'ps_keyword_tab_normal',
            ['label' => __('Normal', 'happy-addons-pro')]
        );

        $this->add_control(
            'ps_keyword_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha-advanced-search-keyword' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'ps_keyword_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha-advanced-search-keyword' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'ps_keyword_shadow',
                'selector' => '{{WRAPPER}} .ha-advanced-search-keyword',
            ]
        );

        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab(
            'ps_keyword_tab_hover',
            ['label' => __('Hover', 'happy-addons-pro')]
        );

        $this->add_control(
            'ps_keyword_bg_hover',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha-advanced-search-keyword:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'ps_keyword_text_color_hover',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha-advanced-search-keyword:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'ps_keyword_shadow_hover',
                'selector' => '{{WRAPPER}} .ha-advanced-search-keyword:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function __search_container_controls_layout3() {
        $this->start_controls_section(
            'section_container_style_layout3',
            [
                'label' => __('Search Bar', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-3',
                ],
            ]
        );

        $this->add_control(
            'layout3_container_background',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_globalnav-item.ha_advanced_search_search-trigger' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout3_container_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_globalnav-item.ha_advanced_search_search-trigger' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout3_container_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'default' => [
                    'top' => 5,
                    'right' => 5,
                    'bottom' => 5,
                    'left' => 5,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_globalnav-item.ha_advanced_search_search-trigger' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'layout3_container_search_field_heading',
            [
                'label' => __('Search Field', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'layout3_initial_field_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-input-initial' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout3_initial_field_placeholder_color',
            [
                'label' => __('Placeholder Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-input-initial::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout3_initial_field_icon_color',
            [
                'label' => __('Icon Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-icon-svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'layout3_field_icon_gap',
            [
                'label' => __('Icon Gap', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_globalnav-item.ha_advanced_search_search-trigger' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout3_initial_field_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-input-initial' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'layout3_initial_field_border',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-input-initial',
            ]
        );

        $this->add_responsive_control(
            'layout3_initial_field_border_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-input-initial' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function __search_results_style_controls_layout3() {
        $this->start_controls_section(
            '_section_search_results_style_layout3',
            [
                'label' => __('Search Results', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-3',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Typography', 'happy-addons-pro'),
                'name'     => 'layout3_results_items_title_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-results .ha_advanced_search_search_results_title',
            ]
        );

        $this->add_control(
            'layout3_results_items_title_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-results .ha_advanced_search_search_results_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'layout3_results_items_title_bottom_gap',
            [
                'label' => __('Gap', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-results .ha_advanced_search_search_results_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );




        $this->add_control(
            'layout3_results_items_heading',
            [
                'label' => __('Items List', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout3_results_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_result-item .ha_advanced_search_result-title',
            ]
        );

        $this->start_controls_tabs('layout3_results_text_color_tabs');

        $this->start_controls_tab(
            'layout3_results_text_color_normal_tab',
            [
                'label' => __('Normal', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout3_results_text_color_normal',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_result-item' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_result-item .ha_advanced_search_result-title' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'layout3_results_text_color_hover_tab',
            [
                'label' => __('Hover', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout3_results_text_color_hover',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_result-item:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_result-item:hover .ha_advanced_search_result-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'layout3_load_more_heading',
            [
                'label' => __('Load More', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout3_load_more_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_view_all_link',
            ]
        );

        $this->start_controls_tabs('layout3_load_more_color_tabs');

        $this->start_controls_tab(
            'layout3_load_more_color_normal_tab',
            [
                'label' => __('Normal', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout3_load_more_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_view_all_link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'layout3_load_more_color_hover_tab',
            [
                'label' => __('Hover', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout3_load_more_color_hover',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_view_all_link:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'layout3_no_result_heading',
            [
                'label' => __('No Result', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout3_no_result_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_no_results',
            ]
        );

        $this->add_control(
            'layout3_no_result_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_no_results' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function __search_drawer_controls_layout3() {
        $this->start_controls_section(
            '_section_search_drawer_style_layout3',
            [
                'label' => __('Search Drawer', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-3',
                ],
            ]
        );

        // Height
        $this->add_responsive_control(
            'layout3_container_height',
            [
                'label'      => __('Height', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range'      => [
                    'px' => ['min' => 200, 'max' => 1200, 'step' => 1],
                ],
                'selectors' => [

                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3.ha_advanced_search_search-active .ha_advanced_search_search-container'
                    => 'height: calc({{SIZE}}{{UNIT}} + 78px);',
                ],
            ]
        );

        $this->add_control(
            'layout3_search_container_background_color',
            [
                'label'     => __('Background Color', 'happy-addons-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-container'
                    => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout3_field_cross_icon_color',
            [
                'label' => __('Cross Icon Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-close' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout3_drawer_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-container' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-close' =>
                    'top: {{TOP}}{{UNIT}};',

                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_results_footer' =>
                    'padding-bottom: {{BOTTOM}}{{UNIT}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3.ha_advanced_search_search-active .ha_advanced_search_search-container'
                    => 'height: calc({{SIZE}}{{UNIT}} + 78px);',
                ],
            ]
        );


        $this->add_control(
            'layout3_results_search_field_heading',
            [
                'label' => __('Search Field', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'layout3_field_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search_input' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout3_field_typo',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search_input',
            ]
        );

        $this->add_control(
            'layout3_field_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search_input' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout3_field_placeholder_color',
            [
                'label' => __('Placeholder Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search_input::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout3_field_icon_color',
            [
                'label' => __('Icon Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-icon-input' => 'fill: {{VALUE}}; color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-icon-input i' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-icon-input svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-clear-btn' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-clear-btn svg' => 'fill: {{VALUE}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'layout3_field_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_search-input.ha_advanced_search_search_input' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'layout3_results_category_heading',
            [
                'label' => __('Category List', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'layout3_show_category_list' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'layout3_category_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_category_select' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'layout3_show_category_list' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout3_category_typo',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_category_select',
                'condition' => [
                    'layout3_show_category_list' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'layout3_category_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_category_select' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_arrow-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'layout3_show_category_list' => 'yes',
                ],
            ]
        );



        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'layout3_category_border',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_category_select',
                'condition' => [
                    'layout3_show_category_list' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout3_category_border_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_category_select' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'layout3_show_category_list' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout3_category_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_category_select' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'layout3_show_category_list' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'layout3_popular_search_heading',
            [
                'label' => __('Popular Search', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout3_popular_search_title_typography',
                'label'    => __('Typography', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_layout3_popular_search .ha_advanced_search_layout3_popular_title',
            ]
        );

        $this->add_control(
            'layout3_popular_search_title_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_layout3_popular_search .ha_advanced_search_layout3_popular_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout3_popular_search_title_bottom_gap',
            [
                'label' => __('Gap', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 120,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_layout3_popular_search .ha_advanced_search_layout3_popular_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'layout3_popular_search_keyword_heading',
            [
                'label' => __('Keyword', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout3_popular_search_text_typography',
                'label'    => __('Typography', 'happy-addons-pro'),
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_layout3_popular_search .ha_advanced_search_layout3_popular_item .ha_advanced_search_popular-title',
            ]
        );


        $this->start_controls_tabs('layout3_popular_search_text_tabs');

        $this->start_controls_tab(
            'layout3_popular_search_text_normal',
            [
                'label' => __('Normal', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout3_popular_search_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_layout3_popular_search .ha_advanced_search_layout3_popular_item .ha_advanced_search_popular-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'layout3_popular_search_text_hover',
            [
                'label' => __('Hover', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout3_popular_search_text_hover_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-3 .ha_advanced_search_layout3_popular_search .ha_advanced_search_layout3_popular_item:hover .ha_advanced_search_popular-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function __search_container_controls_layout4() {
        $this->start_controls_section(
            'section_container_style_layout4',
            [
                'label' => __('Search Bar', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-4',
                ],
            ]
        );

        $this->add_control(
            'layout4_trigger_background',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_search-trigger' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout4_trigger_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_search-trigger' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'layout4_trigger_field_heading',
            [
                'label' => __('Search Field', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'layout4_trigger_field_width',
            [
                'label' => __('Width', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 40, 'max' => 600],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_trigger-input' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'layout4_trigger_field_border',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_search-trigger',
            ]
        );

        $this->add_responsive_control(
            'layout4_trigger_field_border_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_search-trigger' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'layout4_trigger_placeholder_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_trigger-input::placeholder',
            ]
        );

        $this->add_control(
            'layout4_trigger_placeholder_color',
            [
                'label' => __('Placeholder Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_trigger-input::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout4_trigger_icon_color',
            [
                'label' => __('Icon Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_search-trigger .ha_advanced_search_search_trigger_icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_search-trigger .ha_advanced_search_search_trigger_icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_search-trigger .ha_advanced_search_search_trigger_icon svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function __search_popup_controls_layout4() {
        $this->start_controls_section(
            '_section_search_popup_style_layout4',
            [
                'label' => __('Search Popup', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-4',
                ],
            ]
        );

        $this->add_control(
            'layout4_panel_background',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_search-panel' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout4_close_button_heading',
            [
                'label' => __('Close Button', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'layout4_close_button_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_layout4_shell .ha_advanced_search_search-header .ha_advanced_search_btn-holder .ha_advanced_search_search-close.ha_advanced_search_close',
            ]
        );
        $this->add_control(
            'layout4_close_button_color',
            [
                'label' => __('Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_layout4_shell .ha_advanced_search_search-header .ha_advanced_search_btn-holder > .ha_advanced_search_search-close.ha_advanced_search_close' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_layout4_shell .ha_advanced_search_search-header .ha_advanced_search_btn-holder > .ha_advanced_search_search-close.ha_advanced_search_close svg' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_layout4_shell .ha_advanced_search_search-header .ha_advanced_search_btn-holder > .ha_advanced_search_search-close.ha_advanced_search_close svg path' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout4_results_image_heading',
            [
                'label' => __('Logo Image', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'layout4_logo_image_width',
            [
                'label' => __('Width', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 500],
                    '%'  => ['min' => 1, 'max' => 100],
                    'vw' => ['min' => 1, 'max' => 50],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_logo-search img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout4_logo_image_height',
            [
                'label' => __('Height', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 500],
                    '%'  => ['min' => 1, 'max' => 100],
                    'vh' => ['min' => 1, 'max' => 50],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_logo-search img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'layout4_search_field_heading',
            [
                'label' => __('Search Field', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'layout4_field_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_search_input',
            ]
        );

        $this->add_control(
            'layout4_field_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_search_input' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_clear_button' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_clear_button span' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_clear_button svg' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_clear_button svg path' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout4_field_placeholder_color',
            [
                'label' => __('Placeholder Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_search_input::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout4_counter_color',
            [
                'label' => __('Counter Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_clear_button_l4' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_clear_button_l4 span' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_clear_button_l4 #ha_advanced_search_result-count' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_clear_button_l4 [id^="ha-advanced-search-result-count-"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout4_cross_color',
            [
                'label' => __('Cross Button Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [

                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_clear_button_l4 svg' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_clear_button_l4 svg path' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout4_cross_icon_size',
            [
                'label' => __('Cross Icon Size', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 8, 'max' => 120],
                    'em' => ['min' => 0.5, 'max' => 8],
                    'rem' => ['min' => 0.5, 'max' => 8],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_clear_button_l4 svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'layout4_field_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_search_input' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'layout4_results_category_heading',
            [
                'label' => __('Category List', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'layout4_show_category_list' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout4_results_category_width',
            [
                'label'      => __('Width', 'happy-addons-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => ['min' => 50, 'max' => 600, 'step' => 1],
                ],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_category_select' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'layout4_category_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_category_select',
                'condition' => [
                    'layout4_show_category_list' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'layout4_category_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_category_select' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_layout4_shell .ha_advanced_search_select-wrapper:after' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'layout4_show_category_list' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function __search_results_style_controls_layout4() {
        $this->start_controls_section(
            '_section_search_results_style_layout4',
            [
                'label' => __('Search Results', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-4',
                ],
            ]
        );




        $this->add_control(
            'layout4_results_items_heading',
            [
                'label' => __('Items', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'layout4_results_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_result-title',
            ]
        );

        $this->add_control(
            'layout4_results_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_result-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout4_results_subtitle_color',
            [
                'label' => __('Subtitle Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_result-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout4_divider_heading',
            [
                'label' => __('Divider', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'layout4_input_holder_line_height',
            [
                'label' => __('Divider Height', 'happy-addons-pro'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 20],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_layout4_shell .ha_advanced_search_search-input-holder:after' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_layout4_shell .ha_advanced_search_search-panel-item' => 'border-bottom-width: {{SIZE}}{{UNIT}}; border-bottom-style: solid;',
                ],
            ]
        );

        $this->add_control(
            'layout4_input_holder_line_color',
            [
                'label' => __('Divider Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_layout4_shell .ha_advanced_search_search-input-holder:after' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_layout4_shell .ha_advanced_search_search-panel-item' => 'border-bottom-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'layout4_load_more_heading',
            [
                'label' => __('Load More', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'layout4_load_more_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_view_all_link',
            ]
        );

        $this->start_controls_tabs('layout4_results_load_more_tabs');

        $this->start_controls_tab(
            'layout4_results_load_more_normal',
            [
                'label' => __('Normal', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout4_results_load_more_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_view_all_link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'layout4_results_load_more_hover',
            [
                'label' => __('Hover', 'happy-addons-pro'),
            ]
        );

        $this->add_control(
            'layout4_results_load_more_hover_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_view_all_link:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'layout4_no_result_heading',
            [
                'label' => __('No Result', 'happy-addons-pro'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'layout4_no_result_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_no_results',
            ]
        );

        $this->add_control(
            'layout4_no_result_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_no_results' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_no_results strong' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-4 .ha_advanced_search_no_results span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render shared category/page optgroups for select fields.
     *
     * @param array $categories
     * @param bool  $has_pages
     * @param array $pages
     * @return void
     */
    private function render_category_page_options(array $categories, bool $has_pages, array $pages) {
        if (!empty($categories)) : ?>
            <!-- <optgroup label="<?php echo esc_attr__('Categories', 'happy-addons-pro'); ?>"> -->
            <?php foreach ($categories as $cat) : ?>
                <option value="<?php echo esc_attr('cat:' . $cat->slug); ?>">
                    <?php echo esc_html($cat->name); ?>
                </option>
            <?php endforeach; ?>
            <!-- </optgroup> -->
        <?php endif;

        if ($has_pages && !empty($pages)) : ?>
            <!-- <optgroup label="<?php echo esc_attr__('Pages', 'happy-addons-pro'); ?>"> -->
            <?php foreach ($pages as $page_id) : ?>
                <option value="<?php echo esc_attr('page:' . (int) $page_id); ?>">
                    <?php echo esc_html(get_the_title($page_id)); ?>
                </option>
            <?php endforeach; ?>
            <!-- </optgroup> -->
        <?php endif;
    }

    /**
     * Render shared date filter options.
     *
     * @param string $date_filter_text
     * @param string $date_today_text
     * @param string $date_yesterday_text
     * @param string $date_last_7_days_text
     * @param string $date_this_month_text
     * @param string $date_last_month_text
     * @param string $date_custom_text
     * @return void
     */
    private function render_date_filter_options(
        string $date_filter_text,
        string $date_today_text,
        string $date_yesterday_text,
        string $date_last_7_days_text,
        string $date_this_month_text,
        string $date_last_month_text,
        string $date_custom_text
    ) {
        ?>
        <option value="all"><?php echo esc_html($date_filter_text); ?></option>
        <option value="today"><?php echo esc_html($date_today_text); ?></option>
        <option value="yesterday"><?php echo esc_html($date_yesterday_text); ?></option>
        <option value="last-7-days"><?php echo esc_html($date_last_7_days_text); ?></option>
        <option value="this_month"><?php echo esc_html($date_this_month_text); ?></option>
        <option value="last-month"><?php echo esc_html($date_last_month_text); ?></option>
        <option value="custom"><?php echo esc_html($date_custom_text); ?></option>
    <?php
    }

    protected function render_layout_3($settings, $widget_id, $show_category_list, $show_search_field, $categories, $has_pages, $pages, $category_list_text, $placeholder_text, $load_more_text, $popular_search_text, $popular_terms, $show_popular_keyword) {
        $layout3_search_icon = ! empty($settings['layout3_search_icon']['value']) ? $settings['layout3_search_icon'] : "";
        $layout3_search_field_icon = ! empty($settings['layout3_search_field_icon']['value']) ? $settings['layout3_search_field_icon'] : "";
        $layout3_search_field_placeholder_text = isset($settings['layout3_search_field_placeholder_text']) && '' !== trim((string) $settings['layout3_search_field_placeholder_text'])
            ? $settings['layout3_search_field_placeholder_text']
            : $placeholder_text;
    ?>
        <div class="ha_advanced_search_search_box ha_advanced_search_layout3_shell">
            <div class="ha_advanced_search_globalnav-item ha_advanced_search_search-trigger">
                <?php if (! empty($layout3_search_icon['value'])) : ?>
                    <span class="ha_advanced_search_search-icon-svg" aria-hidden="true">
                        <?php
                        Icons_Manager::render_icon(
                            $layout3_search_icon,
                            ['aria-hidden' => 'true']
                        );
                        ?>
                    </span>
                <?php endif; ?>
                <?php if ('true' === $show_search_field) : ?>
                    <input type="text" class="ha_advanced_search_search-input-initial" placeholder="<?php echo esc_attr($placeholder_text); ?>" />
                <?php endif; ?>
            </div>

            <div class="ha_advanced_search_search-container">
                <div class="ha_advanced_search_search-form-wrapper">
                    <?php if (! empty($layout3_search_field_icon['value'])) : ?>
                        <span class="ha_advanced_search_search-icon-input" aria-hidden="true">
                            <?php Icons_Manager::render_icon($layout3_search_field_icon, ['aria-hidden' => 'true']); ?>
                        </span>
                    <?php endif; ?>

                    <input
                        type="text"
                        id="ha-advanced-search-search-input-<?php echo esc_attr($widget_id); ?>"
                        placeholder="<?php echo esc_attr($layout3_search_field_placeholder_text); ?>"
                        class="ha_advanced_search_search-input ha_advanced_search_search_input"
                        autocomplete="off" />

                    <button id="ha-advanced-search-clear-button-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_search-clear-btn ha_advanced_search_clear_button" title="<?php echo esc_attr__('Clear search', 'happy-addons-pro'); ?>">
                        <svg viewBox="0 0 20 20">
                            <path d="M10,0C4.5,0,0,4.5,0,10s4.5,10,10,10s10-4.5,10-10S15.5,0,10,0z M14.6,13.2l-1.4,1.4L10,11.4l-3.2,3.2l-1.4-1.4l3.2-3.2 L5.4,6.8l1.4-1.4l3.2,3.2l3.2-3.2l1.4,1.4l-3.2,3.2L14.6,13.2z"></path>
                        </svg>
                    </button>

                    <?php if ('true' === $show_category_list) : ?>
                        <div class="ha_advanced_search_search-category-container">
                            <select id="ha-advanced-search-category-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_search-category-select ha_advanced_search_category_select">
                                <option value="all"><?php echo esc_html($category_list_text); ?></option>
                                <?php $this->render_category_page_options($categories, $has_pages, $pages); ?>
                            </select>
                            <svg class="ha_advanced_search_arrow-icon" width="8" height="8" viewBox="0 0 8 8" aria-hidden="true">
                                <path fill="currentColor" d="M0 2l4 4 4-4z"></path>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="button" class="ha_advanced_search_search-close" aria-label="<?php echo esc_attr__('Close search', 'happy-addons-pro'); ?>">&times;</button>

                <div id="ha-advanced-search-results-container-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_results_container ha_advanced_search_layout3_results_container">
                    <div class="ha_advanced_search_search-results ha_advanced_search_layout3_results_block">
                        <h3 class="ha_advanced_search_search_results_title"><?php echo esc_html__('Search Results', 'happy-addons-pro'); ?></h3>
                        <ul id="ha-advanced-search-results-list-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_results_list ha_advanced_search_result-list">
                            <!-- Results will be injected here via JS -->
                        </ul>
                    </div>
                    <?php if ('true' === $show_popular_keyword) : ?>
                        <div class="ha_advanced_search_search-ps ha_advanced_search_layout3_popular_search">
                            <h3 class="ha_advanced_search_layout3_popular_title"><?php echo esc_html($popular_search_text); ?></h3>
                            <?php if (! empty($popular_terms)) : ?>
                                <ul class="ha_advanced_search_result-list ha_advanced_search_layout3_popular_list">
                                    <?php foreach ($popular_terms as $term) : ?>
                                        <a href="#" class="ha_advanced_search_layout3_popular_item" data-keyword="<?php echo esc_attr($term); ?>">
                                            <h3 class="ha_advanced_search_popular-title"><?php echo esc_html($term); ?></h3>
                                        </a>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else : ?>
                                <div class="ha_advanced_search_layout3_popular_empty"><?php echo esc_html__('No popular searches yet', 'happy-addons-pro'); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="ha_advanced_search_results_footer">
                        <a href="#" class="ha_advanced_search_view_all_link">
                            <?php echo esc_html($load_more_text); ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="ha_advanced_search_curtain" aria-hidden="true"></div>
        </div>
    <?php
    }

    private function render_layout_4(array $settings, string $widget_id, string $show_category_list, string $show_search_field, array $categories, bool $has_pages, array $pages, string $category_list_text, string $placeholder_text, string $layout4_search_input_text, string $load_more_text) {
        $layout4_search_icon = ! empty($settings['layout4_search_icon']['value']) ? $settings['layout4_search_icon'] : "";
    ?>
        <div class="ha_advanced_search_search_box ha_advanced_search_layout4_shell">
            <button type="button" class="ha_advanced_search_search-trigger" id="open-search-<?php echo esc_attr($widget_id); ?>">

                <?php if (! empty($layout4_search_icon['value'])) : ?>

                    <span class="ha_advanced_search_search_trigger_icon ha_advanced_search_search_icon" aria-hidden="true">
                        <?php
                        \Elementor\Icons_Manager::render_icon(
                            $layout4_search_icon,
                            ['aria-hidden' => 'true']
                        );
                        ?>
                    </span>

                <?php endif; ?>




                <?php if ('true' === $show_search_field) : ?>
                    <input type="text" class="ha_advanced_search_search-input-initial ha_advanced_search_trigger-input" placeholder="<?php echo esc_attr($placeholder_text); ?>" readonly />
                <?php endif; ?>
            </button>

            <div class="ha_advanced_search_search-panel" id="search-panel-<?php echo esc_attr($widget_id); ?>">
                <div class="ha_advanced_search_search-header">
                    <div class="ha_advanced_search_container">
                        <span class="ha_advanced_search_logo-search">
                            <?php
                            $layout4_logo_type = isset($settings['layout4_logo_type']) ? $settings['layout4_logo_type'] : 'image';
                            $layout4_logo_image_url = isset($settings['layout4_logo_image']['url']) ? $settings['layout4_logo_image']['url'] : '';
                            if ('icon' === $layout4_logo_type && ! empty($settings['layout4_logo_icon']['value'])) :
                            ?>
                                <span class="ha_advanced_search_layout4_logo_icon" aria-hidden="true">
                                    <?php
                                    Icons_Manager::render_icon(
                                        $settings['layout4_logo_icon'],
                                        ['aria-hidden' => 'true']
                                    );
                                    ?>
                                </span>
                            <?php elseif (! empty($layout4_logo_image_url)) : ?>
                                <img src="<?php echo esc_url($layout4_logo_image_url); ?>" width="50" alt="<?php echo esc_attr__('Logo', 'happy-addons-pro'); ?>" />
                            <?php else : ?>
                                <img class="ha_advanced_search_layout4_default_logo" src="https://happyaddons.com/wp-content/uploads/2026/02/ha-advanced-search-logo-dark@2x.png" width="50" alt="<?php echo esc_attr__('Logo', 'happy-addons-pro'); ?>" />
                            <?php endif; ?>
                        </span>
                        <div class="ha_advanced_search_btn-holder">
                            <button type="button" class="ha_advanced_search_search-close ha_advanced_search_close" id="close-search-<?php echo esc_attr($widget_id); ?>" aria-label="<?php echo esc_attr__('Close search', 'happy-addons-pro'); ?>">
                                <?php echo esc_html__('Close', 'happy-addons-pro'); ?>
                                <svg viewBox="0 0 30 30" fill="none" aria-hidden="true">
                                    <path d="M7.5 7.5L22.5 22.5M7.5 22.5L22.5 7.5" stroke="currentColor" stroke-width="1.5"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="ha_advanced_search_container ha_advanced_search_search-container">
                    <div class="ha_advanced_search_search-input-holder" id="search-input-holder-<?php echo esc_attr($widget_id); ?>">
                        <?php if ('true' === $show_category_list) : ?>
                            <div class="ha_advanced_search_label-holder">
                                <div class="ha_advanced_search_select-wrapper">
                                    <select id="ha-advanced-search-category-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_category-select ha_advanced_search_category_select">
                                        <option value="all"><?php echo esc_html($category_list_text); ?></option>
                                        <?php $this->render_category_page_options($categories, $has_pages, $pages); ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="ha_advanced_search_search-input-row">
                            <input
                                type="text"
                                id="ha-advanced-search-search-input-<?php echo esc_attr($widget_id); ?>"
                                placeholder="<?php echo esc_attr($layout4_search_input_text); ?>"
                                class="ha_advanced_search_search_input"
                                autocomplete="off" />

                            <button id="ha-advanced-search-clear-button-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_btn-clear ha_advanced_search_clear_button_l4" title="<?php echo esc_attr__('Clear search', 'happy-addons-pro'); ?>">
                                <span id="ha-advanced-search-result-count-<?php echo esc_attr($widget_id); ?>">0</span>
                                <?php echo esc_html__('Results', 'happy-addons-pro'); ?>
                                <svg viewBox="0 0 40 40" fill="none" aria-hidden="true">
                                    <path d="M10 10L30 30M10 30L30 10" stroke="currentColor" stroke-width="2"></path>
                                </svg>
                            </button>

                            <button id="ha-advanced-search-search-button-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_search_button ha_advanced_search_layout4_hidden_search_button" aria-label="<?php echo esc_attr__('Search', 'happy-addons-pro'); ?>">
                                <span class="ha_advanced_search_button_icon">
                                    <?php
                                    if (! empty($settings['search_button_icon']['value'])) {
                                        Icons_Manager::render_icon(
                                            $settings['search_button_icon'],
                                            ['aria-hidden' => 'true']
                                        );
                                    } else {
                                    ?>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg>
                                    <?php
                                    }
                                    ?>
                                </span>
                                <span class="ha_advanced_search_button_text 4"><?php echo esc_html__('Search', 'happy-addons-pro'); ?></span>
                            </button>
                        </div>
                    </div>

                    <div id="ha-advanced-search-results-container-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_results_container ha_advanced_search_search-results-container">
                        <div id="ha-advanced-search-results-list-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_results_list ha_advanced_search_search-panel-list">
                            <!-- Results will be injected here via JS -->
                        </div>
                        <div class="ha_advanced_search_results_footer">
                            <a href="#" class="ha_advanced_search_view_all_link">
                                <?php echo esc_html($load_more_text); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

    /**
     * Render widget output on the frontend
     *
     * @since 3.5.0
     * @access protected
     */


    protected function __popular_search_style_controls_layout2() {

        $this->start_controls_section(
            '_section_popular_search_style_layout2',
            [
                'label' => __('Popular Search ', 'happy-addons-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'layout-2',
                ],
            ]
        );



        $this->add_control(
            'layout2_ps_container_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-popular-search-section' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout2_ps_container_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-popular-search-section' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border (includes width/style/color)
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_ps_container_border',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-popular-search-section',
            ]
        );

        $this->add_responsive_control(
            'layout2_ps_container_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-popular-search-section' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        /**
         * =========================
         * Title
         * =========================
         */
        $this->add_control(
            'layout2_ps_title_heading',
            [
                'label'     => __('Title', 'happy-addons-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout2_ps_title_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-popular-search-title',
            ]
        );

        $this->add_control(
            'layout2_ps_title_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-popular-search-title' => 'color: {{VALUE}};',
                ],
            ]
        );



        $this->add_responsive_control(
            'layout2_ps_section_align',
            [
                'label'   => __('Alignment', 'happy-addons-pro'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'happy-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'space-between' => [
                        'title' => __('Space Between', 'happy-addons-pro'),
                        'icon'  => 'eicon-justify-space-between-h',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-popular-search-section' =>
                    'display:flex;align-items:center;justify-content: {{VALUE}};',
                ],
            ]
        );


        /**
         * =========================
         * Keyword Item
         * =========================
         */
        $this->add_control(
            'layout2_ps_keyword_heading',
            [
                'label'     => __('Keyword Item', 'happy-addons-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );




        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'layout2_ps_keyword_typography',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-keyword',
            ]
        );

        $this->add_responsive_control(
            'layout2_ps_keyword_padding',
            [
                'label'      => __('Padding', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-keyword' =>
                    'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'layout2_ps_keyword_margin',
            [
                'label'      => __('Margin', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-keyword' =>
                    'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border (includes width/style/color)
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'layout2_ps_keyword_border',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-keyword',
            ]
        );

        $this->add_responsive_control(
            'layout2_ps_keyword_radius',
            [
                'label'      => __('Border Radius', 'happy-addons-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-keyword' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'layout2_ps_keyword_1',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        // Normal / Hover
        $this->start_controls_tabs('layout2_ps_keyword_tabs');

        // Normal
        $this->start_controls_tab(
            'layout2_ps_keyword_tab_normal',
            ['label' => __('Normal', 'happy-addons-pro')]
        );

        $this->add_control(
            'layout2_ps_keyword_bg',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-keyword' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_ps_keyword_text_color',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-keyword' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_ps_keyword_shadow',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-keyword',
            ]
        );

        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab(
            'layout2_ps_keyword_tab_hover',
            ['label' => __('Hover', 'happy-addons-pro')]
        );

        $this->add_control(
            'layout2_ps_keyword_bg_hover',
            [
                'label' => __('Background Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-keyword:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'layout2_ps_keyword_text_color_hover',
            [
                'label' => __('Text Color', 'happy-addons-pro'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-keyword:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'layout2_ps_keyword_shadow_hover',
                'selector' => '{{WRAPPER}}.ha-advanced-search-search-layout-layout-2 .ha-advanced-search-keyword:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     *
     * @since 3.5.0
     * @access protected
     */

    protected function render() {
        $settings = $this->get_settings_for_display();

        // Get widget ID for unique identifiers
        $widget_id = $this->get_id();

        $layout = ! empty($settings['search_layout'])
            ? $settings['search_layout']
            : ($this->get_settings('search_layout') ?? 'layout-1');
        $is_layout2 = ('layout-2' === $layout);
        $is_layout3 = ('layout-3' === $layout);
        $is_layout4 = ('layout-4' === $layout);
        $layout_prefix = $is_layout2 ? 'layout2_' : ($is_layout3 ? 'layout3_' : ($is_layout4 ? 'layout4_' : ''));

        // Prepare post types data
        $post_types_setting_key = $layout_prefix . 'post_types';
        $post_types = (isset($settings[$post_types_setting_key]) && is_array($settings[$post_types_setting_key]))
            ? $settings[$post_types_setting_key]
            : (isset($settings['post_types']) && is_array($settings['post_types']) ? $settings['post_types'] : ['post', 'page']);
        $post_types_json = wp_json_encode($post_types);
        $has_pages = true;

        // Prepare display options
        $initial_results_count_key = $layout_prefix . 'initial_results_count';
        $show_category_list_key = $layout_prefix . 'show_category_list';
        $show_popular_keyword_key = $layout_prefix . 'show_popular_keyword';
        $show_content_image_key = $layout_prefix . 'show_content_image';
        $show_search_field_key = $layout_prefix . 'show_search_field';

        $initial_results_count = isset($settings[$initial_results_count_key])
            ? intval($settings[$initial_results_count_key])
            : (isset($settings['initial_results_count']) ? intval($settings['initial_results_count']) : 5);
        $show_category_list    = (isset($settings[$show_category_list_key]) && 'yes' === $settings[$show_category_list_key]) ? 'true' : ((isset($settings['show_category_list']) && 'yes' === $settings['show_category_list']) ? 'true' : 'false');
        $show_popular_keyword  = (isset($settings[$show_popular_keyword_key]) && 'yes' === $settings[$show_popular_keyword_key]) ? 'true' : ((isset($settings['show_popular_keyword']) && 'yes' === $settings['show_popular_keyword']) ? 'true' : 'false');
        $show_content_image    = (isset($settings[$show_content_image_key]) && 'yes' === $settings[$show_content_image_key]) ? 'true' : ((isset($settings['show_content_image']) && 'yes' === $settings['show_content_image']) ? 'true' : 'false');
        $show_search_field     = (isset($settings[$show_search_field_key]) && 'yes' === $settings[$show_search_field_key]) ? 'true' : 'false';

        if (! $is_layout3 && ! $is_layout4) {
            $show_search_field = 'true';
        }

        if ($is_layout3) {
            $show_content_image = 'false';
        }

        // Prepare text labels
        $legacy_placeholder_text = isset($settings['placeholder_text']) ? $settings['placeholder_text'] : __('Search', 'happy-addons-pro');
        $layout1_placeholder_text = isset($settings['layout1_placeholder_text']) && '' !== trim((string) $settings['layout1_placeholder_text'])
            ? $settings['layout1_placeholder_text']
            : $legacy_placeholder_text;
        $layout2_placeholder_text = isset($settings['layout2_placeholder_text']) && '' !== trim((string) $settings['layout2_placeholder_text'])
            ? $settings['layout2_placeholder_text']
            : $legacy_placeholder_text;
        $layout3_placeholder_text = isset($settings['layout3_placeholder_text']) && '' !== trim((string) $settings['layout3_placeholder_text'])
            ? $settings['layout3_placeholder_text']
            : $legacy_placeholder_text;
        $layout4_placeholder_text = isset($settings['layout4_placeholder_text']) && '' !== trim((string) $settings['layout4_placeholder_text'])
            ? $settings['layout4_placeholder_text']
            : $legacy_placeholder_text;
        $layout4_search_input_text = isset($settings['layout4_search_input_text']) ? $settings['layout4_search_input_text'] : __('Start typing', 'happy-addons-pro');
        $category_list_text   = isset($settings['category_list_text']) ? $settings['category_list_text'] : __('All Categories', 'happy-addons-pro');
        $legacy_search_button_text = isset($settings['search_button_text']) ? $settings['search_button_text'] : "";
        $layout1_search_button_text = isset($settings['layout1_search_button_text']) && '' !== trim((string) $settings['layout1_search_button_text'])
            ? $settings['layout1_search_button_text']
            : $legacy_search_button_text;
        $layout2_search_button_text = isset($settings['layout2_search_button_text']) && '' !== trim((string) $settings['layout2_search_button_text'])
            ? $settings['layout2_search_button_text']
            : $legacy_search_button_text;

        $legacy_empty_search_term_text = isset($settings['empty_search_term_text']) && '' !== trim((string) $settings['empty_search_term_text'])
            ? $settings['empty_search_term_text']
            : __('Please enter a search term', 'happy-addons-pro');
        $layout1_empty_search_term_text = isset($settings['layout1_empty_search_term_text']) && '' !== trim((string) $settings['layout1_empty_search_term_text'])
            ? $settings['layout1_empty_search_term_text']
            : $legacy_empty_search_term_text;
        $layout2_empty_search_term_text = isset($settings['layout2_empty_search_term_text']) && '' !== trim((string) $settings['layout2_empty_search_term_text'])
            ? $settings['layout2_empty_search_term_text']
            : $legacy_empty_search_term_text;

        $search_button_text = $is_layout2 ? $layout2_search_button_text : $layout1_search_button_text;
        $empty_search_term_text = $is_layout2 ? $layout2_empty_search_term_text : $layout1_empty_search_term_text;
        $popular_search_text  = isset($settings['popular_search_text']) ? $settings['popular_search_text'] : __('Popular Searches', 'happy-addons-pro');
        $result_box_header_text = isset($settings['result_box_header_text']) ? $settings['result_box_header_text'] : __('Search in Category', 'happy-addons-pro');
        $load_more_text = trim($settings['load_more_text'] ?? '') !== ''
            ? $settings['load_more_text']
            : __('Load More', 'happy-addons-pro');

        $not_found_text = trim($settings['not_found_text'] ?? '') !== ''
            ? $settings['not_found_text']
            : __('No results found', 'happy-addons-pro');

        $helper_text = isset($settings['helper_text']) ? trim($settings['helper_text']) : '';
        $categories = get_terms([
            'taxonomy'   => 'category',
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => false,
        ]);
        if (is_wp_error($categories)) {
            $categories = [];
        }
        $pages = [];
        if ($has_pages) {
            $pages = get_posts([
                'post_type'      => $post_types,
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
                'fields'         => 'ids',
                'no_found_rows'  => true,
            ]);
        }

        // Load popular keywords from DB (tracked searches)
        $popular_terms = [];

        if ((! $is_layout4) && ((isset($settings[$show_popular_keyword_key]) && $settings[$show_popular_keyword_key] === 'yes') || (isset($settings['show_popular_keyword']) && $settings['show_popular_keyword'] === 'yes'))) {

            $tracked_keywords = get_option('ha_advanced_search_keywords', []);

            if (is_array($tracked_keywords) && ! empty($tracked_keywords)) {
                arsort($tracked_keywords);

                $popular_keywords_limit_key = $layout_prefix . 'popular_keywords_limit';
                $limit = ! empty($settings[$popular_keywords_limit_key])
                    ? absint($settings[$popular_keywords_limit_key])
                    : 10;

                $popular_terms = array_slice(
                    array_keys($tracked_keywords),
                    0,
                    $limit
                );
            }
        }

        $show_date_filter_key = $layout_prefix . 'show_date_filter';
        $show_date_filter = (isset($settings[$show_date_filter_key]) && 'yes' === $settings[$show_date_filter_key]) ? 'true' : ((isset($settings['show_date_filter']) && 'yes' === $settings['show_date_filter']) ? 'true' : 'false');
        if ($is_layout3 || $is_layout4) {
            $show_date_filter = 'false';
        }
        $date_filter_text     = $settings['date_filter_text'] ?? __('All Dates', 'happy-addons-pro');
        $date_today_text      = $settings['date_today_text'] ?? __('Today', 'happy-addons-pro');
        $date_this_month_text = $settings['date_this_month_text'] ?? __('This Month', 'happy-addons-pro');
        $date_yesterday_text      = $settings['date_yesterday_text'] ?? __('Yesterday', 'happy-addons-pro');
        $date_last_7_days_text = $settings['date_last_7_days_text'] ?? __('Last 7 days', 'happy-addons-pro');
        $date_last_month_text = $settings['date_last_month_text'] ?? __('Last Month', 'happy-addons-pro');
        $date_custom_text     = $settings['date_custom_text'] ?? __('Custom', 'happy-addons-pro');

        $layout2_looking_for_label = $settings['layout2_looking_for_label'] ?? __('Looking for', 'happy-addons-pro');
        $layout2_category_label = $settings['layout2_category_label'] ?? __('Category', 'happy-addons-pro');
        $layout2_date_label = $settings['layout2_date_label'] ?? __('Date', 'happy-addons-pro');
        $layout2_button_inline = isset($settings['layout2_button_inline']) && 'yes' === $settings['layout2_button_inline'];
        $layout1_search_icon = ! empty($settings['search_icon']['value']) ? $settings['search_icon'] : '';
        $layout2_search_icon = ! empty($settings['layout2_search_icon']['value']) ? $settings['layout2_search_icon'] : '';
        $layout2_category_select_icon = ! empty($settings['layout2_category_select_icon']['value']) ? $settings['layout2_category_select_icon'] : [];
        $layout2_date_select_icon = ! empty($settings['layout2_date_select_icon']['value']) ? $settings['layout2_date_select_icon'] : [];
        $result_page_url = ! empty($settings['result_page_id']) ? get_permalink((int) $settings['result_page_id']) : '';

        $start_label = $settings['date_start_label_text'] ?? __('Start Date', 'happy-addons-pro');
        $end_label   = $settings['date_end_label_text'] ?? __('End Date', 'happy-addons-pro');

        $date_icon = $settings['date_panel_icon'] ?? [];
    ?>
        <div class="elementor-widget-container">
            <div class="ha-advanced-search-advanced-search-wrap" id="ha-advanced-search-advanced-search-<?php echo esc_attr($widget_id); ?>"
                data-post-types='<?php echo esc_attr($post_types_json); ?>'
                data-initial-results-count="<?php echo esc_attr($initial_results_count); ?>"
                data-show-category-list="<?php echo esc_attr($show_category_list); ?>"
                data-show-popular-keyword="<?php echo esc_attr($show_popular_keyword); ?>"
                data-show-content-image="<?php echo esc_attr($show_content_image); ?>"
                data-popular-search-text="<?php echo esc_attr($popular_search_text); ?>"
                data-empty-search-text="<?php echo esc_attr($empty_search_term_text); ?>"
                data-result-box-header-text="<?php echo esc_attr($result_box_header_text); ?>"
                data-load-more-text="<?php echo esc_attr($load_more_text); ?>"
                data-not-found-text="<?php echo esc_attr($not_found_text); ?>"
                data-show-date-filter="<?php echo esc_attr($show_date_filter); ?>"
                data-result-page="<?php echo esc_url($result_page_url); ?>">


                <!-- Search Container -->
                <?php if ('layout-2' === $layout) : ?>
                    <div class="ha_advanced_search_search_box">
                        <div class="ha_advanced_search_layout2_group ha_advanced_search_layout2_group_wide">
                            <label class="ha_advanced_search_layout2_label"><?php echo esc_html($layout2_looking_for_label); ?></label>
                            <div class="ha_advanced_search_layout2_input_wrapper  ha_advanced_search_layout2_search_input_wrapper">
                                <span class="ha_advanced_search_layout2_icon">
                                    <?php
                                    if (! empty($layout2_search_icon['value'])) {
                                        Icons_Manager::render_icon(
                                            $layout2_search_icon,
                                            ['aria-hidden' => 'true']
                                        );
                                    }
                                    ?>
                                </span>
                                <input
                                    type="text"
                                    id="ha-advanced-search-search-input-<?php echo esc_attr($widget_id); ?>"
                                    placeholder="<?php echo esc_attr($layout2_placeholder_text); ?>"
                                    class="ha_advanced_search_search_input"
                                    autocomplete="off" />
                                <button id="ha-advanced-search-clear-button-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_clear_button" title="<?php echo esc_attr__('Clear search', 'happy-addons-pro'); ?>">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <?php if ('true' === $show_category_list) : ?>
                            <div class="ha_advanced_search_layout2_group ha_advanced_search_layout2_group_narrow ha_advanced_search_layout2_group_category">
                                <label class="ha_advanced_search_layout2_label"><?php echo esc_html($layout2_category_label); ?></label>
                                <div class="ha_advanced_search_layout2_input_wrapper ha_advanced_search_layout2_select_wrapper ha_advanced_search_layout2_select_wrapper_category">
                                    <span class="ha_advanced_search_layout2_icon" aria-hidden="true">
                                        <?php if (! empty($layout2_category_select_icon['value'])) : ?>
                                            <?php Icons_Manager::render_icon($layout2_category_select_icon, ['aria-hidden' => 'true']); ?>
                                        <?php else : ?>
                                            <!-- <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"></path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg> -->
                                        <?php endif; ?>
                                    </span>
                                    <select id="ha-advanced-search-category-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_category_select">

                                        <!-- default -->
                                        <option value="all"><?php echo esc_html($category_list_text); ?></option>

                                        <?php $this->render_category_page_options($categories, $has_pages, $pages); ?>

                                    </select>
                                    <span class="ha_advanced_search_layout2_chevron" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="7 15 12 20 17 15"></polyline>
                                            <polyline points="7 9 12 4 17 9"></polyline>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ('true' === $show_date_filter) : ?>
                            <div class="ha_advanced_search_layout2_group ha_advanced_search_layout2_group_narrow ha_advanced_search_layout2_group_date">
                                <label class="ha_advanced_search_layout2_label"><?php echo esc_html($layout2_date_label); ?></label>
                                <div class="ha_advanced_search_layout2_input_wrapper ha_advanced_search_layout2_select_wrapper ha_advanced_search_layout2_select_wrapper_date">
                                    <span class="ha_advanced_search_layout2_icon" aria-hidden="true">
                                        <?php if (! empty($layout2_date_select_icon['value'])) : ?>
                                            <?php Icons_Manager::render_icon($layout2_date_select_icon, ['aria-hidden' => 'true']); ?>
                                        <?php else : ?>
                                            <!-- <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"></path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg> -->
                                        <?php endif; ?>
                                    </span>
                                    <select id="ha-advanced-search-date-filter-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_date_select">
                                        <?php $this->render_date_filter_options($date_filter_text, $date_today_text, $date_yesterday_text, $date_last_7_days_text, $date_this_month_text, $date_last_month_text, $date_custom_text); ?>
                                    </select>
                                    <span class="ha_advanced_search_layout2_chevron" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="7 15 12 20 17 15"></polyline>
                                            <polyline points="7 9 12 4 17 9"></polyline>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($layout2_button_inline) : ?>
                            <div class="ha_advanced_search_layout2_group ha_advanced_search_layout2_group_button">
                                <button id="ha-advanced-search-search-button-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_search_button">
                                    <?php if (! empty($settings['search_button_icon']['value'])) : ?>
                                        <span class="ha_advanced_search_button_icon">
                                            <?php Icons_Manager::render_icon(
                                                $settings['search_button_icon'],
                                                ['aria-hidden' => 'true']
                                            ); ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($search_button_text) : ?>
                                        <span class="ha_advanced_search_button_text 21">
                                            <?php echo esc_html($search_button_text); ?>
                                        </span>
                                    <?php endif; ?>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (! $layout2_button_inline) : ?>
                        <div class="ha_advanced_search_layout2_actions">
                            <button id="ha-advanced-search-search-button-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_search_button">
                                <?php if (! empty($settings['search_button_icon']['value'])) : ?>
                                    <span class="ha_advanced_search_button_icon">
                                        <?php Icons_Manager::render_icon(
                                            $settings['search_button_icon'],
                                            ['aria-hidden' => 'true']
                                        ); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if ($search_button_text) : ?>
                                    <span class="ha_advanced_search_button_text 2">
                                        <?php echo esc_html($search_button_text); ?>
                                    </span>
                                <?php endif; ?>
                            </button>
                        </div>
                    <?php endif; ?>
                <?php elseif ('layout-3' === $layout) : ?>
                    <?php $this->render_layout_3($settings, $widget_id, $show_category_list, $show_search_field, $categories, $has_pages, $pages, $category_list_text, $layout3_placeholder_text, $load_more_text, $popular_search_text, $popular_terms, $show_popular_keyword); ?>
                <?php elseif ('layout-4' === $layout) : ?>
                    <?php $this->render_layout_4($settings, $widget_id, $show_category_list, $show_search_field, $categories, $has_pages, $pages, $category_list_text, $layout4_placeholder_text, $layout4_search_input_text, $load_more_text); ?>
                <?php else : ?>
                    <div class="ha_advanced_search_search_box">
                        <?php if ('true' === $show_category_list) : ?>
                            <div class="ha_advanced_search_category_wrapper">
                                <select id="ha-advanced-search-category-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_category_select">

                                    <!-- default -->
                                    <option value="all"><?php echo esc_html($category_list_text); ?></option>

                                    <?php $this->render_category_page_options($categories, $has_pages, $pages); ?>

                                </select>
                            </div>
                        <?php endif; ?>

                        <?php if ('true' === $show_date_filter) : ?>
                            <div class="ha_advanced_search_date_wrapper">
                                <select id="ha-advanced-search-date-filter-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_date_select">
                                    <?php $this->render_date_filter_options($date_filter_text, $date_today_text, $date_yesterday_text, $date_last_7_days_text, $date_this_month_text, $date_last_month_text, $date_custom_text); ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <!-- Input Area -->
                        <div class="ha_advanced_search_input_wrapper">
                            <?php if (! empty($layout1_search_icon['value'])) : ?>
                                <span class="ha_advanced_search_search_icon" aria-hidden="true">
                                    <?php
                                    \Elementor\Icons_Manager::render_icon(
                                        $layout1_search_icon,
                                        ['aria-hidden' => 'true']
                                    );
                                    ?>
                                </span>
                            <?php endif; ?>

                            <input
                                type="text"
                                id="ha-advanced-search-search-input-<?php echo esc_attr($widget_id); ?>"
                                placeholder="<?php echo esc_attr($layout1_placeholder_text); ?>"
                                class="ha_advanced_search_search_input"
                                autocomplete="off" />
                            <button id="ha-advanced-search-clear-button-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_clear_button" title="<?php echo esc_attr__('Clear search', 'happy-addons-pro'); ?>">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 100%; height: 100%">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <!-- Action Button -->
                        <button id="ha-advanced-search-search-button-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_search_button">
                            <?php if (! empty($settings['search_button_icon']['value'])) : ?>
                                <span class="ha_advanced_search_button_icon">
                                    <?php Icons_Manager::render_icon(
                                        $settings['search_button_icon'],
                                        ['aria-hidden' => 'true']
                                    ); ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($search_button_text) : ?>
                                <span class="ha_advanced_search_button_text 2">
                                    <?php echo esc_html($search_button_text); ?>
                                </span>
                            <?php endif; ?>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if ('true' === $show_date_filter) : ?>
                    <div class="ha_advanced_search_date_range" style="display:none;">

                        <div class="ha_advanced_search_date_range_row">

                            <!-- Start Date -->
                            <div class="ha_advanced_search_date_field ha_advanced_search_date_field_start">

                                <label class="ha_advanced_search_date_label">
                                    <?php echo esc_html($start_label); ?>
                                </label>

                                <div class="ha_advanced_search_date_input_wrap">

                                    <?php if (! empty($date_icon['value'])) : ?>
                                        <span class="ha_advanced_search_date_icon">
                                            <?php Icons_Manager::render_icon(
                                                $date_icon,
                                                ['aria-hidden' => 'true']
                                            ); ?>
                                        </span>
                                    <?php endif; ?>

                                    <input
                                        type="date"
                                        class="ha_advanced_search_date_from"
                                        aria-label="<?php echo esc_attr__('From date', 'happy-addons-pro'); ?>">
                                </div>
                            </div>

                            <!-- End Date -->
                            <div class="ha_advanced_search_date_field ha_advanced_search_date_field_end">

                                <label class="ha_advanced_search_date_label">
                                    <?php echo esc_html($end_label); ?>
                                </label>

                                <div class="ha_advanced_search_date_input_wrap">

                                    <?php if (! empty($date_icon['value'])) : ?>
                                        <span class="ha_advanced_search_date_icon">
                                            <?php Icons_Manager::render_icon(
                                                $date_icon,
                                                ['aria-hidden' => 'true']
                                            ); ?>
                                        </span>
                                    <?php endif; ?>

                                    <input
                                        type="date"
                                        class="ha_advanced_search_date_to"
                                        aria-label="<?php echo esc_attr__('To date', 'happy-addons-pro'); ?>">
                                </div>
                            </div>

                        </div>

                    </div>

                <?php endif; ?>

                <!-- Instant Search Results -->
                <?php if ('layout-2' === $layout) : ?>
                    <div id="ha-advanced-search-results-container-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_results_container ha_advanced_search_results-container">
                        <div id="ha-advanced-search-results-list-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_results_list">
                            <!-- Results will be injected here via JS -->
                        </div>
                        <!-- Results will be injected here via JS -->
                        <div class="ha_advanced_search_results_footer">
                            <a href="#" class="ha_advanced_search_view_all_link">
                                <?php echo esc_html($load_more_text); ?>
                            </a>
                        </div>
                    </div>
                <?php elseif ('layout-3' === $layout) : ?>
                    <?php // Layout 3 results container is rendered inside .ha_advanced_search_search-container. 
                    ?>
                <?php elseif ('layout-4' === $layout) : ?>
                    <?php // Layout 4 results container is rendered inside .ha_advanced_search_search-panel. 
                    ?>
                <?php else : ?>
                    <div id="ha-advanced-search-results-container-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_results_container">
                        <div class="ha_advanced_search_results_header">
                            <span class="ha_advanced_search_results_label"><?php echo esc_html($result_box_header_text); ?></span>
                        </div>
                        <div id="ha-advanced-search-results-list-<?php echo esc_attr($widget_id); ?>" class="ha_advanced_search_results_list">
                            <!-- Results will be injected here via JS -->
                        </div>

                        <div class="ha_advanced_search_results_footer">
                            <a href="#" class="ha_advanced_search_view_all_link">
                                <?php echo esc_html($load_more_text); ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Popular Keywords Section (from tracked searches) -->
                <?php if (! $is_layout4 &&  ! $is_layout3 && isset($settings[$show_popular_keyword_key]) && 'yes' === $settings[$show_popular_keyword_key]) : ?>
                    <?php if (! empty($popular_terms)) : ?>
                        <div class="ha-advanced-search-popular-search-section">
                            <h4 class="ha-advanced-search-popular-search-title"><?php echo esc_html($popular_search_text); ?></h4>

                            <div class="ha-advanced-search-popular-keywords">
                                <?php foreach ($popular_terms as $term) : ?>
                                    <span class="ha-advanced-search-keyword"><?php echo esc_html($term); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    <?php else : ?>
                        <div class="ha-advanced-search-popular-search-section">
                            <h4 class="ha-advanced-search-popular-search-title"><?php echo esc_html($popular_search_text); ?></h4>
                            <div class="ha-advanced-search-popular-keywords">
                                <span class="ha-advanced-search-keyword"><?php echo esc_html__('No popular searches yet', 'happy-addons-pro'); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- Helper Text -->
                <?php if (! $is_layout3 && ! $is_layout4 && ! empty($helper_text)) : ?>
                    <p class="ha_advanced_search_helper_text">
                        <?php echo esc_html($helper_text); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
<?php
    }

    protected function get_all_pages() {
        $pages = get_posts([
            'post_type' => 'page',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ]);

        $options = [];
        foreach ($pages as $page) {
            $options[$page->ID] = $page->post_title;
        }
        return $options;
    }
}
