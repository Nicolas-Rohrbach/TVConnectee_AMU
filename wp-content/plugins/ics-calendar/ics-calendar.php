<?php
/*
Plugin Name: ICS Calendar
Plugin URI:
Description: Embed a live updating iCal (ICS) feed in any page using a shortcode.
Version: 2.2.1.1
Author: Room 34 Creative Services, LLC
Author URI: http://room34.com
License: GPL2
Text Domain: r34ics
Domain Path: /i18n/languages/
*/


// Don't load directly
if (!defined('ABSPATH')) { exit; }


// Block editor
//include_once(plugin_dir_path(__FILE__) . '/blocks/r34ics-block.php');


class R34ICS {

	var $version = '2.2.1.1';

	var $ical_path = '/vendors/ics-parser/src/ICal/ICal.php';
	var $event_path = '/vendors/ics-parser/src/ICal/Event.php';
	var $carbon_path = '/vendors/ics-parser/vendor/nesbot/carbon/src/Carbon/Carbon.php';
	var $parser_loaded = false;
	var $limit_days = 365;


	public function __construct() {

		// Set property values
		$this->ical_path = plugin_dir_path(__FILE__) . $this->ical_path;
		$this->event_path = plugin_dir_path(__FILE__) . $this->event_path;
		$this->carbon_path = plugin_dir_path(__FILE__) . $this->carbon_path;

		// Initialize admin
		add_action('admin_menu', array(&$this, 'admin_menu'));

		// Enqueue scripts
		add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));

		// Add ICS shortcode
		add_shortcode('ics_calendar', array(&$this, 'shortcode'));

		// Add editor button
		add_action('admin_init', array(&$this, 'editor_button'));

		// Add admin notices
		add_action('admin_notices', array(&$this, 'admin_notices'));

	}


	public function admin_menu() {
		add_options_page(
			'ICS Calendar',
			'ICS Calendar',
			'manage_options',
			'ics-calendar',
			array(&$this, 'admin_page')
		);
	}


	public function admin_notices() {

		// Require allow_url_fopen
		if (!r34ics_url_open_allowed()) {
			?>
			<div class="notice notice-error">
				<p>The <strong>ICS Calendar</strong> plugin requires either the PHP cURL extensions, or the <code>allow_url_fopen</code> PHP setting to be turned on. Please update the settings in your <code>php.ini</code> file or contact your hosting provider for assistance.</p>
			</div>
			<?php
		}

	}


	public function admin_page() {

		// Render template
		include(plugin_dir_path(__FILE__) . '/templates/admin.php');

	}
	
	
	public function days_of_week($format=null) {
		$days_of_week = array();
		switch ($format) {
			case 'min':
				$days_of_week = array(
					0 => __('Su', 'r34ics'),
					1 => __('M', 'r34ics'),
					2 => __('Tu', 'r34ics'),
					3 => __('W', 'r34ics'),
					4 => __('Th', 'r34ics'),
					5 => __('F', 'r34ics'),
					6 => __('Sa', 'r34ics'),
				);
				break;
			case 'short':
				$days_of_week = array(
					0 => __('Sun', 'r34ics'),
					1 => __('Mon', 'r34ics'),
					2 => __('Tue', 'r34ics'),
					3 => __('Wed', 'r34ics'),
					4 => __('Thu', 'r34ics'),
					5 => __('Fri', 'r34ics'),
					6 => __('Sat', 'r34ics'),
				);
				break;
			default:
				$days_of_week = array(
					0 => __('Sunday', 'r34ics'),
					1 => __('Monday', 'r34ics'),
					2 => __('Tuesday', 'r34ics'),
					3 => __('Wednesday', 'r34ics'),
					4 => __('Thursday', 'r34ics'),
					5 => __('Friday', 'r34ics'),
					6 => __('Saturday', 'r34ics'),
				);
				break;
		}
		return $days_of_week;
	}


	public function display_calendar($ics_url, $args=array(), $force_reload=false) {

		// Fix URL protocol
		if (strpos($ics_url,'webcal://') === 0) {
			$ics_url = str_replace('webcal://','https://',$ics_url);
		}

		// Get ICS data, from transient if possible
		$transient_name = __METHOD__ . '_' . sha1($ics_url . serialize($args));
		$ics_data = null;
		if (empty($force_reload)) {
			$ics_data = get_transient($transient_name);
		}

		// No transient ICS data; retrieve ICS file from server
		if (empty($ics_data)) {
			$ics_contents = r34ics_url_get_contents($ics_url);
		
			// No ICS data present -- throw error and exit
			if (empty($ics_contents)) {
				trigger_error('ICS file could not be retrieved or was empty. ICS Calendar plugin requires cURL or allow_url_fopen. Please check your php.ini configuration.', E_USER_WARNING);
				return false;
			}

			// Parse ICS contents
			$ics_data = array();
			if (!$this->parser_loaded) {
				$this->parser_loaded = $this->_load_parser();
			}
			$ICal = new ICal\ICal;
			$ICal->initString($ics_contents);

			$ics_data['title'] = !empty($args['title']) ? $args['title'] : $ICal->calendarName();
			$ics_data['description'] = !empty($args['description']) ? $args['description'] : $ICal->calendarDescription();

			// Process events
			if ($ics_events = $ICal->events()) {

				// Assemble events
				foreach ((array)$ics_events as $event) {

					// Get the start date and time
					// All-day events
					if (strlen($event->dtstart) == 8 || (strpos($event->dtstart, 'T000000Z') !== false && strpos($event->dtend, 'T000000Z') !== false)) {
						$dtstart_date = substr($event->dtstart,0,8);
						$dtend_date = substr($event->dtend,0,8);
						$all_day = true;
					}
					else {
						// Workaround for time zone data breaking the _tz values returned by ICS Parser
						// @todo This workaround may need to be removed if a future update of ICS Parser fixes this bug
						// If event's time zone appears in $event->dtstart_array[0]; the start and end times are correct, and $event->dtstart_tz overcompensates
						if (!empty($event->dtstart_array[0])) {
							$dtstart_date = substr($event->dtstart,0,8);
							$dtstart_time = substr($event->dtstart,9,6);
							$dtend_date = substr($event->dtend,0,8);
							$dtend_time = substr($event->dtend,9,6);
						}
						// No time zone in $event->dtstart_array[0]; ICS Parser treats as GMT and $event->dtstart_tz is the correct value
						else {
							// $event->dtstart_tz matches $event->dtstart_array[1]; assume time zone is completely absent and adjust for local time
							if ($event->dtstart_array[1] == $event->dtstart_tz . 'Z') {
								$dtstart_gmt = mktime(
									substr($event->dtstart_tz,9,2) + get_option('gmt_offset'),
									substr($event->dtstart_tz,11,2),
									substr($event->dtstart_tz,13,2),
									substr($event->dtstart_tz,4,2),
									substr($event->dtstart_tz,6,2),
									substr($event->dtstart_tz,0,4)
								);
								$dtstart_date = date_i18n('Ymd',$dtstart_gmt);
								$dtstart_time = date_i18n('His',$dtstart_gmt);
								$dtend_gmt = mktime(
									substr($event->dtend_tz,9,2) + get_option('gmt_offset'),
									substr($event->dtend_tz,11,2),
									substr($event->dtend_tz,13,2),
									substr($event->dtend_tz,4,2),
									substr($event->dtend_tz,6,2),
									substr($event->dtend_tz,0,4)
								);
								$dtend_date = date_i18n('Ymd',$dtend_gmt);
								$dtend_time = date_i18n('His',$dtend_gmt);
							}
							// ICS Parser adjusts, and $event->dtstart_tz is the correct local value
							else {
								$dtstart_date = substr($event->dtstart_tz,0,8);
								$dtstart_time = substr($event->dtstart_tz,9,6);
								$dtend_date = substr($event->dtend_tz,0,8);
								$dtend_time = substr($event->dtend_tz,9,6);
							}
						}
						$all_day = false;
					}

					// Workaround for events in feeds that do not contain an end date/time
					if (empty($dtend_date)) { $dtend_date = @$dtstart_date; }
					if (empty($dtend_time)) { $dtend_time = @$dtstart_time; }

					// Add event data to output array if this month or later
					if ($dtstart_date >= date_i18n('Ym') . '01') {
						// Events with different start and end dates
						if ($dtend_date != $dtstart_date) {
							$loop_date = $dtstart_date;
							while ($loop_date <= $dtend_date) {
								// Classified as an all-day event and we've hit the end date -- don't display
								if ($all_day && $loop_date == $dtend_date) {
									break;
								}
								// Classified as an all-day event, or we're in the middle of the range -- treat as regular all-day event
								if ($all_day || ($loop_date != $dtstart_date && $loop_date != $dtend_date)) {
									$ics_data['events'][$loop_date]['all-day'][] = array(
										'label' => @$event->summary,
										'eventdesc' => @$event->description,
										'location' => @$event->location,
									);
								}
								// First date in range -- treat as all-day but also show start time
								elseif ($loop_date == $dtstart_date) {
									$ics_data['events'][$loop_date]['t'.$dtstart_time][] = array(
										'label' => @$event->summary,
										'eventdesc' => @$event->description,
										'location' => @$event->location,
										'start' => date_i18n(get_option('time_format'), mktime(
											substr($dtstart_time,0,2),
											substr($dtstart_time,2,2),
											substr($dtstart_time,4,2),
											substr($dtstart_date,4,2),
											substr($dtstart_date,6,2),
											substr($dtstart_date,0,2)
										)),
									);
								}
								// Last date in range -- treat as all-day but also show end time
								elseif ($loop_date == $dtend_date) {
									// If event ends at midnight, skip
									if ($dtend_time != '000000') {
										$ics_data['events'][$loop_date]['t'.$dtend_time][] = array(
											'label' => @$event->summary,
											'eventdesc' => @$event->description,
											'location' => @$event->location,
											'sublabel' => __('Ends', 'r34ics') . ' ' . date_i18n(get_option('time_format'), mktime(
												substr($dtend_time,0,2),
												substr($dtend_time,2,2),
												substr($dtend_time,4,2),
												substr($dtend_date,4,2),
												substr($dtend_date,6,2),
												substr($dtend_date,0,2)
											)),
											'end' => date_i18n(get_option('time_format'), mktime(
												substr($dtend_time,0,2),
												substr($dtend_time,2,2),
												substr($dtend_time,4,2),
												substr($dtend_date,4,2),
												substr($dtend_date,6,2),
												substr($dtend_date,0,2)
											)),
										);
									}
								}
								$loop_date = date_i18n('Ymd', mktime(0,0,0, intval(substr($loop_date,4,2)), intval(substr($loop_date,6,2)) + 1, intval(substr($loop_date,0,4))));
							}
						}
						// All-day events
						elseif ($all_day) {
							$ics_data['events'][$dtstart_date]['all-day'][] = array(
								'label' => @$event->summary,
								'eventdesc' => @$event->description,
								'location' => @$event->location,
							);
						}
						// Events with start/end times
						else {
							$ics_data['events'][$dtstart_date]['t'.$dtstart_time][] = array(
								'label' => @$event->summary,
								'eventdesc' => @$event->description,
								'location' => @$event->location,
								'start' => date_i18n(get_option('time_format'), mktime(
									substr($dtstart_time,0,2),
									substr($dtstart_time,2,2),
									substr($dtstart_time,4,2),
									substr($dtstart_date,4,2),
									substr($dtstart_date,6,2),
									substr($dtstart_date,0,2)
								)),
								'end' => date_i18n(get_option('time_format'), mktime(
									substr($dtend_time,0,2),
									substr($dtend_time,2,2),
									substr($dtend_time,4,2),
									substr($dtend_date,4,2),
									substr($dtend_date,6,2),
									substr($dtend_date,0,2)
								)),
							);
						}
					}
				}
			}
		
			// If no events, create empty array for today to allow calendars to build
			if (empty($ics_data['events'])) {
				$ics_data['events'] = array(date_i18n('Ymd') => array());
			}

			// Remove out-of-range dates
			if (!empty($ics_data['events'])) {
				$first_date = date_i18n('Ymd');
				foreach (array_keys((array)$ics_data['events']) as $date) {
					switch (@$args['view']) {
						case 'currentweek': // Rolling date range from start of previous week to end of next week
							$cw1 = r34ics_first_day_of_current('week');
							$pw1 = mktime(0,0,0,date('n',$cw1),date('j',$cw1)-7,date('Y',$cw1));
							$nw7 = mktime(0,0,0,date('n',$cw1),date('j',$cw1)+13,date('Y',$cw1));
							$first_date = date_i18n('Ymd', $pw1);
							$limit_date = date_i18n('Ymd', $nw7);
							break;
						case 'list':
							$first_date = date_i18n('Ymd');
							$limit_date = date_i18n('Ymd', mktime(0,0,0,date_i18n('n'),date_i18n('j')+$this->limit_days,date_i18n('Y')));
							break;
						case 'month':
						default:
							$first_date = date_i18n('Ymd', r34ics_first_day_of_current('month'));
							$limit_date = date_i18n('Ymd', mktime(0,0,0,date_i18n('n'),date_i18n('j')+$this->limit_days,date_i18n('Y')));
							break;
					}
					if ($date < $first_date || $date > $limit_date) { unset($ics_data['events'][$date]); }
					else { ksort($ics_data['events'][$date]); }
				}
			}

			// Sort events
			ksort($ics_data['events']);

			// Split events into year/month/day groupings and determine earliest and latest dates along the way
			foreach ((array)$ics_data['events'] as $date => $events) {
				$year = substr($date,0,4);
				$month = substr($date,4,2);
				$day = substr($date,6,2);
				$ym = substr($date,0,6);
				$ics_data['events'][$year][$month][$day] = $events;
				unset($ics_data['events'][$date]);
				switch (@$args['view']) {
					case 'currentweek':
						if (!isset($ics_data['earliest']) || $date < $ics_data['earliest']) { $ics_data['earliest'] = $date; }
						if (!isset($ics_data['latest']) || $date > $ics_data['latest']) { $ics_data['latest'] = $date; }
						break;
					case 'list':
					case 'month':
					default:
						if (!isset($ics_data['earliest']) || $ym < $ics_data['earliest']) { $ics_data['earliest'] = $ym; }
						if (!isset($ics_data['latest']) || $ym > $ics_data['latest']) { $ics_data['latest'] = $ym; }
						break;
				}
			}

			// Override defaults with inputs
			if (!empty($args['title'])) {
				$ics_data['title'] = ($args['title'] == 'none') ? false : $args['title'];
			}
			if (!empty($args['description'])) {
				$ics_data['description'] = ($args['description'] == 'none') ? false : $args['description'];
			}
		
			// Write ICS data to transient
			set_transient($transient_name, $ics_data, 600);

		}

		// Render template
		switch (@$args['view']) {
			case 'currentweek':
				include(plugin_dir_path(__FILE__) . '/templates/calendar-currentweek.php');
				break;
			case 'list':
				include(plugin_dir_path(__FILE__) . '/templates/calendar-list.php');
				break;
			case 'month':
			default:
				include(plugin_dir_path(__FILE__) . '/templates/calendar-month.php');
				break;
		}
	}


	public function editor_button() {
		// Add "Add Calendar" button to the editor
		add_action('media_buttons', function() {
			$current_screen = get_current_screen();
			if (isset($current_screen->parent_file) && strpos($current_screen->parent_file, 'edit.php') !== false) {
				// Display button
				include_once(plugin_dir_path(__FILE__) . '/templates/admin-add-calendar-button.php');
			}
		}, 20);

		// Add modal for "Add Calendar"
		add_action('admin_print_footer_scripts', function() {
			include_once(plugin_dir_path(__FILE__) . '/templates/admin-add-calendar.php');
		}, 10);
	}


	public function enqueue_scripts() {
		wp_enqueue_script('ics-calendar', plugin_dir_url(__FILE__) . 'assets/script.js', array('jquery'));
		wp_enqueue_style('ics-calendar', plugin_dir_url(__FILE__) . 'assets/style.css', false, $this->version);
	}


	public function first_dow($date=null) {
		if (empty($date)) { $date = current_time(); }
		return date_i18n('w',mktime(0,0,0,date_i18n('n',$date),1,date_i18n('Y',$date)));
	}


	public function get_days_of_week($format=null) {
		$days_of_week = $this->days_of_week($format);

		// Shift sequence of days based on site configuration
		$start_of_week = get_option('start_of_week', 0);
		for ($i = 0; $i < $start_of_week; $i++) {
			$day = $days_of_week[$i];
			unset($days_of_week[$i]);
			$days_of_week[$i] = $day;
		}

		return $days_of_week;
	}


	public function shortcode($atts) {

		// Extract attributes
		extract(shortcode_atts(array(
			'count' => null,
			'currentweek' => null,
			'description' => null,
			'eventdesc' => null,
			'format' => null,
			'hidetimes' => null,
			'location' => null,
			'reload' => false,
			'showendtimes' => null,
			'title' => null,
			'toggle' => null,
			'url' => null,
			'view' => null,
		), $atts));

		// Get the calendar output
		ob_start();
		$this->display_calendar($url, array(
			'count' => $count,
			'currentweek' => $currentweek,
			'description' => $description,
			'eventdesc' => $eventdesc,
			'format' => $format,
			'hidetimes' => $hidetimes,
			'location' => $location,
			'showendtimes' => $showendtimes,
			'title' => $title,
			'toggle' => $toggle,
			'view' => (!empty($currentweek) ? 'currentweek' : $view), // Backwards compatibility for "currentweek" option from version 2.0.5

		), $reload);
		return ob_get_clean();
	}


	private function _load_parser() {
		include_once($this->ical_path);
		include_once($this->event_path);
		include_once($this->carbon_path);
		return true;
	}

}


// Get first day of current week/month/year
function r34ics_first_day_of_current($interval) {
	$first_day = false;
	switch ($interval) {
		case 'year':
			$first_day = mktime(0,0,0,1,1,date_i18n('Y'));
			break;
		case 'week':
			$start_of_week = get_option('start_of_week', 0);
			$this_day = date_i18n('w');
			$days_offset = $this_day - $start_of_week;
			if ($days_offset < 0) { $days_offset = $days_offset + 7; }
			$first_day = mktime(0,0,0,date_i18n('n'),date_i18n('j')-$days_offset,date_i18n('Y'));
			break;
		case 'month':
		default:
			$first_day = mktime(0,0,0,date_i18n('n'),1,date_i18n('Y'));
			break;
	}
	return $first_day;
}


// Get last day of current week/month/year
function r34ics_last_day_of_current($interval) {
	$last_day = false;
	switch ($interval) {
		case 'year':
			$last_day = mktime(0,0,0,12,31,date_i18n('Y'));
			break;
		case 'week':
			$end_of_week = get_option('start_of_week', 0) - 1;
			if ($end_of_week < 0) { $end_of_week = $end_of_week + 7; }
			$this_day = date_i18n('w');
			$days_offset = $end_of_week - $this_day;
			if ($days_offset < 0) { $days_offset = $days_offset + 7; }
			$last_day = mktime(0,0,0,date_i18n('n'),date_i18n('j')+$days_offset,date_i18n('Y'));
			break;
		case 'month':
		default:
			$last_day = mktime(0,0,0,date_i18n('n'),date_i18n('t'),date_i18n('Y'));
			break;
	}
	return $last_day;
}


// Retrieve file from remote server with fallback methods
// Based on: https://stackoverflow.com/a/21177510
function r34ics_url_get_contents($url, $recursion=false) {
	$url_contents = null;
	// Some servers (e.g. Airbnb) will require a user_agent string or return 403 Forbidden
	ini_set('user_agent', 'ICS Calendar for WordPress');
	// Attempt to use cURL functions
	if (defined('CURLVERSION_NOW') && function_exists('curl_exec')) { 
		$conn = curl_init($url);
		curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
		curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
		$url_contents = (curl_exec($conn));
		curl_close($conn);
	}
	// Attempt to use fopen functions
	if (empty($url_contents) && ini_get('allow_url_fopen')) {
		if (function_exists('file_get_contents')) {
			$url_contents = file_get_contents($url);
		}
		elseif (function_exists('fopen') && function_exists('stream_get_contents')) {
			$handle = fopen($url, "r");
			$url_contents = stream_get_contents($handle);
		}
	}
	// Redirect for Outlook "Found" links (@todo Figure out why this is happening)
	if (!$recursion && strpos($url_contents,'">Found</a>') !== false) {
		preg_match('/<a href="([^"]+)"/', $url_contents, $url_match);
		if (isset($url_match[1])) {
			$url_contents = r34ics_url_get_contents($url_match[1], true);
		}
	}
	// Cannot retrieve file
	if (empty($url_contents)) {
		$url_contents = false;
	}
	return $url_contents;
}


// Determine if it will be possible to retrieve a remote URL
function r34ics_url_open_allowed() {
	return (defined('CURLVERSION_NOW') || ini_get('allow_url_fopen'));
}


// Print an array with preformatted HTML -- for debugging only
function r34ics_pr($arr, $debug_overlay=true) {
	if (!current_user_can('manage_options')) { return false; }
	if (!empty($debug_overlay)) {
		echo '<div style="
				background: white;
				border-top: 10px solid orange;
				overflow: auto;
				padding: 1em 5%;
				position: fixed; top: calc(100% - 400px); right: 0; bottom: 0; left: 0;
				z-index: 99999;
			"><div style="
				background: red;
				color: white;
				cursor: pointer;
				font-family: sans-serif !important;
				font-size: 12px;
				font-weight: bold;
				padding: 0 5px;
				position: fixed; top: calc(100% - 380px); right: 2em;
				z-index: 2;
			" onclick="jQuery(this).parent().remove();">CLOSE</div>';
	}
	echo '<pre style="color: #191919 !important; font-size: 12px !important; font-family: Consolas, Inconsolata, \'PT Mono\', \'Andale Mono\', \'Input Mono\', Monaco, monospace !important;">';
	print_r($arr);
	echo '</pre>';
	if (!empty($debug_overlay)) {
		echo '</div>';
	}
}


// Initialize plugin
add_action('init', function() {
	global $R34ICS;
	$R34ICS = new R34ICS();
});


// Load text domain for translations
add_action('plugins_loaded', function() {
	load_plugin_textdomain('r34ics', FALSE, basename(plugin_dir_path(__FILE__)) . '/i18n/languages/');
});


// Flush rewrite rules when plugin is activated
register_activation_hook(__FILE__, function() { flush_rewrite_rules(); });
