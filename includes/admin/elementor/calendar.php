<?php

use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TBD_Calendar_Widget extends Widget_Base {
	
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_script('tbd_events_cal_main_js', plugin_dir_url( __FILE__ ) . '../../assets/calendar/main.min.js', array( 'jquery' ), null, true);
		wp_register_script('tbd_events_cal_js', plugin_dir_url( __FILE__ ) . '../../assets/calendar/calendar.js', array( 'jquery' ), null, true);
		
   }
	
	public static $slug = 'elementor-calendar';

	public function get_name() { return self::$slug; }

	public function get_title() { return __('TBD Events Calendar', self::$slug); }

	public function get_icon() { return 'fas fa-calendar-alt'; }

	public function get_categories() { return [ 'tbd-events' ]; }
	
	public function get_script_depends() {
		return [ 'tbd_events_cal_main_js', 'tbd_events_cal_js'];
	}
	
	public function get_style_depends() {
		return [ 'tbd_cal_main_css'];
	}
	
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Calendar Settings', self::$slug ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		

		$this->add_control(
			'days_ago',
			[
				'label' => __( 'How far back to show events (in days)', self::$slug ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 14,
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
			'day_max',
			[
				'label' => __( 'Events shown per day', self::$slug ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => -1,
				'max' => 100,
				'step' => 1,
				'default' => 5,
				'description' => __('Enter -1 to show all events. Events over the entered number will show in a popup.', self::$slug )
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Calendar Styles', self::$slug ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'button_color',
			[
				'label' => __( 'Button Colour', self::$slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fc-button-primary' => 'background-color: {{VALUE}}'
				],
			]
		);
		
		$this->add_control(
			'event_display',
			[
				'label' => __( 'Event Display Type', self::$slug ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'list-item' => [
						'title' => __( 'Dot', self::$slug ),
						'icon' => 'fas fa-dot-circle',
					],
					'block' => [
						'title' => __( 'Block', self::$slug ),
						'icon' => 'fas fa-equals',
					],
				],
				'default' => 'block',
				'toggle' => true,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'event_typo',
				'label' => __( 'Event Title Typography', self::$slug ),
				'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .fc-event-title',
			]
		);
		$this->add_control(
			'event_bg_color',
			[
				'label' => __( 'Event Background Colour', self::$slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Elementor\Core\Schemes\Color::get_type(),
					'value' => Elementor\Core\Schemes\Color::COLOR_1,
				],
			]
		);
		$this->add_control(
			'event_text_color',
			[
				'label' => __( 'Event Text Colour', self::$slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Elementor\Core\Schemes\Color::get_type(),
					'value' => Elementor\Core\Schemes\Color::COLOR_3,
				],
			]
		);
		$this->add_control(
			'event_border_color',
			[
				'label' => __( 'Event Border Colour', self::$slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Elementor\Core\Schemes\Color::get_type(),
					'value' => Elementor\Core\Schemes\Color::COLOR_1,
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'day_num_typo',
				'label' => __( 'Date Number Typography', self::$slug ),
				'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .fc .fc-daygrid-day-number',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'week_day_typo',
				'label' => __( 'Day of Week Typography', self::$slug ),
				'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .fc .fc-col-header-cell-cushion',
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function render() {
	
		$options = $this->get_settings_for_display();
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
	  
		for ($i = 0; $i < 8; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}
	  
		$atts = array(
			'cat' => $options['categories'],
			'days_ago' => $options['days_ago']
		);
		
		$cat_array = explode(',',$atts['cat']);
        
		// The query
		$time = strtotime(date('Y-m-d') . '-' . $atts['days_ago'] . ' days');
		$after = date('Y-m-d', $time);
        $args = array(
			'type' => 'event',
			'category' => $cat_array,
			'order' => 'ASC',
			'orderby' => 'meta_value',
			'meta_key' => 'tbd_date',
			'tbd_date' => $after
		);
		$products = wc_get_products( $args );
		$entries_array = array();
		if (sizeof($products) > 0) {
			foreach ($products as $product) {
				$class = 'other';
				$terms = get_the_terms( $product->get_id(), 'product_cat' );
				$class =  end($terms)->slug;
				
				$dates = get_post_meta($product->get_id(), 'tbd_date', true);
				foreach ($dates as $date_string) {
					if (new DateTime($after) <= new DateTime($date_string)) {
						$entries_array[] = array(
							'title' => $product->get_title(),
							'start' => $date_string,
							'allDay' => true,
							'link' => $product->get_permalink()
							);
					}
				}
			}
			$cal_events = json_encode($entries_array);
			$days_max = $options['day_max'] >= 0 ? $options['day_max'] : "false";
			$html = '<div class="tbd-calendar ' . $randomString . '"></div>';
			$script = 'jQuery(document).ready(function(){
				var calendarEl = document.getElementsByClassName("'. $randomString . '");
				var events_array = '.$cal_events.';
				for (let div of calendarEl) {
					var calendar = new FullCalendar.Calendar(div, {
						initialView: "dayGridMonth",
						expandRows: "true",
						dayMaxEvents: ' . $days_max . ',
						aspectRatio:1.36,
						eventDisplay: "' . $options['event_display'] . '",
						eventBackgroundColor: "' . $options['event_bg_color'] . '",
						eventBorderColor: "' . $options['event_border_color'] . '",
						eventTextColor: "' . $options['event_text_color'] . '"						
					});
					calendar.render();
			
					events_array.forEach(addEvents);
					function addEvents(event) {
						calendar.addEvent({
							title: event.title,
							start: event.start,
							allDay: true,
							url: event.link
						});
					}
				}
					
			});';
			echo wp_kses_post($html);
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { 	//If in edit mode, echo the script for immediate display.
				$tags = array(
					'script' => array(),
				);
				echo wp_kses('<script>'.$script.'</script>', $tags);
			} else { 														//if frontend, enqueue the script
				wp_add_inline_script( 'tbd_events_cal_main_js', $script );
			}
			
		} else {
			echo '<p class="tbd-no-events">No upcoming events.</p>';
		}
		
	}
  
} 