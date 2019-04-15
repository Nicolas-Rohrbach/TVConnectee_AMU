<style type="text/css">

.r34ics .columns-2 {
	display: table;
}

	.r34ics .columns-2 .column-1 {
		display: table-cell;
		padding-right: 15px;
		width: calc(100% - 280px);
	}

	.r34ics .columns-2 .column-2 {
		display: table-cell;
		width: 280px;
	}

@media screen and (max-width: 782px) {

	.r34ics .columns-2 {
		display: block;
	}

		.r34ics .columns-2 .column-1 {
			display: block;
			width: 100%;
		}


		.r34ics .columns-2 .column-2 {
			display: block;
			width: 100%;
		}

}

</style>

<div class="wrap r34ics">

	<h1>ICS Calendar</h1>
	
	<h2>User Guide</h2>

	<div class="metabox-holder columns-2">
	
		<div class="column-1">
		
			<div class="postbox">

				<h3 class="hndle"><span>Basic Shortcode Example</span></h3>
		
				<div class="inside">
	
					<p>To insert an ICS calendar in a page, use the following shortcode format, replacing the all-caps text with your information as appropriate.</p>
	
					<p><input type="text" name="null" readonly="readonly" value="[ics_calendar url=&quot;CALENDAR_FEED_URL&quot; title=&quot;DISPLAY_TITLE&quot; description=&quot;DISPLAY_DESCRIPTION&quot;]" style="width: 97%; background: white;" onclick="this.select();" /></p>
		
					<h4>Calendar Feed URL</h4>
		
					<p>Be sure you are using a <strong>subscribe</strong> URL (which may end in <code>.ics</code> or have no filename extension), not a web calendar URL (ending in <code>.html</code>).</p>
		
					<h4>Display Title and Description</h4>
		
					<p>The <code>title</code> and <code>description</code> attributes are optional. If omitted, the title and description provided by the calendar feed will be displayed. Use "none" (e.g. <code>title="none"</code>) to hide the title or description altogether.</p>
		
				</div>
	
			</div>

			<div class="postbox">

				<h3 class="hndle"><span>View/Layout Options</span></h3>
		
				<div class="inside">
	
					<h4>Month View</h4>
	
					<p>The default display is a month calendar grid. The month grid collapses to a CSS-styled list at phone screen sizes. You can use this view by setting <code>view="month"</code> or omitting this attribute entirely.</p>

					<h4>Current Week View</h4>
	
					<p>You can display just the current week (with a selector to choose the previous and next week) in a grid style similar to month view by using <code>view="currentweek"</code>. If desired, the selector can be hidden using custom CSS.</p>
	
					<h4>List View</h4>

					<p>To display upcoming events as a plain list on all screen sizes (which you can style with your own CSS), add <code>view="list"</code> to the shortcode, with the optional <code>count="5"</code> attribute to indicate the number of events to display. (By default, <em>all</em> upcoming events will be displayed.)</p>
	
					<p>By default list view will display dates in the U.S. standard day-month-date format (e.g. "Thursday, March 14"). To customize the format to your locale, you can use standard <a href="https://secure.php.net/manual/en/function.date.php" target="_blank">PHP date format strings</a> with the <code>format</code> attribute. For example, to use the day-month format (e.g. "14 March"), use <code>format="j F"</code>, or for an abbreviated numbered month/day format (e.g. "Thu 3/14"), use <code>format="D n/j"</code>.</p>
						
					<p><em><strong>Note:</strong> The <code>count</code>, <code>format</code> and <code>toggle</code> attributes are supported in list view only.</em></p>
		
				</div>
	
			</div>

			<div class="postbox">

				<h3 class="hndle"><span>Event Display Options</span></h3>
		
				<div class="inside">
	
					<h4>Time Display</h4>
	
					<p>By default, start times are always displayed, and end times are displayed on hover. To hide all times (for instance, if the times are also in your event description), add the <code>hidetimes="true"</code> attribute. Conversely, to <em>always</em> display end times (not just on hover), add the <code>showendtimes="true"</code> attribute.</p>
	
					<h4>Event Descriptions</h4>
	
					<p>Use the <code>eventdesc="true"</code> attribute to display event descriptions. Note: In the month view, descriptions will display as tooltips on hover; in the list view, descriptions will display in full on the page below the event title. In the list view, you can choose to display an excerpt of the description by entering the number of words to show, e.g. <code>eventdesc="12"</code>. Hovering over the shortened description will show the full description in a tooltip. Month view always shows the full description.</p>
	
					<h4>Event Locations</h4>
	
					<p>Use the <code>location="true"</code> attribute to display event locations (if available). Note: In the month view, locations will display as tooltips on hover; in the list view, locations will display in full on the page below the event title (and description, if shown).</p>
					
					<h4>Toggle Descriptions and Locations &#8212; <em>List View Only</em></h4>
					
					<p>If your event descriptions are long, you may wish to use <code>toggle="true"</code> to turn on click-to-toggle for descriptions. Users can click an event's title to view its description.</p>
		
				</div>
	
			</div>
		
		</div>
	
		<div class="column-2">

			<div class="postbox">

				<h3 class="hndle"><span>Support</span></h3>
		
				<div class="inside">
	
					<p>For support please email <a href="mailto:support@room34.com">support@room34.com</a> or use the <a href="https://wordpress.org/support/plugin/ics-calendar" target="_blank">WordPress Support Forums</a>.</p>
		
				</div>

			</div>

			<div class="postbox">

				<h3 class="hndle"><span>Thank You!</span></h3>
		
				<div class="inside">
	
					<a href="https://room34.com/about/payments/?type=WordPress+Plugin&plugin=ICS+Calendar&amt=9" target="_blank"><img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/room34_logo.png" alt="Room 34 Creative Services" style="display: block; height: auto; margin: 0 auto 0.5em auto; width: 200px;" /></a> 
		
					<p>This plugin is free to use. However, if you find it to be of value, we welcome your donation (suggested amount: USD $9), to help fund future development.</p>

					<p><a href="https://room34.com/about/payments/?type=WordPress+Plugin&plugin=ICS+Calendar&amt=9" target="_blank" class="button button-primary">Make a Donation</a></p>
		
				</div>
		
			</div>
		
		</div>
	
	</div>

</div>