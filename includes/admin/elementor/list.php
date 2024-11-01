<?php

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TBD_List_Widget extends Widget_Base {

	public static $slug = 'tbd-events-list';

	public function get_name() { return self::$slug; }

	public function get_title() { return __('TBD Events List', self::$slug); }

	public function get_icon() { return 'fas fa-list'; }

	public function get_categories() { return [ 'tbd-events' ]; }
	
	public function get_style_depends() {
		return [ 'tbd-events-list-css'];
	}
	
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'List Settings', self::$slug ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'num_events',
			[
				'label' => __( 'Number of Events to Show', self::$slug ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 6,
			]
		);
		
		$this->add_control(
			'categories',
			[
				'label' => __( 'Categories', self::$slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'events', self::$slug ),
				'placeholder' => __( 'events,seminars,concerts', self::$slug ),
				'description' => __('Comma-separated category slugs', self::$slug)
			]
		);
		
		$this->add_control(
			'show_headings',
			[
				'label' => __( 'Show Headings', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'your-plugin' ),
				'label_off' => __( 'Hide', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'List Styles', self::$slug ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Event Title Typography', self::$slug ),
				'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tbd-event-list-title',
			]
		);
		
		$this->add_control(
			'title_text_color',
			[
				'label' => __( 'Title Text Colour', self::$slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tbd-event-list-title' => 'color: {{VALUE}}'
				],
			]
		);
				
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'date_typography',
				'label' => __( 'Date Typography', self::$slug ),
				'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tbd-event-list-date',
			]
		);
		$this->add_control(
			'date_text_color',
			[
				'label' => __( 'Date Text Colour', self::$slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tbd-event-list-date' => 'color: {{VALUE}}'
				],
			]
		);
		
		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', self::$slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Book Now', self::$slug ),
				'placeholder' => __( 'Book Now', self::$slug ),
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __( 'Button Typography', self::$slug ),
				'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tbd-event-list-cta',
			]
		);
		
		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Button Text Colour', self::$slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tbd-event-list-cta' => 'color: {{VALUE}}'
				],
			]
		);
		$this->add_control(
			'button_bg_color',
			[
				'label' => __( 'Button Colour', self::$slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tbd-event-list-cta' => 'background: {{VALUE}}'
				],
			]
		);

		
		$this->end_controls_section();
	}
	
	
	protected function render() {
		$options = $this->get_settings_for_display();
		$atts = array(
			'cat' => $options['categories'],
			'limit' => $options['num_events'],
			'button' => $options['button_text']
		);
		echo wp_kses_post(tbd_list_event_products($atts));
	}

  
} 