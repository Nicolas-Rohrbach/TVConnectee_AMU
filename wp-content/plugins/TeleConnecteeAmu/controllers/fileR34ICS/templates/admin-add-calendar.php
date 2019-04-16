<style>
	#insert_r34ics {
		display: none;
		overflow: auto;
		position: fixed; top: 0; right: 0; bottom: 0; left: 0;
		z-index: 100050;
	}
	#insert_r34ics.open { display: block; }
	#insert_r34ics_overlay {
		background: #000000;
		display: block;
		position: fixed; top: 0; right: 0; bottom: 0; left: 0;
		opacity: 0.7;
	}
	#insert_r34ics_window {
		background: #ffffff;
		box-shadow: 1px 1px 5px #000000;
		min-height: 10rem;
		min-width: 240px;
		padding: 0;
		position: absolute; top: 3rem; right: auto; bottom: auto; left: 50%;
		transform: translateX(-50%);
	}
	#insert_r34ics_header {
		border-bottom: 1px solid #999999;
		font-size: 125%;
		height: 44px;
		line-height: 44px;
		padding: 0 50px 0 1.5em;
		position: absolute; top: 0; right: 0; bottom: auto; left: 0;
	}
	#insert_r34ics_close {
		cursor: pointer;
		font-size: 36px;
		height: 44px;
		line-height: 40px;
		position: absolute; top: 0; right: 0; bottom: auto; left: auto;
		text-align: center;
		width: 44px;
	}
	#insert_r34ics_content {
		margin-top: 44px;
		padding: 1.5em;
		position: relative;
	}
	#insert_r34ics_toggle_wrapper {
		display: none;
	}
</style>
<div id="insert_r34ics">
	<div id="insert_r34ics_overlay"></div>
	<div id="insert_r34ics_window">

			<div id="insert_r34ics_header">
				<strong>Add ICS Calendar</strong>
				<div id="insert_r34ics_close" title="Close">&times;</div>
			</div>

			<div id="insert_r34ics_content">
				<form action="#" method="get" id="insert_r34ics_form">
				
					<p class="field-block">
						<label for="insert_r34ics_url">ICS Subscribe URL: <span class="required">*</span></label><br />
						<input id="insert_r34ics_url" name="insert_r34ics_url" type="text" style="width: 100%;" /><br />
						<em><small>Be sure you are using a subscribe URL (ending in <code>.ics</code>), not a web calendar URL (ending in <code>.html</code>).</small></em>
					</p>
					
					<p class="field-block">
						<label for="insert_r34ics_title">Calendar Title:</label><br />
						<input id="insert_r34ics_title" name="insert_r34ics_title" type="text" style="width: 100%;" /><br />
						<em><small>Leave empty to use calendar's default title. Enter <code>none</code> to omit title altogether.</small></em>
					</p>
					
					<p class="field-block">
						<label for="insert_r34ics_description">Calendar Description:</label><br />
						<input id="insert_r34ics_description" name="insert_r34ics_description" type="text" style="width: 100%;" /><br />
						<em><small>Leave empty to use calendar's default description. Enter <code>none</code> to omit description altogether.</small></em>
					</p>
					
					<p class="field-block">
						<label for="insert_r34ics_view">View:</label><br />
						<select id="insert_r34ics_view" name="insert_r34ics_view" onchange="if (jQuery(this).val() == 'list') { jQuery('#r34ics_list_view_options').show(); } else { jQuery('#r34ics_list_view_options').hide(); }">
							<option value="month">month</option>
							<option value="list">list</option>
							<option value="currentweek">current week</option>
							<option value="">custom</option>
						</select><br />
						<em><small>For <strong>custom</strong> views, enter the view name manually after inserting the shortcode in your content.</small></em>
					</p>
					
					<p class="field-block" id="r34ics_list_view_options" style="display: none;">
						<label for="insert_r34ics_count">Count:</label>
						<input id="insert_r34ics_count" name="insert_r34ics_count" type="number" min="1" step="1" />
						&nbsp;&nbsp;
						<label for="insert_r34ics_format">Format:</label>
						<input id="insert_r34ics_format" name="insert_r34ics_format" type="text" value="l, F j" /><br />
						<em><small>Leave <strong>Count</strong> blank to include all upcoming events. <strong>Format</strong> must be a standard <a href="https://secure.php.net/manual/en/function.date.php" target="_blank">PHP date format string</a>.</small></em>
					</p>
					
					<p class="field-block">
						<input id="insert_r34ics_hidetimes" name="insert_r34ics_hidetimes" type="checkbox" onchange="if (jQuery(this).prop('checked') == true) { jQuery('#insert_r34ics_showendtimes').prop('checked',false); }" />
						<label for="insert_r34ics_hidetimes">Hide all times <em><small>(e.g. if times are included in event summary)</small></em></label>
					</p>
				
					<p class="field-block">
						<input id="insert_r34ics_showendtimes" name="insert_r34ics_showendtimes" type="checkbox" onchange="if (jQuery(this).prop('checked') == true) { jQuery('#insert_r34ics_hidetimes').prop('checked',false); }" />
						<label for="insert_r34ics_showendtimes">Always show end times <em><small>(by default, shown on hover only)</small></em></label>
					</p>
				
					<p class="field-block">
						<input id="insert_r34ics_eventdesc" name="insert_r34ics_eventdesc" type="checkbox" onchange="if (this.checked) { jQuery('#insert_r34ics_toggle_wrapper').show(); } else if (!this.checked && !jQuery('#insert_r34ics_location').prop('checked')) { jQuery('#insert_r34ics_toggle_wrapper').hide(); }" />
						<label for="insert_r34ics_eventdesc">Show event descriptions <em><small>(change to a number in inserted shortcode to set word limit)</small></em></label>
					</p>
				
					<p class="field-block">
						<input id="insert_r34ics_location" name="insert_r34ics_location" type="checkbox" onchange="if (this.checked) { jQuery('#insert_r34ics_toggle_wrapper').show(); } else if (!this.checked && !jQuery('#insert_r34ics_eventdesc').prop('checked')) { jQuery('#insert_r34ics_toggle_wrapper').hide(); }" />
						<label for="insert_r34ics_location">Show event locations <em><small>(if available)</small></em></label>
					</p>
					
					<p class="field-block" id="insert_r34ics_toggle_wrapper">
						<input id="insert_r34ics_toggle" name="insert_r34ics_toggle" type="checkbox" checked="checked" />
						<label for="insert_r34ics_toggle">Toggle event description/location <em><small>(click title to view)</small></em></label>
					</p>
					
					<p>
						<input name="insert" type="submit" class="button button-primary button-large" style="float: right;" value="Insert ICS Calendar" />
						<span class="required"><small>* Required field</small></span>
					</p>

				</form>
			</div>

	</div>
</div>
<script>
	jQuery('#add_r34ics').on('click', function() {
		jQuery('#insert_r34ics').addClass('open');
	});
	jQuery('#insert_r34ics_close, #insert_r34ics_overlay').on('click', function() {
		jQuery('#insert_r34ics').removeClass('open');
	});
	jQuery('#insert_r34ics_form').on('submit', function() {
		
		// Validate required fields
		if (jQuery('#insert_r34ics_url').val() == '') {
			alert('ICS Subscribe URL is required.');
			jQuery('#insert_r34ics_url').focus();
			return false;
		}
		
		// Concatenate shortcode
		var r34ics_shortcode = '[ics_calendar url="' + jQuery('#insert_r34ics_url').val().replace('"','') + '"';
		if (jQuery('#insert_r34ics_title').val() != '') {
			r34ics_shortcode += ' title="' + jQuery('#insert_r34ics_title').val().replace('"','') + '"';
		}
		if (jQuery('#insert_r34ics_description').val() != '') {
			r34ics_shortcode += ' description="' + jQuery('#insert_r34ics_description').val().replace('"','') + '"';
		}
		if (jQuery('#insert_r34ics_view').val() != '') {
			r34ics_shortcode += ' view="' + jQuery('#insert_r34ics_view').val().replace('"','') + '"';
		}
		if (jQuery('#insert_r34ics_view').val() == 'list' && parseInt(jQuery('#insert_r34ics_count').val()) > 0) {
			r34ics_shortcode += ' count="' + parseInt(jQuery('#insert_r34ics_count').val()) + '"';
		}
		if (jQuery('#insert_r34ics_view').val() == 'list' && jQuery('#insert_r34ics_format').val() != '') {
			r34ics_shortcode += ' format="' + jQuery('#insert_r34ics_format').val().replace('"','') + '"';
		}
		if (jQuery('#insert_r34ics_hidetimes').prop('checked') == true) {
			r34ics_shortcode += ' hidetimes="true"';
		}
		if (jQuery('#insert_r34ics_showendtimes').prop('checked') == true) {
			r34ics_shortcode += ' showendtimes="true"';
		}
		if (jQuery('#insert_r34ics_eventdesc').prop('checked') == true) {
			r34ics_shortcode += ' eventdesc="true"';
		}
		if (jQuery('#insert_r34ics_location').prop('checked') == true) {
			r34ics_shortcode += ' location="true"';
		}
		if (jQuery('#insert_r34ics_toggle').prop('checked') == true) {
			r34ics_shortcode += ' toggle="true"';
		}
		r34ics_shortcode += ']';
	
		// Insert shortcode and close window
		window.send_to_editor(r34ics_shortcode);
		/*window.send_to_editor('[ics_calendar url="URL" title="TITLE" description="DESCRIPTION" view="month" count="15" format="l, F j" hidetimes="true" showendtimes="true" eventdesc="true" location="true"]');*/
		jQuery('#insert_r34ics_form')[0].reset();
		jQuery('#r34ics_list_view_options').hide();
		jQuery('#insert_r34ics').removeClass('open');
		return false;
	});

	/*
	function InsertCalendar() {
		var form_id = jQuery("#add_form_id").val();
		if (form_id == "") {
			alert(<?php echo json_encode(__('Please select a form', 'gravityforms')); ?>);
			return;
		}

		var form_name = jQuery("#add_form_id option[value='" + form_id + "']").text().replace(/[\[\]]/g, '');
		var display_title = jQuery("#display_title").is(":checked");
		var display_description = jQuery("#display_description").is(":checked");
		var title_qs = !display_title ? " title=\"false\"" : "";
		var description_qs = !display_description ? " description=\"false\"" : "";
		var ajax_qs = ajax ? " ajax=\"true\"" : "";

		window.send_to_editor("[gravityform id=\"" + form_id + "\" name=\"" + form_name + "\"" + title_qs + description_qs + "]");
	}
	*/
</script>
