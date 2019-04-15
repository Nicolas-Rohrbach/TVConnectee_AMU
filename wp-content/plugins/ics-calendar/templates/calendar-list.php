<?php
// Require object
if (empty($ics_data)) { return false; }

global $R34ICS;
global $wp_locale;

$days_of_week = $R34ICS->get_days_of_week();
$start_of_week = get_option('start_of_week', 0);

// Not currently used in this template; uncomment if needed in a future update
//$today = date_i18n('Ymd', current_time('timestamp'));

$date_format = !empty($args['format']) ? strip_tags($args['format']) : 'l, F j';

$ics_calendar_classes = array(
	'ics-calendar',
	(!empty($args['hidetimes']) ? ' hide_times' : ''),
	(!empty($args['toggle']) ? ' toggle' : ''),
);
?>

<section class="<?php echo esc_attr(implode(' ', $ics_calendar_classes)); ?>">

	<?php
	// Title and description
	if (!empty($ics_data['title'])) {
		?>
		<h2 class="ics-calendar-title"><?php echo $ics_data['title']; ?></h2>
		<?php
	}
	if (!empty($ics_data['description'])) {
		?>
		<p class="ics-calendar-description"><?php echo $ics_data['description']; ?></p>
		<?php
	}
	
	// Empty calendar message
	if (empty($ics_data['events'])) {
		?>
		<p class="ics-calendar-error"><?php _e('No events found.', 'r34ics'); ?></p>
		<?php
	}
	
	// Display calendar
	else {

		// Build monthly calendars
		$i = 0;
		foreach (array_keys((array)$ics_data['events']) as $year) {
			for ($m = 1; $m <= 12; $m++) {
				$month = $m < 10 ? '0' . $m : '' . $m;
				$ym = $year . $month;
				if ($ym < $ics_data['earliest']) { continue; }
				if ($ym > $ics_data['latest']) { break(2); }
				$first_date = mktime(0,0,0,$month,1,$year);
				$month_label = ucwords(date_i18n('F Y', $first_date));
								
				// Build month's calendar
				if (isset($ics_data['events'][$year][$month])) {
					?>
					<div class="ics-calendar-list-wrapper" data-year-month="<?php echo date_i18n('Ym', mktime(0,0,0,$month,1,$year)); ?>">
		
						<h3 class="ics-calendar-label"><?php echo $month_label; ?></h3>
						
						<?php
						foreach ((array)$ics_data['events'][$year][$month] as $day => $day_events) {
							?>
							<h4><?php echo date_i18n($date_format, strtotime($year . '-' . $month . '-' . $day)); ?></h4>
							<dl class="events">
								<?php
								foreach ((array)$day_events as $time => $events) {
									$all_day_indicator_shown = false;
									foreach ((array)$events as $event) {
										if ($time == 'all-day') {
											if (!$all_day_indicator_shown) {
												?>
												<dt class="all-day-indicator"><?php _e('All Day', 'r34ics'); ?></dt>
												<?php
												$all_day_indicator_shown = true;
											}
											?>
											<dd class="event">
												<span class="title<?php
												if ((!empty($args['eventdesc']) && !empty($event['eventdesc'])) || (!empty($args['location']) && !empty($event['location']))) {
													echo ' has_desc';
												}
												?>"><?php echo str_replace('/', '/<wbr />',$event['label']); ?></span>
												<?php
												if (!empty($event['sublabel'])) {
													?>
													<span class="sublabel"><?php echo str_replace('/', '/<wbr />',$event['sublabel']); ?></span>
													<?php
												}
												if (!empty($args['eventdesc']) && !empty($event['eventdesc'])) {
													if (intval($args['eventdesc']) > 1) {
														?>
														<div class="eventdesc" title="<?php echo esc_attr($event['eventdesc']); ?>"><?php echo make_clickable(nl2br(wp_trim_words($event['eventdesc'], intval($args['eventdesc'])))); ?></div>
														<?php
													}
													else {
														?>
														<div class="eventdesc"><?php echo make_clickable(nl2br($event['eventdesc'])); ?></div>
														<?php
													}
												}
												if (!empty($args['location']) && !empty($event['location'])) {
													?>
													<div class="location"><?php echo make_clickable(nl2br($event['location'])); ?></div>
													<?php
												}
												?>
											</dd>
											<?php
										}
										else {
											if (!empty($event['start'])) {
												?>
												<dt class="time"><?php
												echo $event['start'];
												if (!empty($event['end']) && $event['end'] != $event['start']) {
													if (empty($args['showendtimes'])) {
														?>
														<span class="show_on_hover">&#8211; <?php echo $event['end']; ?></span>
														<?php
													}
													else {
														?>
														&#8211; <?php echo $event['end']; ?>
														<?php
													}
												}
												?></dt>
												<?php
											}
											?>
											<dd class="event">
												<span class="title<?php
												if ((!empty($args['eventdesc']) && !empty($event['eventdesc'])) || (!empty($args['location']) && !empty($event['location']))) {
													echo ' has_desc';
												}
												?>"><?php echo str_replace('/', '/<wbr />',$event['label']); ?></span>
												<?php
												if (!empty($event['sublabel'])) {
													?>
													<span class="sublabel"><?php
													if (empty($event['start']) && !empty($event['end'])) {
														?>
														<span class="carryover">&#10554;</span>
														<?php
													}
													echo str_replace('/', '/<wbr />',$event['sublabel']);
													?></span>
													<?php
												}
												if (!empty($args['eventdesc']) && !empty($event['eventdesc'])) {
													if (intval($args['eventdesc']) > 1) {
														?>
														<div class="eventdesc" title="<?php echo esc_attr($event['eventdesc']); ?>"><?php echo make_clickable(nl2br(wp_trim_words($event['eventdesc'], intval($args['eventdesc'])))); ?></div>
														<?php
													}
													else {
														?>
														<div class="eventdesc"><?php echo make_clickable(nl2br($event['eventdesc'])); ?></div>
														<?php
													}
												}
												if (!empty($args['location']) && !empty($event['location'])) {
													?>
													<div class="location"><?php echo make_clickable(nl2br($event['location'])); ?></div>
													<?php
												}
												?>
											</dd>
											<?php
										}
										$i++;
										if (!empty($args['count']) && $i >= intval($args['count'])) { break(5); }
									}
								}
								?>
							</dl>
							<?php
						}
						?>
		
					</div>
					<?php
				}
			}
		}
	}
	?>

</section>