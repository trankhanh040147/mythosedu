<?php
namespace CoreSystem\Modules\ExtensionsDDL\Modules\Timeline\Widgets;

use CoreSystem\Modules\ExtensionsDDL\Base\Widget_Base;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Icons_Manager;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use CoreSystem\Modules\ExtensionsDDL\Inc\Helper;
use CoreSystem\Modules\ExtensionsDDL\Inc\Controls\Groups\Icon;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Timeline Widget
 */
class Timeline extends Widget_Base {
    
    /**
	 * Retrieve timeline widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'co-timeline';
    }

    /**
	 * Retrieve timeline widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
    public function get_title() {
        return __( 'CO - Timeline', ETSDDL_LANG );
    }

    /**
	 * Retrieve the list of categories the timeline widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
    public function get_categories() {
        return [ 'co-extension' ];
    }

    /**
	 * Retrieve timeline widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
    public function get_icon() {
        return 'eicon-time-line';
    }

	/**
	 * Retrieve the list of scripts the timeline widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [
			'jquery-slick',
			'ets-co-timeline',
			'ets-co-frontend'
		];
	}

    public function get_style_depends() {
        return [
            'font-awesome',
            'ets-co-timeline',
        ];
    }

    /**
	 * Register timeline widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
    protected function _register_controls() {

        /*-----------------------------------------------------------------------------------*/
        /*	Content Tab
        /*-----------------------------------------------------------------------------------*/
        
        /**
         * Content Tab: Settings
         */
        $this->start_controls_section(
            'section_post_settings',
            [
                'label'                 => __( 'Settings', ETSDDL_LANG ),
            ]
        );

        $this->add_control(
            'layout',
            [
                'label'                 => __( 'Layout', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                   'horizontal' => __( 'Horizontal', ETSDDL_LANG ),
                   'vertical'   => __( 'Vertical', ETSDDL_LANG ),
                ],
                'default'               => 'vertical',
                'frontend_available'    => true,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'                 => __( 'Columns', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => '3',
                'tablet_default'        => '2',
                'mobile_default'        => '1',
                'options'               => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                ],
                'frontend_available'    => true,
                'condition'             => [
                    'layout'    => 'horizontal'
                ]
            ]
        );

        $this->add_control(
            'source',
            [
                'label'                 => __( 'Source', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                   'custom'     => __( 'Custom', ETSDDL_LANG ),
                   'posts'      => __( 'Posts', ETSDDL_LANG ),
                ],
                'default'               => 'custom',
            ]
        );
        
        $this->add_control(
            'posts_per_page',
            [
                'label'                 => __( 'Posts Per Page', ETSDDL_LANG ),
                'type'                  => Controls_Manager::NUMBER,
                'default'               => 4,
                'condition'             => [
                    'source'	=> 'posts'
                ]
            ]
        );
        
        $this->add_control(
            'dates',
            [
                'label'                 => __( 'Date', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'return_value'          => 'yes',
                'frontend_available'    => true,
            ]
        );
        
        $this->add_control(
            'animate_cards',
            [
                'label'                 => __( 'Animate Cards', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'return_value'          => 'yes',
                'frontend_available'    => true,
                'condition'             => [
                    'layout'    => 'vertical'
                ]
            ]
        );
        
        $this->add_control(
            'arrows',
            [
                'label'                 => __( 'Arrows', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'return_value'          => 'yes',
                'frontend_available'    => true,
                'condition'             => [
                    'layout'    => 'horizontal'
                ]
            ]
        );
        
        $this->add_control(
            'autoplay',
            [
                'label'                 => __( 'Autoplay', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'return_value'          => 'yes',
                'frontend_available'    => true,
                'condition'             => [
                    'layout'    => 'horizontal'
                ]
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'                 => __( 'Autoplay Speed', ETSDDL_LANG ),
                'type'                  => Controls_Manager::NUMBER,
                'default'               => 3000,
                'frontend_available'    => true,
                'condition'             => [
                    'layout'    => 'horizontal',
                    'autoplay'  => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Timeline
         */
        $this->start_controls_section(
            'section_timeline_items',
            [
                'label'                 => __( 'Timeline', ETSDDL_LANG ),
                'condition'             => [
                    'source'    => 'custom'
                ]
            ]
        );
        
        $repeater = new Repeater();
        
        $repeater->start_controls_tabs( 'timeline_items_tabs' );

        $repeater->start_controls_tab( 'tab_timeline_items_content', [ 'label' => __( 'Content', ETSDDL_LANG ) ] );
        
            $repeater->add_control(
                'timeline_item_date',
                [
                    'label'             => __( 'Date', ETSDDL_LANG ),
                    'type'              => Controls_Manager::TEXT,
                    'label_block'       => false,
                    'default'           => __( '1 June 2018', ETSDDL_LANG ),
                ]
            );
        
            $repeater->add_control(
                'timeline_item_title',
                [
                    'label'             => __( 'Title', ETSDDL_LANG ),
                    'type'              => Controls_Manager::TEXT,
                    'label_block'       => false,
                    'default'           => '',
                ]
            );

            $repeater->add_group_control(
                Icon::get_type(),
                [
                    'name'  => 'item_icon',
                    'label' => 'Icon'
                ]
            );

            $repeater->add_control(
                'timeline_item_link',
                [
                    'label'                 => __( 'Link', ETSDDL_LANG ),
                    'type'                  => Controls_Manager::URL,
                    'dynamic'               => [
                        'active'        => true,
                        'categories'    => [
                            TagsModule::POST_META_CATEGORY,
                            TagsModule::URL_CATEGORY
                        ],
                    ],
                    'placeholder'           => 'https://www.your-link.com',
                    'default'               => [
                        'url' => '',
                    ],
                ]
            );
        
            $repeater->add_control(
                'timeline_item_content',
                [
                    'label'             => __( 'Content', ETSDDL_LANG ),
                    'type'              => Controls_Manager::WYSIWYG,
                    'default'           => '',
                ]
            );
        
        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 'tab_timeline_items_image', [ 'label' => __( 'Image', ETSDDL_LANG ) ] );
        
        $repeater->add_control(
            'card_image',
            [
                'label'                 => __( 'Show Image', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'              => __( 'Yes', ETSDDL_LANG ),
                'label_off'             => __( 'No', ETSDDL_LANG ),
                'return_value'          => 'yes',
            ]
        );
        
        $repeater->add_control(
			'image',
			[
				'label'                 => __( 'Choose Image', ETSDDL_LANG ),
				'type'                  => \Elementor\Controls_Manager::MEDIA,
				'default'               => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
                'conditions'            => [
                    'terms' => [
                        [
                            'name'      => 'card_image',
                            'operator'  => '==',
                            'value'     => 'yes',
                        ],
                    ],
                ],
			]
		);
        
        $repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'                  => 'image',
                'exclude'               => [ 'custom' ],
				'include'               => [],
				'default'               => 'large',
                'conditions'            => [
                    'terms' => [
                        [
                            'name'      => 'card_image',
                            'operator'  => '==',
                            'value'     => 'yes',
                        ],
                    ],
                ],
			]
		);
        
        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 'tab_timeline_items_style', [ 'label' => __( 'Style', ETSDDL_LANG ) ] );
        
        $repeater->add_control(
            'custom_style',
            [
                'label'                 => __( 'Custom Style', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'              => __( 'Yes', ETSDDL_LANG ),
                'label_off'             => __( 'No', ETSDDL_LANG ),
                'return_value'          => 'yes',
            ]
        );

        $repeater->add_control(
            'single_icon_color',
            [
                'label'                 => __( 'Icon Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ets-co-timeline-icon, {{WRAPPER}} .slick-center .ets-co-timeline-icon' => 'color: {{VALUE}}',
                ],
                'conditions'            => [
                    'terms' => [
                        [
                            'name'      => 'custom_style',
                            'operator'  => '==',
                            'value'     => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'single_icon_bg_color',
            [
                'label'                 => __( 'Icon Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ets-co-timeline-icon, {{WRAPPER}} .slick-center .ets-co-timeline-icon' => 'background-color: {{VALUE}}',
                ],
                'conditions'            => [
                    'terms' => [
                        [
                            'name'      => 'custom_style',
                            'operator'  => '==',
                            'value'     => 'yes',
                        ],
                    ],
                ],
            ]
        );
        
        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'items',
            [
                'label'                 => '',
                'type'                  => Controls_Manager::REPEATER,
                'default'               => [
                    [
                        'timeline_item_date'    => __( '1 May 2020', ETSDDL_LANG ),
                        'timeline_item_title'   => __( 'Item 1', ETSDDL_LANG ),
                        'timeline_item_content' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', ETSDDL_LANG ),
                    ],
                    [
                        'timeline_item_date'    => __( '1 June 2020', ETSDDL_LANG ),
                        'timeline_item_title'   => __( 'Item 2', ETSDDL_LANG ),
                        'timeline_item_content' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', ETSDDL_LANG ),
                    ],
                    [
                        'timeline_item_date'    => __( '1 July 2020', ETSDDL_LANG ),
                        'timeline_item_title'   => __( 'Item 3', ETSDDL_LANG ),
                        'timeline_item_content' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', ETSDDL_LANG ),
                    ],
                    [
                        'timeline_item_date'    => __( '1 August 2020', ETSDDL_LANG ),
                        'timeline_item_title'   => __( 'Item 4', ETSDDL_LANG ),
                        'timeline_item_content' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', ETSDDL_LANG ),
                    ],
                ],
                'fields'                => array_values( $repeater->get_controls() ),
                'title_field'           => '{{{ timeline_item_date }}}',
                'condition'             => [
                    'source'    => 'custom'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Query
         */
        $this->start_controls_section(
            'section_post_query',
            [
                'label'                 => __( 'Query', ETSDDL_LANG ),
                'condition'             => [
                    'source'    => 'posts'
                ]
            ]
        );

		$this->add_control(
            'post_type',
            [
                'label'                 => __( 'Post Type', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => Helper::get_post_types(),
                'default'               => 'post',
                'condition'             => [
                    'source'    => 'posts'
                ]

            ]
        );

        $this->add_control(
            'categories',
            [
                'label'                 => __( 'Categories', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SELECT2,
				'label_block'           => true,
				'multiple'              => true,
				'options'               => Helper::get_post_categories(),
                'condition'             => [
                    'source'    => 'posts',
                    'post_type' => 'post'
                ]
            ]
        );

        $this->add_control(
            'authors',
            [
                'label'                 => __( 'Authors', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SELECT2,
				'label_block'           => true,
				'multiple'              => true,
				'options'               => Helper::get_authors(),
                'condition'             => [
                    'source'    => 'posts'
                ]
            ]
        );

        $this->add_control(
            'tags',
            [
                'label'                 => __( 'Tags', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SELECT2,
				'label_block'           => true,
				'multiple'              => true,
				'options'               => Helper::get_tags(),
                'condition'             => [
                    'source'    => 'posts'
                ]
            ]
        );

        $this->add_control(
            'exclude_posts',
            [
                'label'                 => __( 'Exclude Posts', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SELECT2,
				'label_block'           => true,
				'multiple'              => true,
				'options'               => Helper::get_posts(),
                'condition'             => [
                    'source'    => 'posts'
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'label'                 => __( 'Order', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                   'DESC'       => __( 'Descending', ETSDDL_LANG ),
                   'ASC'        => __( 'Ascending', ETSDDL_LANG ),
                ],
                'default'               => 'DESC',
                'condition'             => [
                    'source'    => 'posts'
                ]
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'                 => __( 'Order By', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                   'date'           => __( 'Date', ETSDDL_LANG ),
                   'modified'       => __( 'Last Modified Date', ETSDDL_LANG ),
                   'rand'           => __( 'Rand', ETSDDL_LANG ),
                   'comment_count'  => __( 'Comment Count', ETSDDL_LANG ),
                   'title'          => __( 'Title', ETSDDL_LANG ),
                   'ID'             => __( 'Post ID', ETSDDL_LANG ),
                   'author'         => __( 'Post Author', ETSDDL_LANG ),
                ],
                'default'               => 'date',
                'condition'             => [
                    'source'    => 'posts'
                ]
            ]
        );

        $this->add_control(
            'offset',
            [
                'label'                 => __( 'Offset', ETSDDL_LANG ),
                'type'                  => Controls_Manager::TEXT,
                'default'               => '',
                'condition'             => [
                    'source'    => 'posts'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Posts
         */
        $this->start_controls_section(
            'section_posts',
            [
                'label'                 => __( 'Posts', ETSDDL_LANG ),
                'condition'             => [
                    'source'    => 'posts'
                ]
            ]
        );
        
        $this->add_control(
            'post_title',
            [
                'label'                 => __( 'Post Title', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'show',
                'label_on'              => __( 'Show', ETSDDL_LANG ),
                'label_off'             => __( 'Hide', ETSDDL_LANG ),
                'return_value'          => 'show',
                'condition'             => [
                    'source'    => 'posts'
                ]
            ]
        );
        
        $this->add_control(
            'post_image',
            [
                'label'                 => __( 'Post Image', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'show',
                'label_on'              => __( 'Show', ETSDDL_LANG ),
                'label_off'             => __( 'Hide', ETSDDL_LANG ),
                'return_value'          => 'show',
                'condition'             => [
                    'source'    => 'posts'
                ]
            ]
        );
		
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'                  => 'image_size',
				'label'                 => __( 'Image Size', ETSDDL_LANG ),
				'default'               => 'medium_large',
                'condition'             => [
                    'source'        => 'posts',
                    'post_image'    => 'show'
                ]
			]
		);
        
        $this->add_control(
            'post_content',
            [
                'label'                 => __( 'Post Content', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'show',
                'label_on'              => __( 'Show', ETSDDL_LANG ),
                'label_off'             => __( 'Hide', ETSDDL_LANG ),
                'return_value'          => 'show',
                'condition'             => [
                    'source'    => 'posts'
                ]
            ]
        );

        $this->add_control(
            'content_type',
            [
                'label'                 => __( 'Content Type', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                   'excerpt'            => __( 'Excerpt', ETSDDL_LANG ),
                   'limited-content'    => __( 'Limited Content', ETSDDL_LANG ),
                ],
                'default'               => 'excerpt',
                'condition'             => [
                    'source'        => 'posts',
                    'post_content'  => 'show'
                ]
            ]
        );
        
        $this->add_control(
            'content_length',
            [
                'label'                 => __( 'Content Limit', ETSDDL_LANG ),
                'title'                 => __( 'Words', ETSDDL_LANG ),
                'type'                  => Controls_Manager::NUMBER,
                'default'               => 40,
                'min'                   => 0,
                'step'                  => 1,
                'condition'             => [
                    'source'        => 'posts',
                    'post_content'  => 'show',
                    'content_type'  => 'limited-content'
                ]
            ]
        );

        $this->add_control(
            'link_type',
            [
                'label'                 => __( 'Link Type', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                   ''           => __( 'None', ETSDDL_LANG ),
                   'title'      => __( 'Title', ETSDDL_LANG ),
                   'button'     => __( 'Button', ETSDDL_LANG ),
                   'card'       => __( 'Card', ETSDDL_LANG ),
                ],
                'default'               => 'title',
                'condition'             => [
                    'source'        => 'posts',
                ]
            ]
        );
        
        $this->add_control(
            'button_text',
            [
                'label'                 => __( 'Button Text', ETSDDL_LANG ),
                'type'                  => Controls_Manager::TEXT,
                'label_block'           => false,
                'default'               => __( 'Read More', ETSDDL_LANG ),
                'condition'             => [
                    'source'        => 'posts',
                    'link_type'     => 'button',
                ]
            ]
        );
        
        $this->add_control(
            'post_meta',
            [
                'label'                 => __( 'Post Meta', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'              => __( 'Show', ETSDDL_LANG ),
                'label_off'             => __( 'Hide', ETSDDL_LANG ),
                'return_value'          => 'show',
                'condition'             => [
                    'source'    => 'posts'
                ]
            ]
        );

        $this->add_control(
            'meta_items_divider',
            [
                'label'             => __( 'Meta Items Divider', ETSDDL_LANG ),
                'type'              => Controls_Manager::TEXT,
                'default'           => '-',
				'selectors'         => [
					'{{WRAPPER}} .ets-co-timeline-meta > span:not(:last-child):after' => 'content: "{{UNIT}}";',
				],
                'condition'         => [
                    'source'    => 'posts',
                    'post_meta' => 'show'
                ],
            ]
        );
        
        $this->add_control(
            'post_author',
            [
                'label'                 => __( 'Post Author', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'show',
                'label_on'              => __( 'Show', ETSDDL_LANG ),
                'label_off'             => __( 'Hide', ETSDDL_LANG ),
                'return_value'          => 'show',
                'condition'             => [
                    'source'    => 'posts',
                    'post_meta' => 'show'
                ]
            ]
        );
        
        $this->add_control(
            'post_category',
            [
                'label'                 => __( 'Post Category', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'              => __( 'Show', ETSDDL_LANG ),
                'label_off'             => __( 'Hide', ETSDDL_LANG ),
                'return_value'          => 'show',
                'condition'             => [
                    'source'    => 'posts',
                    'post_meta' => 'show'
                ]
            ]
        );

        $this->end_controls_section();
        
        /*-----------------------------------------------------------------------------------*/
        /*	STYLE TAB
        /*-----------------------------------------------------------------------------------*/

        /**
         * Style Tab: Content
         */
        $this->start_controls_section(
            'section_layout_style',
            [
                'label'                 => __( 'Layout', ETSDDL_LANG ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'direction',
            [
                'label'                 => __( 'Direction', ETSDDL_LANG ),
                'type'                  => Controls_Manager::CHOOSE,
                'toggle'                => true,
                'default'               => 'center',
                'tablet_default'        => 'center',
                'mobile_default'        => 'center',
                'options'               => [
                    'left' 		=> [
                        'title' => __( 'Left', ETSDDL_LANG ),
                        'icon' 	=> 'eicon-h-align-left',
                    ],
                    'center' 	=> [
                        'title' => __( 'Center', ETSDDL_LANG ),
                        'icon' 	=> 'eicon-h-align-center',
                    ],
                    'right' 	=> [
                        'title' => __( 'Right', ETSDDL_LANG ),
                        'icon' 	=> 'eicon-h-align-right',
                    ],
                ],
                'condition'             => [
                    'layout'    => 'vertical',
                ]
            ]
        );

        $this->add_responsive_control(
            'direction_date',
            [
                'label'                 => __( 'Direction Date', ETSDDL_LANG ),
                'type'                  => Controls_Manager::CHOOSE,
                'default'               => 'right',
                'tablet_default'        => 'right',
                'mobile_default'        => 'right',
                'options'               => [
                    'left' 		=> [
                        'title' => __( 'Left', ETSDDL_LANG ),
                        'icon' 	=> 'eicon-h-align-left',
                    ],
                    'right' 	=> [
                        'title' => __( 'Right', ETSDDL_LANG ),
                        'icon' 	=> 'eicon-h-align-right',
                    ],
                ],
                'condition'             => [
                    'layout'    => 'vertical',
                    'direction!' => 'center'
                ]
            ]
        );

		$this->add_control(
			'cards_arrows_alignment',
			[
				'label'                 => __( 'Arrows Alignment', ETSDDL_LANG ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'options'               => [
					'top'       => [
						'title' => __( 'Top', ETSDDL_LANG ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle'    => [
						'title' => __( 'Middle', ETSDDL_LANG ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom'    => [
						'title' => __( 'Bottom', ETSDDL_LANG ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'               => 'top',
                'condition'             => [
                    'layout'    => 'vertical'
                ]
			]
		);

        $this->add_control(
            'items_spacing',
            [
                'label'                 => __( 'Items Spacing', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size' 	    => '',
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> 0,
                        'max' 	=> 100,
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-vertical .ets-co-timeline-item' => 'margin-bottom: {{SIZE}}px;',
                    '{{WRAPPER}} .ets-co-timeline-horizontal .ets-co-timeline-item' => 'padding-left: {{SIZE}}px; padding-right: {{SIZE}}px;',
                    '{{WRAPPER}} .ets-co-timeline-horizontal .slick-list'       => 'margin-left: -{{SIZE}}px; margin-right: -{{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Cards
         */
        $this->start_controls_section(
            'section_cards_style',
            [
                'label'                 => __( 'Cards', ETSDDL_LANG ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'cards_padding',
			[
				'label'                 => __( 'Cards Padding', ETSDDL_LANG ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .ets-co-timeline .ets-co-timeline-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_padding',
			[
				'label'                 => __( 'Content Padding', ETSDDL_LANG ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .ets-co-timeline .ets-co-timeline-card-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'cards_text_align',
            [
                'label'                 => __( 'Text Align', ETSDDL_LANG ),
                'type'                  => Controls_Manager::CHOOSE,
                'options'               => [
                    'left' 	=> [
                        'title' 	=> __( 'Left', ETSDDL_LANG ),
                        'icon' 		=> 'fa fa-align-left',
                    ],
                    'center' 		=> [
                        'title' 	=> __( 'Center', ETSDDL_LANG ),
                        'icon' 		=> 'fa fa-align-center',
                    ],
                    'right' 		=> [
                        'title' 	=> __( 'Right', ETSDDL_LANG ),
                        'icon' 		=> 'fa fa-align-right',
                    ],
                ],
                'default'               => 'left',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-card' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        
        $this->start_controls_tabs( 'card_tabs' );
        
        $this->start_controls_tab( 'tab_card_normal', [ 'label' => __( 'Normal', ETSDDL_LANG ) ] );

        $this->add_control(
            'cards_bg',
            [
                'label'                 => __( 'Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-card' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-arrow' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'cards_border',
				'label'                 => __( 'Border', ETSDDL_LANG ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-card',
			]
		);

		$this->add_control(
			'cards_border_radius',
			[
				'label'                 => __( 'Border Radius', ETSDDL_LANG ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .ets-co-timeline .ets-co-timeline-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_control(
			'cards_box_shadow',
			[
				'label'                 => __( 'Box Shadow', ETSDDL_LANG ),
				'type'                  => \Elementor\Controls_Manager::POPOVER_TOGGLE,
				'label_off'             => __( 'Default', ETSDDL_LANG ),
				'label_on'              => __( 'Custom', ETSDDL_LANG ),
				'return_value'          => 'yes',
			]
		);

		$this->start_popover();

			$this->add_control(
				'cards_box_shadow_color',
				[
					'label'                => __( 'Color', ETSDDL_LANG ),
					'type'                 => Controls_Manager::COLOR,
					'default'              => 'rgba(0,0,0,0.5)',
					'selectors'            => [
						'{{WRAPPER}} .ets-co-timeline-card' => 'filter: drop-shadow({{cards_box_shadow_horizontal.SIZE}}px {{cards_box_shadow_vertical.SIZE}}px {{cards_box_shadow_blur.SIZE}}px {{VALUE}}); -webkit-filter: drop-shadow({{cards_box_shadow_horizontal.SIZE}}px {{cards_box_shadow_vertical.SIZE}}px {{cards_box_shadow_blur.SIZE}}px {{VALUE}});',
					],
					'condition'            => [
						'cards_box_shadow' => 'yes',
					],
				]
			);

			$this->add_control(
				'cards_box_shadow_horizontal',
				[
					'label'                => __( 'Horizontal', ETSDDL_LANG ),
					'type'                 => Controls_Manager::SLIDER,
					'default'              => [
						'size' => 0,
						'unit' => 'px',
					],
					'range'                => [
						'px' => [
							'min'  => -100,
							'max'  => 100,
							'step' => 1,
						],
					],
					'condition'            => [
						'cards_box_shadow' => 'yes',
					],
				]
			);

			$this->add_control(
				'cards_box_shadow_vertical',
				[
					'label'                => __( 'Vertical', ETSDDL_LANG ),
					'type'                 => Controls_Manager::SLIDER,
					'default'              => [
						'size' => 0,
						'unit' => 'px',
					],
					'range'                => [
						'px' => [
							'min'  => -100,
							'max'  => 100,
							'step' => 1,
						],
					],
					'condition'            => [
						'cards_box_shadow' => 'yes',
					],
				]
			);

			$this->add_control(
				'cards_box_shadow_blur',
				[
					'label'                => __( 'Blur', ETSDDL_LANG ),
					'type'                 => Controls_Manager::SLIDER,
					'default'              => [
						'size' => 4,
						'unit' => 'px',
					],
					'range'                => [
						'px' => [
							'min'  => 1,
							'max'  => 10,
							'step' => 1,
						],
					],
					'condition'            => [
						'cards_box_shadow' => 'yes',
					],
				]
			);

		$this->end_popover();

		$this->add_control(
			'heading_image',
			[
				'label'                 => __( 'Image', ETSDDL_LANG ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);
        
        $this->add_responsive_control(
            'image_margin_bottom',
            [
                'label'                 => __( 'Spacing', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size' 	    => 20,
                ],
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-card-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->add_control(
			'heading_title',
			[
				'label'                 => __( 'Title', ETSDDL_LANG ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

        $this->add_control(
            'title_bg',
            [
                'label'                 => __( 'Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-card-title-wrap' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label'                 => __( 'Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-card-title' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'title_typography',
                'label'                 => __( 'Typography', ETSDDL_LANG ),
                'selector'              => '{{WRAPPER}} .ets-co-timeline-card-title',
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'title_border',
				'label'                 => __( 'Border', ETSDDL_LANG ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-card-title-wrap',
			]
		);
        
        $this->add_responsive_control(
            'title_margin_bottom',
            [
                'label'                 => __( 'Spacing', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-card-title-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->add_control(
			'title_padding',
			[
				'label'                 => __( 'Title Padding', ETSDDL_LANG ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .ets-co-timeline .ets-co-timeline-card-title-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_content',
			[
				'label'                 => __( 'Content', ETSDDL_LANG ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

        $this->add_control(
            'card_text_color',
            [
                'label'                 => __( 'Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-card' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'card_text_typography',
                'label'                 => __( 'Typography', ETSDDL_LANG ),
                'selector'              => '{{WRAPPER}} .ets-co-timeline-card',
            ]
        );

		$this->add_control(
			'meta_content',
			[
				'label'                 => __( 'Post Meta', ETSDDL_LANG ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
                'condition'             => [
                    'source'    => 'posts',
                    'post_meta' => 'show'
                ]
			]
		);

        $this->add_control(
            'meta_text_color',
            [
                'label'                 => __( 'Text Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-meta' => 'color: {{VALUE}}',
                ],
                'condition'             => [
                    'source'    => 'posts',
                    'post_meta' => 'show'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'meta_typography',
                'label'                 => __( 'Typography', ETSDDL_LANG ),
                'selector'              => '{{WRAPPER}} .ets-co-timeline-meta',
                'condition'             => [
                    'source'    => 'posts',
                    'post_meta' => 'show'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'meta_items_gap',
            [
                'label'                 => __( 'Meta Items Gap', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size' 	    => 10,
                ],
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 60,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-meta > span:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ets-co-timeline-meta > span:not(:last-child):after' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition'         => [
                    'source'    => 'posts',
                    'post_meta' => 'show'
                ],
            ]
        );
        
        $this->add_responsive_control(
            'meta_margin_bottom',
            [
                'label'                 => __( 'Spacing', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size' 	    => 20,
                ],
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 60,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'         => [
                    'source'    => 'posts',
                    'post_meta' => 'show'
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab( 'tab_card_hover', [ 'label' => __( 'Hover', ETSDDL_LANG ) ] );

        $this->add_control(
            'card_bg_hover',
            [
                'label'                 => __( 'Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-item:hover .ets-co-timeline-card' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-item:hover .ets-co-timeline-arrow' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'title_bg_hover',
            [
                'label'                 => __( 'Title Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-item:hover .ets-co-timeline-card-title-wrap' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'card_title_color_hover',
            [
                'label'                 => __( 'Title Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-item:hover .ets-co-timeline-card-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'card_title_border_color_hover',
            [
                'label'                 => __( 'Title Border Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-item:hover .ets-co-timeline-card-title-wrap' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'card_color_hover',
            [
                'label'                 => __( 'Content Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-item:hover .ets-co-timeline-card' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'card_border_color_hover',
            [
                'label'                 => __( 'Border Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-item:hover .ets-co-timeline-card' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab( 'tab_card_focused', [ 'label' => __( 'Focused', ETSDDL_LANG ) ] );

        $this->add_control(
            'card_bg_focused',
            [
                'label'                 => __( 'Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-item-active .ets-co-timeline-card, {{WRAPPER}} .ets-co-timeline .slick-current .ets-co-timeline-card' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-item-active .ets-co-timeline-arrow, {{WRAPPER}} .ets-co-timeline .slick-current .ets-co-timeline-arrow' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'title_bg_focused',
            [
                'label'                 => __( 'Title Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-item-active .ets-co-timeline-card-title-wrap, {{WRAPPER}} .ets-co-timeline .slick-current .ets-co-timeline-card-title-wrap' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'card_title_color_focused',
            [
                'label'                 => __( 'Title Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-item-active .ets-co-timeline-card-title, {{WRAPPER}} .ets-co-timeline .slick-current .ets-co-timeline-card-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'card_title_border_color_focused',
            [
                'label'                 => __( 'Title Border Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-item-active .ets-co-timeline-card-title-wrap, {{WRAPPER}} .ets-co-timeline .slick-current .ets-co-timeline-card-title-wrap' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'card_color_focused',
            [
                'label'                 => __( 'Content Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-item-active .ets-co-timeline-card, {{WRAPPER}} .ets-co-timeline .slick-current .ets-co-timeline-card' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'card_border_color_focused',
            [
                'label'                 => __( 'Border Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline .ets-co-timeline-item-active .ets-co-timeline-card, {{WRAPPER}} .ets-co-timeline .slick-current .ets-co-timeline-card' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();

        /**
         * Style Tab: Icon
         */
        $this->start_controls_section(
            'section_icon_style',
            [
                'label'                 => __( 'Icon', ETSDDL_LANG ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'icon_type',
			[
				'label'                 => esc_html__( 'Type', ETSDDL_LANG ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'toggle'                => false,
				'options'               => [
                    'none' => [
                        'title' => esc_html__( 'None', ETSDDL_LANG ),
                        'icon'  => 'fa fa-ban',
                    ],
					'icon' => [
						'title' => esc_html__( 'Icon', ETSDDL_LANG ),
						'icon' => 'fa fa-gear',
					],
					'number' => [
						'title' => esc_html__( 'Number', ETSDDL_LANG ),
						'icon' => 'fa fa-sort-numeric-asc',
					],
					'letter' => [
						'title' => esc_html__( 'Letter', ETSDDL_LANG ),
						'icon' => 'fa fa-sort-alpha-asc',
					],
				],
				'default'               => 'icon',
			]
		);

        $this->add_group_control(
            Icon::get_type(),
            [
                'name'  => 'icon_icon',
                'label' => 'Icon',
                'default'               => 'fa fa-calendar',
                'condition'             => [
                    'icon_type'   => 'icon'
                ]
            ]
        );

        /*$this->add_control(
            'icon_icon',
            [
                'label'                 => __( 'Choose Icon', ETSDDL_LANG ),
                'type'                  => Controls_Manager::ICON,
                'default'               => 'fa fa-calendar',
                'condition'             => [
                    'icon_type'   => 'icon'
                ]
            ]
        );*/

        
        $this->add_responsive_control(
            'icon_size',
            [
                'label'                 => __( 'Icon Size', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 5,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', 'em' ],
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'icon_type!'  => 'none'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'icon_box_size',
            [
                'label'                 => __( 'Icon Box Size', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 10,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .ets-co-timeline-connector-wrap' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ets-co-timeline-navigation:before, {{WRAPPER}} .ets-co-timeline-navigation .ets-co-slider-arrow' => 'bottom: calc( {{SIZE}}{{UNIT}}/2 );',
                ],
            ]
        );
        
        $this->start_controls_tabs( 'icon_tabs' );
        
        $this->start_controls_tab( 'tab_icon_normal', [ 'label' => __( 'Normal', ETSDDL_LANG ) ] );

        $this->add_control(
            'icon_color',
            [
                'label'                 => __( 'Icon Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_bg',
            [
                'label'                 => __( 'Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-icon' => 'background-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'icon_border',
				'label'                 => __( 'Border', ETSDDL_LANG ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .ets-co-timeline-icon',
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label'                 => __( 'Border Radius', ETSDDL_LANG ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .ets-co-timeline-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'icon_box_shadow',
				'selector'              => '{{WRAPPER}} .ets-co-timeline-icon',
			]
		);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab( 'tab_icon_hover', [ 'label' => __( 'Hover', ETSDDL_LANG ) ] );

        $this->add_control(
            'icon_color_hover',
            [
                'label'                 => __( 'Icon Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-icon-wrapper:hover .ets-co-timeline-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_hover',
            [
                'label'                 => __( 'Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-icon-wrapper:hover .ets-co-timeline-icon' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_border_color_hover',
            [
                'label'                 => __( 'Border Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-icon-wrapper:hover .ets-co-timeline-icon' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab( 'tab_icon_focused', [ 'label' => __( 'Focused', ETSDDL_LANG ) ] );

        $this->add_control(
            'icon_color_focused',
            [
                'label'                 => __( 'Icon Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-item-active .ets-co-timeline-icon, {{WRAPPER}} .slick-current .ets-co-timeline-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_focused',
            [
                'label'                 => __( 'Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-item-active .ets-co-timeline-icon, {{WRAPPER}} .slick-current .ets-co-timeline-icon' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_border_color_focused',
            [
                'label'                 => __( 'Border Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-item-active .ets-co-timeline-icon, {{WRAPPER}} .slick-current .ets-co-timeline-icon' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();

        /**
         * Style Tab: Dates
         */
        $this->start_controls_section(
            'section_dates_style',
            [
                'label'                 => __( 'Date', ETSDDL_LANG ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->start_controls_tabs( 'dates_tabs' );
        
        $this->start_controls_tab( 'tab_dates_normal', [ 'label' => __( 'Normal', ETSDDL_LANG ) ] );

        $this->add_control(
            'dates_bg',
            [
                'label'                 => __( 'Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-card-date' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'dates_color',
            [
                'label'                 => __( 'Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-card-date' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'dates_border',
				'label'                 => __( 'Border', ETSDDL_LANG ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .ets-co-timeline-card-date',
			]
		);

		$this->add_control(
			'dates_border_radius',
			[
				'label'                 => __( 'Border Radius', ETSDDL_LANG ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .ets-co-timeline-card-date' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dates_padding',
			[
				'label'                 => __( 'Padding', ETSDDL_LANG ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .ets-co-timeline-card-date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'align',
            [
                'label' => __( 'Alignment', 'elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justified', 'elementor' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .ets-co-timeline-card-date-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'dates_box_shadow',
				'selector'              => '{{WRAPPER}} .ets-co-timeline-card-date',
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'date_typography',
                'label'     => __( 'Typography', ETSDDL_LANG ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .ets-co-timeline-card-date',
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab( 'tab_dates_hover', [ 'label' => __( 'Hover', ETSDDL_LANG ) ] );

        $this->add_control(
            'dates_bg_hover',
            [
                'label'                 => __( 'Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-card-date:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'dates_color_hover',
            [
                'label'                 => __( 'Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-card-date:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'dates_border_color_hover',
            [
                'label'                 => __( 'Border Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-card-date:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab( 'tab_dates_focused', [ 'label' => __( 'Focused', ETSDDL_LANG ) ] );

        $this->add_control(
            'dates_bg_focused',
            [
                'label'                 => __( 'Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-item-active .ets-co-timeline-card-date' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'dates_color_focused',
            [
                'label'                 => __( 'Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-item-active .ets-co-timeline-card-date' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'dates_border_color_focused',
            [
                'label'                 => __( 'Border Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-item-active .ets-co-timeline-card-date' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Style Tab: Connector
         */
        $this->start_controls_section(
            'section_connector_style',
            [
                'label'                 => __( 'Connector', ETSDDL_LANG ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'connector_spacing',
            [
                'label'                 => __( 'Spacing', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size' 	    => '',
                ],
                'range'                 => [
                    'px' 		=> [
                        'min' 	=> 0,
                        'max' 	=> 100,
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-vertical.ets-co-timeline-left .ets-co-timeline-icon-wrapper' => 'margin-right: {{SIZE}}px;',
                    '{{WRAPPER}} .ets-co-timeline-vertical.ets-co-timeline-right .ets-co-timeline-icon-wrapper' => 'margin-left: {{SIZE}}px;',
                    '{{WRAPPER}} .ets-co-timeline-vertical.ets-co-timeline-center .ets-co-timeline-icon-wrapper' => 'margin-left: {{SIZE}}px; margin-right: {{SIZE}}px',
            
                    '(tablet){{WRAPPER}} .ets-co-timeline-vertical.ets-co-timeline-tablet-left .ets-co-timeline-icon-wrapper' => 'margin-right: {{SIZE}}px;',
                    '(tablet){{WRAPPER}} .ets-co-timeline-vertical.ets-co-timeline-tablet-right .ets-co-timeline-icon-wrapper' => 'margin-left: {{SIZE}}px;',
                    '(tablet){{WRAPPER}} .ets-co-timeline-vertical.ets-co-timeline-tablet-center .ets-co-timeline-icon-wrapper' => 'margin-left: {{SIZE}}px; margin-right: {{SIZE}}px',
            
                    '(mobile){{WRAPPER}} .ets-co-timeline-vertical.ets-co-timeline-mobile-left .ets-co-timeline-icon-wrapper' => 'margin-right: {{SIZE}}px !important;',
                    '(mobile){{WRAPPER}} .ets-co-timeline-vertical.ets-co-timeline-mobile-right .ets-co-timeline-icon-wrapper' => 'margin-left: {{SIZE}}px !important;',
                    '(mobile){{WRAPPER}} .ets-co-timeline-vertical.ets-co-timeline-mobile-center .ets-co-timeline-icon-wrapper' => 'margin-left: {{SIZE}}px !important; margin-right: {{SIZE}}px !important;',
            
                    '{{WRAPPER}} .ets-co-timeline-horizontal' 	=> 'margin-top: {{SIZE}}px;',
                    '{{WRAPPER}} .ets-co-timeline-navigation .ets-co-timeline-card-date-wrapper' 	=> 'margin-bottom: {{SIZE}}px;',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'connector_thickness',
            [
                'label'                 => __( 'Thickness', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SLIDER,
                'range'             => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 12,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-vertical .ets-co-timeline-connector' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ets-co-timeline-navigation:before' => 'height: {{SIZE}}{{UNIT}}; transform: translateY(calc({{SIZE}}{{UNIT}}/2))',
                ],
            ]
        );

        $this->add_control(
            'connector_top',
            [
                'label'                 => __( 'Top', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SLIDER,
                'range'             => [
                    'px' => [
                        'min'   => -500,
                        'max'   => 500,
                        'step'  => 1,
                    ],
                    '%' => [
                        'min'   => -100,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors' => [
                        '{{WRAPPER}} .ets-co-timeline-vertical .ets-co-timeline-connector' => 'top: {{SIZE}}{{UNIT}} !important;',
                ],
                'condition' => [
                    'layout' => 'vertical',
                ]
            ]
        );

        $this->add_control(
            'connector_bottom',
            [
                'label'                 => __( 'Bottom', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SLIDER,
                'range'             => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 500,
                        'step'  => 1,
                    ],
                    '%' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ets-co-timeline-vertical .ets-co-timeline-connector' => 'bottom: {{SIZE}}{{UNIT}} !important;',
                ],
                'condition' => [
                    'layout' => 'vertical',
                ]
            ]
        );
        
        $this->start_controls_tabs( 'tabs_connector' );
        
        $this->start_controls_tab( 'tab_connector_normal', [ 'label' => __( 'Normal', ETSDDL_LANG ) ] );
			
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'                  => 'connector_bg',
                'label'                 => __( 'Background', ETSDDL_LANG ),
                'types'                 => [ 'classic', 'gradient' ],
                'exclude'               => [ 'image' ],
                'selector'              => '{{WRAPPER}} .ets-co-timeline-connector',
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab( 'tab_connector_progress', [ 'label' => __( 'Progress', ETSDDL_LANG ) ] );
			
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'                  => 'connector_bg_progress',
                'label'                 => __( 'Background', ETSDDL_LANG ),
                'types'                 => [ 'classic', 'gradient' ],
                'exclude'               => [ 'image' ],
                'selector'              => '{{WRAPPER}} .ets-co-timeline-connector-inner',
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();

        /**
         * Style Tab: Arrows
         */
        $this->start_controls_section(
            'section_arrows_style',
            [
                'label'                 => __( 'Arrows', ETSDDL_LANG ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'layout'        => 'horizontal',
                    'arrows'        => 'yes',
                ],
            ]
        );
        
        $this->add_control(
			'arrow',
			[
				'label'                 => __( 'Choose Arrow', ETSDDL_LANG ),
				'type'                  => Controls_Manager::ICON,
				'include'               => [
					'fa fa-angle-right',
                    'fa fa-angle-double-right',
                    'fa fa-chevron-right',
                    'fa fa-chevron-circle-right',
                    'fa fa-arrow-right',
                    'fa fa-long-arrow-right',
                    'fa fa-caret-right',
                    'fa fa-caret-square-o-right',
                    'fa fa-arrow-circle-right',
                    'fa fa-arrow-circle-o-right',
                    'fa fa-toggle-right',
                    'fa fa-hand-o-right',
				],
				'default'               => 'fa fa-angle-right',
				'frontend_available'    => true,
                'condition'             => [
                    'layout'        => 'horizontal',
                    'arrows'        => 'yes',
                ],
			]
		);
        
        $this->add_responsive_control(
            'arrows_size',
            [
                'label'                 => __( 'Arrows Size', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => '22' ],
                'range'                 => [
                    'px' => [
                        'min'   => 15,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}} .ets-co-timeline-navigation .ets-co-slider-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				],
                'condition'             => [
                    'layout'        => 'horizontal',
                    'arrows'        => 'yes',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'arrows_box_size',
            [
                'label'                 => __( 'Arrows Box Size', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => '40' ],
                'range'                 => [
                    'px' => [
                        'min'   => 15,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}} .ets-co-timeline-navigation .ets-co-slider-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; transform: translateY(calc({{SIZE}}{{UNIT}}/2))',
				],
                'condition'             => [
                    'layout'        => 'horizontal',
                    'arrows'        => 'yes',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'align_arrows',
            [
                'label'                 => __( 'Align Arrows', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => -40,
                        'max'   => 0,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}} .ets-co-timeline-navigation .ets-co-arrow-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ets-co-timeline-navigation .ets-co-arrow-next' => 'right: {{SIZE}}{{UNIT}};',
				],
                'condition'             => [
                    'layout'        => 'horizontal',
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_arrows_style' );

        $this->start_controls_tab(
            'tab_arrows_normal',
            [
                'label'                 => __( 'Normal', ETSDDL_LANG ),
                'condition'             => [
                    'layout'        => 'horizontal',
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_bg_color_normal',
            [
                'label'                 => __( 'Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-navigation .ets-co-slider-arrow' => 'background-color: {{VALUE}};',
                ],
                'condition'             => [
                    'layout'        => 'horizontal',
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_normal',
            [
                'label'                 => __( 'Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-navigation .ets-co-slider-arrow' => 'color: {{VALUE}};',
                ],
                'condition'             => [
                    'layout'        => 'horizontal',
                    'arrows'        => 'yes',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'arrows_border_normal',
				'label'                 => __( 'Border', ETSDDL_LANG ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .ets-co-timeline-navigation .ets-co-slider-arrow',
                'condition'             => [
                    'layout'        => 'horizontal',
                    'arrows'        => 'yes',
                ],
			]
		);

		$this->add_control(
			'arrows_border_radius_normal',
			[
				'label'                 => __( 'Border Radius', ETSDDL_LANG ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .ets-co-timeline-navigation .ets-co-slider-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'layout'        => 'horizontal',
                    'arrows'        => 'yes',
                ],
			]
		);
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_arrows_hover',
            [
                'label'                 => __( 'Hover', ETSDDL_LANG ),
                'condition'             => [
                    'layout'        => 'horizontal',
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_bg_color_hover',
            [
                'label'                 => __( 'Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-navigation .ets-co-slider-arrow:hover' => 'background-color: {{VALUE}};',
                ],
                'condition'             => [
                    'layout'        => 'horizontal',
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_hover',
            [
                'label'                 => __( 'Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-navigation .ets-co-slider-arrow:hover' => 'color: {{VALUE}};',
                ],
                'condition'             => [
                    'layout'        => 'horizontal',
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_border_color_hover',
            [
                'label'                 => __( 'Border Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-navigation .ets-co-slider-arrow:hover' => 'border-color: {{VALUE}};',
                ],
                'condition'             => [
                    'layout'        => 'horizontal',
                    'arrows'        => 'yes',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();

        /**
         * Style Tab: Button
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_info_box_button_style',
            [
                'label'                 => __( 'Button', ETSDDL_LANG ),
                'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
            ]
        );

        $this->add_control(
            'button_spacing',
            [
                'label'                 => __( 'Spacing', ETSDDL_LANG ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size' 	    => 20,
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> 0,
                        'max' 	=> 60,
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-button' => 'margin-top: {{SIZE}}px;',
                ],
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
            ]
        );

		$this->add_control(
			'button_size',
			[
				'label'                 => __( 'Size', ETSDDL_LANG ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'md',
				'options'               => [
					'xs' => __( 'Extra Small', ETSDDL_LANG ),
					'sm' => __( 'Small', ETSDDL_LANG ),
					'md' => __( 'Medium', ETSDDL_LANG ),
					'lg' => __( 'Large', ETSDDL_LANG ),
					'xl' => __( 'Extra Large', ETSDDL_LANG ),
				],
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
			]
		);

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label'                 => __( 'Normal', ETSDDL_LANG ),
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
            ]
        );

        $this->add_control(
            'button_bg_color_normal',
            [
                'label'                 => __( 'Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-button' => 'background-color: {{VALUE}}',
                ],
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
            ]
        );

        $this->add_control(
            'button_text_color_normal',
            [
                'label'                 => __( 'Text Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-button' => 'color: {{VALUE}}',
                ],
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'button_border_normal',
				'label'                 => __( 'Border', ETSDDL_LANG ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .ets-co-timeline-button',
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'                 => __( 'Border Radius', ETSDDL_LANG ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .ets-co-timeline-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
			]
		);
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'button_typography',
                'label'                 => __( 'Typography', ETSDDL_LANG ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '{{WRAPPER}} .ets-co-timeline-button',
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
            ]
        );

		$this->add_responsive_control(
			'button_padding',
			[
				'label'                 => __( 'Padding', ETSDDL_LANG ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .ets-co-timeline-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow',
				'selector'              => '{{WRAPPER}} .ets-co-timeline-button',
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
			]
		);
        
        $this->add_control(
            'info_box_button_icon_heading',
            [
                'label'                 => __( 'Button Icon', ETSDDL_LANG ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
                'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
                    'button_icon!' => '',
                ],
            ]
        );

		$this->add_responsive_control(
			'button_icon_margin',
			[
				'label'                 => __( 'Margin', ETSDDL_LANG ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'placeholder'       => [
					'top'      => '',
					'right'    => '',
					'bottom'   => '',
					'left'     => '',
				],
                'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
                    'button_icon!' => '',
                ],
				'selectors'             => [
					'{{WRAPPER}} .pp-info-box .pp-button-icon' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label'                 => __( 'Hover', ETSDDL_LANG ),
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
                'label'                 => __( 'Background Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-button:hover' => 'background-color: {{VALUE}}',
                ],
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label'                 => __( 'Text Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-button:hover' => 'color: {{VALUE}}',
                ],
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
            ]
        );

        $this->add_control(
            'button_border_color_hover',
            [
                'label'                 => __( 'Border Color', ETSDDL_LANG ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .ets-co-timeline-button:hover' => 'border-color: {{VALUE}}',
                ],
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
            ]
        );

		$this->add_control(
			'button_animation',
			[
				'label'                 => __( 'Animation', ETSDDL_LANG ),
				'type'                  => Controls_Manager::HOVER_ANIMATION,
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow_hover',
				'selector'              => '{{WRAPPER}} .ets-co-timeline-button:hover',
				'condition'             => [
                    'source'       => 'posts',
					'link_type'    => 'button',
				],
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->end_controls_section();

    }

    /**
     * Render timeline widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    public function render() {
        $settings = $this->get_settings();

        $timeline_classes = array();

        $timeline_classes[] = 'ets-co-timeline';

        // Layout
        if ( $settings['layout'] ) {
            $timeline_classes[] = 'ets-co-timeline-' . $settings['layout'];
        }

        // Direction
        if ( $settings['direction'] ) {
            $timeline_classes[] = 'ets-co-timeline-' . $settings['direction'];
        }

        if ( $settings['direction_tablet'] ) {
            $timeline_classes[] = 'ets-co-timeline-tablet-' . $settings['direction_tablet'];
        }

        if ( $settings['direction_mobile'] ) {
            $timeline_classes[] = 'ets-co-timeline-mobile-' . $settings['direction_mobile'];
        }

        if( $settings['direction_date'] ){
            $timeline_classes[] = 'ets-co-timeline-date-' . $settings['direction_date'];
        }

        if( $settings['direction_date_tablet'] ){
            $timeline_classes[] = 'ets-co-timeline-date-tablet-' . $settings['direction_date_tablet'];
        }

        if( $settings['direction_date_mobile'] ){
            $timeline_classes[] = 'ets-co-timeline-date-mobile-' . $settings['direction_date_mobile'];
        }

        if ( $settings['dates'] == 'yes' ) {
            $timeline_classes[] = 'ets-co-timeline-dates';
        }

        if ( $settings['cards_arrows_alignment'] ) {
            $timeline_classes[] = 'ets-co-timeline-arrows-' . $settings['cards_arrows_alignment'];
        }

        $this->add_render_attribute( 'timeline', 'class', $timeline_classes );

        $this->add_render_attribute( 'timeline', 'data-timeline-layout', $settings['layout'] );

        $this->add_render_attribute( 'post-categories', 'class', 'pp-post-categories' );
        ?>
        <div class="ets-co-timeline-wrapper">
            <?php $this->render_horizontal_timeline_nav(); ?>

            <div <?php echo $this->get_render_attribute_string( 'timeline' ); ?>>
                <?php if ( $settings['layout'] == 'vertical' ) { ?>
                    <div class="ets-co-timeline-connector-wrap">
                        <div class="ets-co-timeline-connector">
                            <div class="ets-co-timeline-connector-inner">
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="ets-co-timeline-items">
                    <?php
                    if ( $settings['source'] == 'posts' ) {
                        $this->render_source_posts();
                    } elseif ( $settings['source'] == 'custom' ) {
                        $this->render_source_custom();
                    }
                    ?>
                </div>
            </div><!--.ets-co-timeline-->
        </div><!--.ets-co-timeline-wrapper-->
        <?php
    }

    /**
     * Render vertical timeline output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    public function render_vertical_timeline() {
        $settings = $this->get_settings();
    }

    /**
     * Render vertical timeline output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    public function render_horizontal_timeline_nav() {
        $settings = $this->get_settings();
        if ( $settings['layout'] == 'horizontal' ) {
            ?>
            <div class="ets-co-timeline-navigation">
                <?php
                $i = 1;
                if ( $settings['source'] == 'custom' ) {
                    foreach ( $settings['items'] as $index => $item ) {

                        $date = $item['timeline_item_date'];

                        $this->render_connector_icon( $item, $i, $date, $settings );

                        $i++;
                    }
                } if ( $settings['source'] == 'posts' ) {
                    $args = $this->get_posts_query_arguments();
                    $posts_query = new \WP_Query( $args );

                    if ( $posts_query->have_posts() ) : while ($posts_query->have_posts()) : $posts_query->the_post();

                        $date = get_the_date();

                        $this->render_connector_icon( [], $i, $date, $settings );

                        $i++; endwhile; endif; wp_reset_query();
                }
                ?>
            </div>
            <?php
        }
    }

    /**
     * Render custom content output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    public function render_connector_icon( $item, $number = '', $date = '', $settings = [] ) {
        if( empty($settings) ){
            $settings = $this->get_settings();
        }

        ?>
        <div class="ets-co-timeline-icon-wrapper">
            <?php if ( $settings['layout'] == 'horizontal' && $settings['dates'] == 'yes' ) { ?>
                <div class="ets-co-timeline-card-date-wrapper">
                    <div class="ets-co-timeline-card-date">
                        <?php echo $date; ?>
                    </div>
                </div>
            <?php } ?>

            <div class="ets-co-timeline-icon">
                <?php
                if( isset($item['item_icon_co_icon']) && !empty($item['item_icon_co_icon']) ){
                    $icon_icon_new = $item['item_icon_icon_new'];
                    $icon_image = $item['item_icon_image'];
                    $icon_text = $item['item_icon_text'];
                    switch($item['item_icon_icon_type']) {

                        case 'image' :
                            $icon_html = '<i><img src="' . $icon_image['url'] . '"/></i>';
                            break;

                        case 'text' :
                            $icon_html = '<i class="">' . $icon_text . '</i>';
                            break;
                        default:
                            $icon_html = "";
                            break;

                    }
                    if( 'icon' == $item['item_icon_icon_type'] ){
                        Icons_Manager::render_icon($icon_icon_new, ['aria-hidden' => 'true']);
                    }else {
                        echo $icon_html;
                    }
                } else{
                    /**
                     * Haven't Icon and use icon global
                     */

                    if( 'icon' == $settings['icon_type'] ){
                        $icon_icon_icon_new = $settings['icon_icon_icon_new'];
                        $icon_icon_image = $settings['icon_icon_image'];
                        $icon_icon_text = $settings['icon_icon_text'];
                        switch($settings['icon_icon_icon_type']) {

                            case 'image' :
                                $icon_html = '<i><img src="' . $icon_icon_image['url'] . '"/></i>';
                                break;

                            case 'text' :
                                $icon_html = '<i class="">' . $icon_icon_text . '</i>';
                                break;

                            default:
                                $icon_html = "";
                                break;

                        }
                        if( 'icon' == $settings['icon_icon_icon_type'] ){
                            Icons_Manager::render_icon($icon_icon_icon_new, ['aria-hidden' => 'true']);
                        }else {
                            echo $icon_html;
                        }
                    } elseif ( $settings['icon_type'] == 'number' ) {
                        echo $number;
                    } elseif ( $settings['icon_type'] == 'letter' ) {
                        $alphabets = range('A', 'Z');

                        $alphabets = array_combine( range(1, count( $alphabets ) ), $alphabets );

                        echo $alphabets[ $number ];
                    }
                }
                ?>
            </div>
        </div>
        <?php if ( $settings['layout'] == 'vertical' ) { ?>
            <div class="ets-co-timeline-card-date-wrapper">
                <?php if ( $settings['dates'] == 'yes' ) { ?>
                    <div class="ets-co-timeline-card-date">
                        <?php echo $date; ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <?php
    }

    /**
     * Render custom content output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    public function render_source_custom() {
        $settings = $this->get_settings();

        $i = 1;

        foreach ( $settings['items'] as $index => $item ) {

            $item_key       = $this->get_repeater_setting_key( 'item', 'items', $index );
            $title_key      = $this->get_repeater_setting_key( 'timeline_item_title', 'items', $index );
            $content_key    = $this->get_repeater_setting_key( 'timeline_item_content', 'items', $index );

            $this->add_inline_editing_attributes( $title_key, 'basic' );
            $this->add_inline_editing_attributes( $content_key, 'advanced' );

            $this->add_render_attribute( $item_key, 'class', [
                'ets-co-timeline-item',
                'elementor-repeater-item-' . esc_attr( $item['_id'] )
            ] );

            if ( $settings['animate_cards'] === 'yes' ) {
                $this->add_render_attribute( $item_key, 'class', 'ets-co-timeline-item-hidden' );
            }

            $this->add_render_attribute( $title_key, 'class', 'ets-co-timeline-card-title' );

            $this->add_render_attribute( $content_key, 'class', 'ets-co-timeline-card-content' );

            if ( ! empty( $item['timeline_item_link']['url'] ) ) {
                $this->add_render_attribute( 'link', 'href', esc_url( $item['timeline_item_link']['url'] ) );

                if ( $item['timeline_item_link']['is_external'] ) {
                    $this->add_render_attribute( 'link', 'target', '_blank' );
                }

                if ( $item['timeline_item_link']['nofollow'] ) {
                    $this->add_render_attribute( 'link', 'rel', 'nofollow' );
                }
            }
            ?>
            <div <?php echo $this->get_render_attribute_string( $item_key ); ?>>
                <div class="ets-co-timeline-card-wrapper">
                    <?php if ( $item['timeline_item_link']['url'] != '' ) { ?>
                    <a <?php echo $this->get_render_attribute_string( 'link' ); ?>>
                        <?php } ?>
                        <div class="ets-co-timeline-arrow"></div>
                        <div class="ets-co-timeline-card">
                            <?php if ( $item['card_image'] == 'yes' && ! empty( $item['image']['url'] ) ) { ?>
                                <div class="ets-co-timeline-card-image">
                                    <?php echo Group_Control_Image_Size::get_attachment_image_html( $item ); ?>
                                </div>
                            <?php } ?>
                            <?php if ( $settings['post_title'] == 'show' || $settings['dates'] == 'yes' ) { ?>
                                <div class="ets-co-timeline-card-title-wrap">
                                    <?php if ( $settings['layout'] == 'vertical' ) { ?>
                                        <?php if ( $settings['dates'] == 'yes' ) { ?>
                                            <div class="ets-co-timeline-card-date">
                                                <?php echo $item['timeline_item_date']; ?>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ( $item['timeline_item_title'] != '' ) { ?>
                                        <h2 <?php echo $this->get_render_attribute_string( $title_key ); ?>>
                                            <?php
                                            echo $item['timeline_item_title'];
                                            ?>
                                        </h2>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <?php if ( $item['timeline_item_content'] != '' ) { ?>
                                <div <?php echo $this->get_render_attribute_string( $content_key ); ?>>
                                    <?php
                                    echo $this->parse_text_editor( $item['timeline_item_content'] );
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if ( $item['timeline_item_link'] != '' ) { ?>
                    </a>
                <?php } ?>
                </div>

                <?php if ( $settings['layout'] == 'vertical' ) { ?>
                    <?php $this->render_connector_icon( $item, $i, $item['timeline_item_date'], $settings ); ?>
                <?php } ?>
            </div>
            <?php
            $i++;
        }
    }

    /**
     * Render posts output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    public function render_source_posts() {
        $settings = $this->get_settings();

        $i = 1;

        // Query Arguments
        $args = $this->get_posts_query_arguments();
        $posts_query = new \WP_Query( $args );

        if ( $posts_query->have_posts() ) : while ($posts_query->have_posts()) : $posts_query->the_post();

            $item_key = 'timeline-item' . $i;

            if ( has_post_thumbnail() ) {
                $image_id = get_post_thumbnail_id( get_the_ID() );
                $pp_thumb_url = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'image_size', $settings );
            } else {
                $pp_thumb_url = '';
            }

            $this->add_render_attribute( $item_key, 'class', [
                'ets-co-timeline-item',
                'ets-co-timeline-item-' . intval( $i )
            ] );

            if ( $settings['animate_cards'] === 'yes' ) {
                $this->add_render_attribute( $item_key, 'class', 'ets-co-timeline-item-hidden' );
            }
            ?>
            <div <?php echo $this->get_render_attribute_string( $item_key ); ?>>
                <div class="ets-co-timeline-card-wrapper">
                    <?php if ( $settings['link_type'] == 'card' ) { ?>
                    <a href="<?php the_permalink() ?>">
                        <?php } ?>
                        <div class="ets-co-timeline-arrow"></div>
                        <div class="ets-co-timeline-card">
                            <?php if ( $settings['post_image'] == 'show' ) { ?>
                                <div class="ets-co-timeline-card-image">
                                    <img src="<?php echo esc_url( $pp_thumb_url ); ?>">
                                </div>
                            <?php } ?>
                            <?php if ( $settings['post_title'] == 'show' || $settings['dates'] == 'yes' ) { ?>
                                <div class="ets-co-timeline-card-title-wrap">
                                    <?php if ( $settings['layout'] == 'vertical' ) { ?>
                                        <?php if ( $settings['dates'] == 'yes' ) { ?>
                                            <div class="ets-co-timeline-card-date">
                                                <?php echo get_the_date(); ?>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ( $settings['post_title'] == 'show' ) { ?>
                                        <h2 class="ets-co-timeline-card-title">
                                            <?php
                                            if ( $settings['link_type'] == 'title' ) {
                                                printf( '<a href="%1$s">%2$s</a>', get_permalink(), get_the_title() );
                                            } else {
                                                the_title();
                                            }
                                            ?>
                                        </h2>
                                    <?php } ?>
                                    <?php if ( $settings['post_meta'] == 'show' ) { ?>
                                        <div class="ets-co-timeline-meta">
                                            <?php if ( $settings['post_author'] == 'show' ) { ?>
                                                <span class="ets-co-timeline-author">
                                                <?php the_author(); ?>
                                            </span>
                                            <?php } ?>
                                            <?php if ( $settings['post_category'] == 'show' ) { ?>
                                                <span class="ets-co-timeline-category">
                                                <?php
                                                $category = get_the_category();
                                                if ( $category ) {
                                                    echo esc_attr( $category[0]->name );
                                                }
                                                ?>
                                            </span>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <div class="ets-co-timeline-card-content">
                                <?php if ( $settings['post_content'] == 'show' ) { ?>
                                    <div class="ets-co-timeline-card-excerpt">
                                        <?php
                                        $this->render_post_content();
                                        ?>
                                    </div>
                                <?php } ?>
                                <?php if ( $settings['link_type'] == 'button' && $settings['button_text'] ) { ?>
                                    <?php
                                    $this->add_render_attribute( 'button', 'class', [
                                            'ets-co-timeline-button',
                                            'elementor-button',
                                            'elementor-size-' . $settings['button_size'],
                                        ]
                                    );
                                    ?>
                                    <a <?php echo $this->get_render_attribute_string( 'button' ); ?> href="<?php the_permalink() ?>">
                                    <span class="ets-co-timeline-button-text">
                                        <?php echo esc_attr( $settings['button_text'] ); ?>
                                    </span>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if ( $settings['link_type'] == 'card' ) { ?>
                    </a>
                <?php } ?>
                </div>

                <?php
                if ( $settings['layout'] == 'vertical' ) {
                    $this->render_connector_icon([],  $i, get_the_date(), $settings);
                }
                ?>
            </div>
            <?php
            $i++; endwhile; endif; wp_reset_query();
    }

    /**
     * Get post query arguments.
     *
     * @access protected
     */
    public function get_posts_query_arguments() {
        $settings = $this->get_settings();
        $pp_posts_count = absint( $settings['posts_per_page'] );

        // Post Authors
        $pp_tiled_post_author = '';
        $pp_tiled_post_authors = $settings['authors'];
        if ( !empty( $pp_tiled_post_authors) ) {
            $pp_tiled_post_author = implode( ",", $pp_tiled_post_authors );
        }

        // Post Categories
        $pp_tiled_post_cat = '';
        $pp_tiled_post_cats = $settings['categories'];
        if ( !empty( $pp_tiled_post_cats) ) {
            $pp_tiled_post_cat = implode( ",", $pp_tiled_post_cats );
        }

        // Query Arguments
        $args = array(
            'post_status'           => array( 'publish' ),
            'post_type'             => $settings['post_type'],
            'post__in'              => '',
            'cat'                   => $pp_tiled_post_cat,
            'author'                => $pp_tiled_post_author,
            'tag__in'               => $settings['tags'],
            'orderby'               => $settings['orderby'],
            'order'                 => $settings['order'],
            'post__not_in'          => $settings['exclude_posts'],
            'offset'                => $settings['offset'],
            'ignore_sticky_posts'   => 1,
            'showposts'             => $pp_posts_count
        );

        return $args;
    }

    /**
     * Get post content.
     *
     * @access protected
     */
    public function render_post_content() {
        $settings = $this->get_settings();

        $content_length = $settings['content_length'];

        if ( $content_length == '' ) {
            $content = get_the_excerpt();
        } else {
            $content = wp_trim_words( get_the_content(), $content_length );
        }

        echo $content;
    }


    protected function _content_template() {}
}